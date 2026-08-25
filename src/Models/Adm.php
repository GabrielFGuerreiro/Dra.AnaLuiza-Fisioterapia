<?php
namespace DraAnaLuiza\Models;
use DraAnaLuiza\Models\Database;
use PDO;
use PDOException;

class Adm
{
    public function ListarDepoimentos(?bool $ativo = null): array
    {
        try
        {
            $pdo = (new Database())->getConnection();
            $sql = "SELECT idDepoimento, dsDepoimento, nmPaciente, ativo, caminhoArquivo
                    FROM Depoimentos
                    WHERE (ativo = :ativo OR :ativo IS NULL) AND dtExclusao IS NULL
                    ORDER BY idDepoimento DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':ativo' => $ativo]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        catch (PDOException $e)
        {
            return [];
        }
    }

    public function ListarAgendamentos(): array
    {
        try
        {   
            $db = new Database();
            $pdo = $db->getConnection();
            $sql = "SELECT
                        pc.idPreConsulta AS id,
                        CASE WHEN pc.status = 'proposta_enviada' THEN CONCAT('Proposta: ', u.nmUsuario) ELSE u.nmUsuario END AS title,
                        CONCAT(pc.dtConsulta, 'T', pc.horarioInicial) AS start,
                        CONCAT(pc.dtConsulta, 'T', pc.horarioFinal) AS end,
                        CASE WHEN pc.status = 'proposta_enviada' THEN '#b78935' ELSE '#577A61' END AS color
                    FROM PreConsultas pc
                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                    WHERE pc.status IN ('confirmada', 'proposta_enviada')";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        catch (PDOException $e)
        {
            return [];
        }
    }

    public function ObterObservacaoAgendamento(int $id): ?string
    {
        try {
            $pdo = (new Database())->getConnection();
            $stmt = $pdo->prepare("SELECT observacao FROM PreConsultas WHERE idPreConsulta = :id LIMIT 1");
            $stmt->execute([':id' => $id]);
            $observacao = $stmt->fetchColumn();
            return $observacao !== false ? (string) $observacao : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function CadastrarDepoimento(string $opiniao, string $nomePaciente, array $arquivo): Array
    {
        $opiniao = trim($opiniao);
        $nomePaciente = trim($nomePaciente);
        $temArquivo = !empty($arquivo) && isset($arquivo['error']) && $arquivo['error'] !== UPLOAD_ERR_NO_FILE;
        if (!$temArquivo) {
            return ['sucesso' => false, 'msg' => 'Selecione uma imagem ou um vídeo para o depoimento.'];
        }
        $ehVideo = $temArquivo && (
            (isset($arquivo['type']) && str_starts_with((string) $arquivo['type'], 'video/')) ||
            in_array(strtolower(pathinfo($arquivo['name'] ?? '', PATHINFO_EXTENSION)), ['mp4', 'mkv', 'avi', 'mov', 'webm'], true)
        );
        if (!$ehVideo && ($nomePaciente === '' || $opiniao === '')) {
            return ['sucesso' => false, 'msg' => 'Informe o nome e o relato do paciente.'];
        }

        $caminho = null;

        if ($temArquivo)
        {
            if ($arquivo['error'] !== UPLOAD_ERR_OK) {
                return [
                    'sucesso' => false,
                    'msg' => 'Erro no Upload do Arquivo.'
                ];
            }

            $pastaDestino = RAIZ . "/arquivosDepoimentos";
            if (!is_dir($pastaDestino))
                mkdir($pastaDestino, 0777, true);

            $nomeArq = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $arquivo["name"]);
            $caminho = "$pastaDestino/$nomeArq";

            if (!move_uploaded_file($arquivo["tmp_name"], $caminho)) {
                return [
                    'sucesso' => false,
                    'msg' => 'Erro ao Mover o Arquivo.'
                ];
            }
        }
            
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $sql = "INSERT INTO DEPOIMENTOS (nmPaciente, dsDepoimento, caminhoArquivo, dtExclusao, ativo) VALUES (:nome, :opiniao, :caminho, null, 1)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ":opiniao" => $opiniao,
                ':nome' => $nomePaciente,
                ':caminho' => $caminho
            ]);
        
            return [
                'sucesso' => true,
                'msg' => 'Depoimento Salvo Com Sucesso!'
            ];
        }
        catch (PDOException  $th)
        {
            return [
                'sucesso' => false,
                'msg' => "Erro: {$th->getMessage()}."
            ];
        }
    }

    public function ListarPreConsultasPendentes(): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();
            $sql = "SELECT
                        pc.idPreConsulta,
                        u.nmUsuario,
                        pc.dtConsulta,
                        pc.horarioInicial,
                        pc.horarioFinal,
                        pc.observacao
                    FROM PreConsultas pc
                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                    WHERE pc.status = 'pendente'
                    ORDER BY pc.idPreConsulta DESC";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        catch (PDOException $e)
        {
            return [];
        }
    }

    public function ConfirmarConsulta(?int $idPreConsulta): array
    {
        try
        {
            $pdo = (new Database())->getConnection();

            if (!$idPreConsulta) return ['sucesso' => false, 'mensagem' => 'Pré-consulta inválida.'];

            $dados = $pdo->prepare("SELECT u.nmUsuario, u.celular, pc.dtConsulta, pc.horarioInicial, pc.horarioFinal
                                    FROM PreConsultas pc
                                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                                    WHERE pc.idPreConsulta = :id AND pc.status = 'pendente'");
            $dados->execute([':id' => $idPreConsulta]);
            $consulta = $dados->fetch(PDO::FETCH_ASSOC);

            if (!$consulta) return ['sucesso' => false, 'mensagem' => 'Esta pré-consulta já foi processada ou não existe.'];

            if (!$this->DataEHorarioValidos($consulta['dtConsulta'], substr($consulta['horarioInicial'], 0, 5)))
                return ['sucesso' => false, 'mensagem' => 'A data ou o horário solicitado já não é válido. Envie uma nova proposta ao paciente.'];

            $sql = "UPDATE PreConsultas
                    SET status = 'confirmada'
                    WHERE idPreConsulta = :idPreConsulta AND status = 'pendente'";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':idPreConsulta' => $idPreConsulta
            ]);

            $mensagemWhatsApp = "Olá, {$consulta['nmUsuario']}!\n\nSua consulta foi confirmada para " . date('d/m/Y', strtotime($consulta['dtConsulta'])) .
                " das " . substr($consulta['horarioInicial'], 0, 5) . " às " . substr($consulta['horarioFinal'], 0, 5) .
                ".\n\nA Dra. Ana Luiza agradece o contato.";

            return [
                'sucesso' => true,
                'mensagem' => 'Consulta confirmada. Envie a confirmação ao paciente pelo WhatsApp.',
                'whatsappUrl' => $this->CriarLinkWhatsApp($consulta['celular'], $mensagemWhatsApp)
            ];
        }
        catch (PDOException $e)
        {
            return [
                'sucesso' => false,
                'mensagem' => 'Não foi possível confirmar a consulta no momento.'
            ];
        }
    }

    public function ProporHorario(?int $idPreConsulta, string $dtConsulta, string $horarioInicial, string $mensagem): array
    {
        $mensagem = trim($mensagem);
        if (!$idPreConsulta || !$this->DataEHorarioValidos($dtConsulta, $horarioInicial))
            return ['sucesso' => false, 'mensagem' => 'Informe uma data futura e um horário válido para a proposta.'];

        $horarioFinal = date('H:i:s', strtotime($horarioInicial . ' +1 hour'));

        try
        {
            $pdo = (new Database())->getConnection();
            $dados = $pdo->prepare("SELECT u.nmUsuario, u.celular
                                    FROM PreConsultas pc
                                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                                    WHERE pc.idPreConsulta = :id AND pc.status = 'pendente'");
            $dados->execute([':id' => $idPreConsulta]);
            $consulta = $dados->fetch(PDO::FETCH_ASSOC);
            if (!$consulta) return ['sucesso' => false, 'mensagem' => 'Esta pré-consulta já foi processada ou não existe.'];

            $stmt = $pdo->prepare("UPDATE PreConsultas
                                   SET dtConsulta = :dtConsulta, horarioInicial = :horarioInicial, horarioFinal = :horarioFinal,
                                       status = 'proposta_enviada'
                                   WHERE idPreConsulta = :id AND status = 'pendente'");
            $stmt->execute([
                ':dtConsulta' => $dtConsulta,
                ':horarioInicial' => $horarioInicial,
                ':horarioFinal' => $horarioFinal,
                ':id' => $idPreConsulta
            ]);

            $mensagemWhatsApp = "Olá, {$consulta['nmUsuario']}!\n\nA Dra. Ana Luiza propôs o atendimento para " . date('d/m/Y', strtotime($dtConsulta)) .
                " das " . substr($horarioInicial, 0, 5) . " às " . substr($horarioFinal, 0, 5) . "." .
                ($mensagem !== '' ? "\n\nMensagem da clínica: {$mensagem}" : '') .
                "\n\nSe esse horário não funcionar para você, entre em contato para verificarmos outra possibilidade.";

            return [
                'sucesso' => true,
                'mensagem' => 'Nova proposta registrada. Envie-a ao paciente pelo WhatsApp.',
                'whatsappUrl' => $this->CriarLinkWhatsApp($consulta['celular'], $mensagemWhatsApp)
            ];
        }
        catch (\Throwable $e)
        {
            return ['sucesso' => false, 'mensagem' => 'Não foi possível enviar a nova proposta.'];
        }
    }

    public function IndisponibilizarConsulta(?int $idPreConsulta, string $mensagem): array
    {
        $mensagem = trim($mensagem);
        if (!$idPreConsulta || $mensagem === '') {
            return ['sucesso' => false, 'mensagem' => 'Explique ao paciente por que o horário não está disponível.'];
        }

        try
        {
            $pdo = (new Database())->getConnection();
            $dados = $pdo->prepare("SELECT u.nmUsuario, u.celular
                                    FROM PreConsultas pc
                                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                                    WHERE pc.idPreConsulta = :id AND pc.status = 'pendente'");
            $dados->execute([':id' => $idPreConsulta]);
            $consulta = $dados->fetch(PDO::FETCH_ASSOC);
            if (!$consulta) return ['sucesso' => false, 'mensagem' => 'Esta pré-consulta já foi processada ou não existe.'];

            $stmt = $pdo->prepare("UPDATE PreConsultas
                                   SET status = 'indisponivel'
                                   WHERE idPreConsulta = :id AND status = 'pendente'");
            $stmt->execute([':id' => $idPreConsulta]);

            $mensagemWhatsApp = "Olá, {$consulta['nmUsuario']}!\n\nNo momento, não foi possível atender à solicitação no horário desejado.\n\nMensagem da clínica: {$mensagem}\n\nEntre em contato para verificarmos novas possibilidades de agendamento.";

            return [
                'sucesso' => true,
                'mensagem' => 'Indisponibilidade registrada. Informe o paciente pelo WhatsApp.',
                'whatsappUrl' => $this->CriarLinkWhatsApp($consulta['celular'], $mensagemWhatsApp)
            ];
        }
        catch (\Throwable $e)
        {
            return ['sucesso' => false, 'mensagem' => 'Não foi possível registrar a indisponibilidade.'];
        }
    }

    private function DataEHorarioValidos(string $data, string $horario): bool
    {
        $dataHora = \DateTime::createFromFormat('Y-m-d H:i', "{$data} {$horario}");
        return $dataHora && $dataHora->format('Y-m-d H:i') === "{$data} {$horario}" && $dataHora >= new \DateTime('today');
    }

    private function CriarLinkWhatsApp(string $celular, string $mensagem): ?string
    {
        $numero = preg_replace('/\D/', '', $celular);
        if (str_starts_with($numero, '0')) $numero = substr($numero, 1);
        if (!str_starts_with($numero, '55')) $numero = '55' . $numero;

        return strlen($numero) >= 12 && strlen($numero) <= 15
            ? 'https://wa.me/' . $numero . '?text=' . rawurlencode($mensagem)
            : null;
    }

    public function ExcluirDepoimento(int $id): bool
    {
        try
        {
            $pdo = (new Database())->getConnection();
            $stmt = $pdo->prepare("UPDATE Depoimentos SET dtExclusao = NOW() WHERE idDepoimento = :id");
            return $stmt->execute([':id' => $id]);
        }
        catch (PDOException $e)
        {
            return false;
        }
    }
    public function EditarDepoimento(int $id, string $opiniao, string $nomePaciente): bool
    {
        try
        {
            $pdo = (new Database())->getConnection();
            $stmt = $pdo->prepare("UPDATE Depoimentos SET dsDepoimento = :opiniao, nmPaciente = :nome WHERE idDepoimento = :id");
            return $stmt->execute([':opiniao' => trim($opiniao), ':nome' => trim($nomePaciente) ?: null, ':id' => $id]);
        }
        catch (PDOException $e)
        {
            return false;
        }
    }

    public function AlternarDepoimento(int $id): bool
    {
        try
        {
            $pdo = (new Database())->getConnection();
            $stmt = $pdo->prepare("UPDATE Depoimentos SET ativo = IF(ativo = 1, 0, 1) WHERE idDepoimento = :id");
            return $stmt->execute([':id' => $id]);
        }
        catch (PDOException $e)
        {
            return false;
        }
    }
}

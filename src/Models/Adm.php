<?php
namespace DraAnaLuiza\Models;
use DraAnaLuiza\Models\Database;
use DraAnaLuiza\Services\EmailService;
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
                        u.nmUsuario AS title,
                        CONCAT(pc.dtConsulta, 'T', pc.horarioInicial) AS start,
                        CONCAT(pc.dtConsulta, 'T', pc.horarioFinal) AS end
                    FROM PreConsultas pc
                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                    WHERE pc.dtConsulta IS NOT NULL";

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
                        pc.horarioInicial,
                        pc.horarioFinal,
                        pc.observacao
                    FROM PreConsultas pc
                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                    WHERE pc.dtConsulta IS NULL
                      AND (pc.observacao IS NULL OR pc.observacao NOT LIKE '%STATUS: NEGADA%')
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

    public function ConfirmarConsulta($idPreConsulta, string $dtConsulta, string $horarioInicial, string $horarioFinal): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $dados = $pdo->prepare("SELECT u.nmUsuario, u.email
                                    FROM PreConsultas pc
                                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                                    WHERE pc.idPreConsulta = :id AND pc.dtConsulta IS NULL");
            $dados->execute([':id' => $idPreConsulta]);
            $consulta = $dados->fetch(PDO::FETCH_ASSOC);
            if (!$consulta) {
                return ['sucesso' => false, 'mensagem' => 'Esta pré-consulta já foi processada ou não existe.'];
            }

            $sql = "UPDATE PreConsultas
                    SET dtConsulta = :dtConsulta, horarioInicial = :horarioInicial, horarioFinal = :horarioFinal
                    WHERE idPreConsulta = :idPreConsulta";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':dtConsulta' => $dtConsulta,
                ':horarioInicial' => $horarioInicial,
                ':horarioFinal' => $horarioFinal,
                ':idPreConsulta' => $idPreConsulta
            ]);

            $enviado = EmailService::enviar(
                $consulta['email'],
                'Sua consulta foi confirmada',
                "Olá, {$consulta['nmUsuario']}!\n\nSua consulta foi confirmada para " . date('d/m/Y', strtotime($dtConsulta)) .
                " das " . substr($horarioInicial, 0, 5) . " às " . substr($horarioFinal, 0, 5) .
                ".\n\nA Dra. Ana Luiza agradece o contato."
            );

            return [
                'sucesso' => true,
                'mensagem' => $enviado ? 'Consulta confirmada e e-mail enviado ao paciente!' : 'Consulta confirmada, mas não foi possível enviar o e-mail.'
            ];
        }
        catch (PDOException $e)
        {
            return [
                'sucesso' => false,
                'mensagem' => 'Não foi Possível Agendar a Consulta no Momento.'
            ];
        }
    }

    public function NegarConsulta($idPreConsulta, string $motivo): array
    {
        $motivo = trim($motivo);
        if ($motivo === '') {
            return ['sucesso' => false, 'mensagem' => 'Informe o motivo da negativa.'];
        }

        try {
            $pdo = (new Database())->getConnection();
            $dados = $pdo->prepare("SELECT u.nmUsuario, u.email
                                    FROM PreConsultas pc
                                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                                    WHERE pc.idPreConsulta = :id AND pc.dtConsulta IS NULL
                                      AND (pc.observacao IS NULL OR pc.observacao NOT LIKE '%STATUS: NEGADA%')");
            $dados->execute([':id' => $idPreConsulta]);
            $consulta = $dados->fetch(PDO::FETCH_ASSOC);
            if (!$consulta) {
                return ['sucesso' => false, 'mensagem' => 'Esta pré-consulta já foi processada ou não existe.'];
            }

            $stmt = $pdo->prepare("UPDATE PreConsultas
                                   SET observacao = CONCAT(COALESCE(observacao, ''), '\\nSTATUS: NEGADA\\nMotivo: ', :motivo)
                                   WHERE idPreConsulta = :id AND dtConsulta IS NULL");
            $stmt->execute([':motivo' => $motivo, ':id' => $idPreConsulta]);

            $enviado = EmailService::enviar(
                $consulta['email'],
                'Atualização da sua pré-consulta',
                "Olá, {$consulta['nmUsuario']}!\n\nNo momento, não foi possível confirmar a data e o horário solicitados.\n\nMotivo informado pela clínica: {$motivo}\n\nEntre em contato para verificar novas possibilidades de agendamento."
            );

            return [
                'sucesso' => true,
                'mensagem' => $enviado ? 'Pré-consulta negada e e-mail enviado ao paciente.' : 'Pré-consulta negada, mas não foi possível enviar o e-mail.'
            ];
        } catch (\Throwable $e) {
            return ['sucesso' => false, 'mensagem' => 'Não foi possível negar a pré-consulta.'];
        }
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

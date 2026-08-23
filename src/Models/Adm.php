<?php
namespace DraAnaLuiza\Models;
use DraAnaLuiza\Models\Database;
use PDO;
use PDOException;

class Adm
{
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

    public function CadastrarDepoimento(string $opiniao, array $arquivo): Array
    {
        $caminho = null;

        if (isset($arquivo) && $arquivo['error'] !== UPLOAD_ERR_NO_FILE)
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

            $opiniao = $_POST['opiniao'];
            $sql = "INSERT INTO DEPOIMENTOS (dsDepoimento) VALUES (:opiniao)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":opiniao" => $opiniao]);
            
            $idDepoimento = $pdo->lastInsertId();

            if ($caminho !== null) {
                $sql = "INSERT INTO DepoimentosImagens (idDepoimento, caminhoArquivo) VALUES (:idDepoimento, :caminho)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":idDepoimento" => $idDepoimento,
                    ":caminho" => $caminho
                ]);
            }

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
                        pc.nmDiaSemana,
                        pc.horarioInicial,
                        pc.horarioFinal,
                        pc.localDor,
                        pc.tempoSintoma,
                        pc.descricaoSintoma,
                        pc.escalaDor,
                        pc.comorbidades
                    FROM PreConsultas pc
                    JOIN Usuarios u ON pc.idUsuario = u.idUsuario
                    WHERE pc.dtConsulta IS NULL
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

            return [
                'sucesso' => true,
                'mensagem' => 'Consulta Agendada com Sucesso!'
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
}
<?php
namespace DraAnaLuiza\Models;
use DraAnaLuiza\Models\Database;
use PDO;
use PDOException;

class Usuario
{
    public function CadastrarUsuario($nome, $cpf, $dtNasc, $email, $cel, $senha): array
    {        
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $sql = "SELECT COUNT(*) FROM USUARIOS WHERE cpf = :cpf";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":cpf" => $cpf]);
            $count = $stmt->fetchColumn();

            if ($count == 0)
            {            
                $sql = "INSERT INTO USUARIOS (nmUsuario, cpf, dataNasc, email, celular, isAdmin, senha) 
                VALUES (:nome, :cpf, :dataNasc, :email, :celular, 0, :senha)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ":nome" => $nome,
                    ":cpf" => $cpf,
                    ":dataNasc" => $dtNasc,
                    ":email" => $email,
                    ":celular" => $cel,
                    ":senha" => $senha            
                ]);
                
                return [
                    'sucesso' => true,
                    'mensagem' => 'Usuário Cadastrado com Sucesso!'
                ];
            }
            else
            {
                return [
                    'sucesso' => false,
                    'mensagem' => 'CPF Já Cadastrado'
                ];
            }
        }
        catch(PDOException $e)
        {
            return [
                'sucesso' => false,
                'mensagem' => "Erro: {$e->getMessage()}"
            ];
        }
    }

    public function Logar(string $email, string $senha): ?array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();
            
            $sql = "SELECT nmUsuario, isAdmin, senha FROM USUARIOS WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        }
        catch(PDOException $e)
        {
            return null;
        }
    }

    public function EmailExiste($email): bool
    {
        $db = new Database();
        $pdo = $db->getConnection();

        $sql = "SELECT COUNT(*) FROM USUARIOS WHERE email = :email";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":email" => $email
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function ObterEmailAdministrador(): ?string
    {
        try {
            $pdo = (new Database())->getConnection();
            $stmt = $pdo->query("SELECT email FROM Usuarios WHERE isAdmin = 1 ORDER BY idUsuario LIMIT 1");
            $email = $stmt->fetchColumn();
            return $email !== false ? (string) $email : null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function SalvarCodigoRecuperacaoSenha($codigo, $email): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();
                
            $sql = "UPDATE USUARIOS 
                    SET codigoRecuperacaoSenha = :codigo,
                        dtExpiracaoCodigoSenha = DATE_ADD(NOW(), INTERVAL 5 MINUTE)
                    WHERE email = :email";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":codigo" => $codigo,
                ":email" => $email
            ]);

            return [
                'sucesso' => true,
                'mensagem' => 'Código Salvo.'
            ];
        }
        catch (\Throwable $th)
        {
            return [
                'sucesso' => false,
                'mensagem' => 'Erro ao Salvar o Código. Favor Entrar em Contato.'
            ];
        }
    }

    public function RetornarCodigoRecuperacao($email): array
    {
        $db = new Database();
        $pdo = $db->getConnection();
        
        $sql = "SELECT codigoRecuperacaoSenha as codigo, dtExpiracaoCodigoSenha as dtExpiracao FROM USUARIOS WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function AlterarSenha($email, $novaSenha): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $sql = "UPDATE Usuarios set senha = :senha WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':email' => $email,
                ':senha' => $novaSenha
            ]);

            return [
                'sucesso' => true,
                'mensagem' => 'Senha Alterada com Sucesso!'
            ];
        }
        catch (\Throwable $th)
        {
            return [
                'sucesso' => false,
                'mensagem' => 'Não foi Possível Alterar a Senha no Momento. Favor Entrar em Contato.'
            ];
        }
    }

    public function CadastrarPreConsulta(string $email, string $dtPreferencia, string $horarioInicial, string $horarioFinal, string $observacao = ''): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $sql = "SELECT idUsuario FROM Usuarios WHERE email = :email";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':email' => $email]);
            $idUsuario = $stmt->fetchColumn();

            if (!$idUsuario)
            {
                return [
                    'sucesso' => false,
                    'mensagem' => 'Usuário não encontrado.'
                ];
            }

            $sql = "INSERT INTO PreConsultas (idUsuario, dtConsulta, horarioInicial, horarioFinal, observacao)
                    VALUES (:idUsuario, :dtConsulta, :horarioInicial, :horarioFinal, :observacao)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':idUsuario' => $idUsuario,
                ':dtConsulta' => $dtPreferencia,
                ':horarioInicial' => $horarioInicial,
                ':horarioFinal' => $horarioFinal,
                ':observacao' => $observacao
            ]);

            return [
                'sucesso' => true,
                'mensagem' => 'Pré-Consulta Enviada com Sucesso! A Dra. entrará em contato para confirmar o dia e horário.'
            ];
        }
        catch (\Throwable $th)
        {
            return [
                'sucesso' => false,
                'mensagem' => 'Não foi Possível Enviar a Pré-Consulta no Momento. Favor Entrar em Contato.'
            ];
        }
    }
}

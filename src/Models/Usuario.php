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
           return [
                'sucesso' => false,
                'mensagem' => "Erro: {$e->getMessage()}"
            ];
        }
    }
}
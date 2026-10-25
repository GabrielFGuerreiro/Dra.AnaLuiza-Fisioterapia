<?php
namespace DraAnaLuiza\Models;
use DraAnaLuiza\Models\Database;
use PDO;
use PDOException;

class Geral
{
    public function RetornarPacientes(): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $sql = "SELECT idUsuario, nmUsuario FROM USUARIOS where isAdmin = 0";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
        }
        catch (\Throwable $th)
        {
            return [];
        }
    }

    public function RetornarTiposDocumentos(): array
    {
        try
        {
            $db = new Database();
            $pdo = $db->getConnection();

            $sql = "SELECT idTipoDocumento, nmTipo FROM tiposDocumento where dtRemocao is null";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?: [];
        }
        catch (\Throwable $th)
        {
            return [];
        }
    }

}
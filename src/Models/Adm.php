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
            $sql = 'SELECT idPreConsulta as guid, u.nmUsuario as title, horarioInicial as start, horarioFinal as end, \'2026-07-11\' as date, \'gray\' as color  FROM preconsultas pc JOIN usuarios u ON pc.idUsuario = u.idUsuario';

            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        }
        catch (PDOException $e)
        {
            return [];
        }
    }
}
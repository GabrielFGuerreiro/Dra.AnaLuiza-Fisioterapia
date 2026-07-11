<?php
namespace DraAnaLuiza\Models;
use PDO;
use PDOException;
class Database {
    private $host = "localhost";
    private $banco = "pi_fisioana";
    private $usuario = "root";
    private $senha = "";
    private $port = "3307";
    public $conn;

    public function getConnection() {
        $this->conn = null; //Verificar se a conexão já existe. Se sim, reseta a instancia para null.
        
        try //Tenta executar um código potencialmente perigoso.
        { 
            //DSN (Data Source Name) é uma string que contém as informações necessárias para se conectar ao banco de dados.
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->banco};charset=utf8";
            $this->conn = new PDO($dsn, $this->usuario, $this->senha); //Cria uma nova conexão PDO usando o DSN e as credenciais fornecidas.
            
            //Define o modo de erro do PDO para exceção
            //Isso faz com que o PDO lance exceções em caso de erros, facilitando o tratamento
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) //Em caso de erro na conexão, exibe a messagem de erro.
        { 
            echo "<div class='notif erro' style='position: fixed; bottom: 90%;left:37.6%;'>Erro de conexão: " . $e->getMessage() . "</div>";
        }
        return $this->conn;
    }
}
?>
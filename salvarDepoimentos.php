<?php 

include "header.php";
include_once "Models/Database.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{    
    if(!is_dir("arquivosDepoimentos"))
        mkdir("arquivosDepoimentos", 0777, true);
    if(!isset($_FILES["arqDepoimento"]) || $_FILES["arqDepoimento"]["error"] !== UPLOAD_ERR_OK)
    {
        echo "Erro no upload do arquivo.";
        header("Location: inicio.php");
        exit;
    }
    
    $nomeArq = time() . "_" . preg_replace("/[^a-zA-Z0-9.]/", "_", $_FILES["arqDepoimento"]["name"]);   
    $caminho = "arquivosDepoimentos/$nomeArq";

    move_uploaded_file($_FILES["arqDepoimento"]["tmp_name"], $caminho);

    $db = new Database();
    $pdo = $db->getConnection();

    $opiniao = $_POST['opiniao'];
    $sql = "INSERT INTO DEPOIMENTOS (dsDepoimento) VALUES (:opiniao)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([":opiniao" => $opiniao]);
    
    $sql = "SELECT idDepoimento FROM DEPOIMENTOS ORDER BY idDepoimento DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $idDepoimento = $stmt->fetchColumn();

    $sql = "INSERT INTO DepoimentosImagens (idDepoimento, caminhoArquivo) VALUES (:idDepoimento, :caminho)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ":idDepoimento" => $idDepoimento,
        ":caminho" => $caminho
        ]);
}
?>
<?php 
include "header.php";
include_once "Models/Database.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{    
    if(!is_dir("arquivosDepoimentos"))
        mkdir("arquivosDepoimentos", 0777, true);
    
    $nomeArq = $_FILES["arqDepoimento"]["name"];
    $caminho = "arquivosDepoimentos/$nomeArq";
    echo $nomeArq;
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
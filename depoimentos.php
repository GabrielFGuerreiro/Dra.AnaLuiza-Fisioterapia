<?php 
include "header.php";
include_once "Models/Database.php";

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
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
        ":caminho" => "TESTE"
        ]);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depoimento</title>
</head>
<body>
    <style>
    body {
        position: relative;
        right:30px;
    }
    </style>
    <div class="conteudo">
        <h2>Avaliação de Atendimento</h2><BR>
        <form action="" method="POST"><br>
            <label for="opiniao">O que o cliente achou do atendimento?</label>
            <input name="opiniao" id="opiniao" type="text"><br>
            <label for="image">Insira uma foto ou um video do atendimento:</label>
            <input type="file" name="image" id="image" accept="image/*, video/*"><br>

        <button type="submit">Salvar</button>''
    </form>
</body>
</html>

<!-- 
    Precisamos adicionar o integração ao banco, para que possa ser feito o ADD do depoimento, 
    quanto tambem receber os depoimentos anteriores para mostrar ordenado por datetime 
    

    no input de imagem/video, fazer uma função com javascript para mostrar um preview, para o usuario saber que esta enviando a midia correta.
 -->
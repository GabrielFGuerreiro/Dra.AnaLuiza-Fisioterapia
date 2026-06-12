<?php 
    include "header.php";
    session_start();

    if($_SERVER["REQUEST_METHOD"]==="POST")
        {
        $opiniao = $_POST["opiniao"];
        $image = $_POST["image"];

        
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
    <div class="conteudo">
        <h1>Cadastro de Novo Livro</h2>          
        <form action="" method="POST"><br>
            <label for="opiniao">O que o cliente achou do atendimento?</label>
            <input name="opiniao" id="opiniao" type="text" placeholder="O que o cliente achou do atendimento?"><br>
            <label for="image">Insira uma foto ou um video do atendimento:</label>
            <input type="file" name="image" id="image" accept="image/*, video/*"><br><br>

            <button type="submit">Salvar Depoimento</button>
        </form>
    </div>
</body>
</html>



<!-- 
    Precisamos adicionar o integração ao banco, para que possa ser feito o ADD do depoimento, 
    quanto tambem receber os depoimentos anteriores para mostrar ordenado por datetime 
    

    no input de imagem/video, fazer uma função com javascript para mostrar um preview, para o usuario saber que está enviando a midia correta.
 -->
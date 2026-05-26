<?php 
    include "header.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depoimento</title>
</head>
<body>
    <form action=""><br>
        <label for="">O que o cliente achou do atendimento?</label>
        <input type="text"><br><br>
        <label for="image">Insira uma foto ou um video do atendimento:</label><br>
        <input type="file" name="image" ><br><br>

        <input type="submit" value="Submit">
        <i class="fa-whiteboard fa-semibold fa-face-smile fa-flip-horizontal" style="color: rgb(243, 141, 233);"></i>
    </form>
</body>
</html>

<!-- 
    Precisamos adicionar o integração ao banco, para que possa ser feito o ADD do depoimento, 
    quanto tambem receber os depoimentos anteriores para mostrar ordenado por datetime 
    
 -->
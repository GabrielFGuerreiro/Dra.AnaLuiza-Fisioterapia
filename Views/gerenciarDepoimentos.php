<?php include RAIZ . '/Views/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Depoimento</title>
</head>
<body>
    <style>
    body {
        position: relative;
        right:30px;
    }
    </style>
    <div class="conteudo">
        <h2>Avaliação de Atendimento</h2>
        <form action="<?= BASE_URL ?>/cadastrarDepoimento" method="POST" enctype="multipart/form-data">
            <label for="opiniao">O que o cliente achou do atendimento?</label>
            <textarea name="opiniao" id="opiniao" type="textarea" rows="5"></textarea>
            <label for="arqDepoimento">Insira uma foto ou um video do atendimento:</label>
            <input type="file" name="arqDepoimento" id="arqDepoimento" accept="image/*, video/*">
            <button type="submit">Salvar</button>
        </form>
    <div style='text-align: center;'><?php if (isset($_GET['msg'])): echo $_GET['msg']; endif; ?></div>
</body>
</html>

<!-- 
    Precisamos adicionar o integração ao banco, para que possa ser feito o ADD do depoimento, 
    quanto tambem receber os depoimentos anteriores para mostrar ordenado por datetime 
    

    no input de imagem/video, fazer uma função com javascript para mostrar um preview, para o usuario saber que esta enviando a midia correta.
 -->
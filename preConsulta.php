<?php 
    include "header.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-Consulta - Fisioterapia</title>
</head>
<body>
    <div class="conteudo">
        <h1>Formulário de Pré-Consulta</h1>
        <form>
            <label>Qual a sua preferencia de dia e horario?</label>
            <input type="text" placeholder="Ex: Segunda às 14:00hrs">

            <label for="local_dor">Qual o principal local da dor ou desconforto?</label>
            <input type="text" id="local_dor" name="local_dor" required placeholder="Ex: Dor no pescoço">

            <label for="tempo_sintoma">Há quanto tempo você sente isso?</label>
            <input type="text" id="tempo_sintoma" name="tempo_sintoma">

            <label for="descricao_sintoma">Descreva brevemente o que você está sentindo:</label>
            <textarea id="descricao_sintoma" name="descricao_sintoma" rows="4" cols="50" placeholder="Escreva aqui..."></textarea>

            <label for="escala_dor">De 1 a 10, qual o nível da sua dor atual? </label>
            <input type="number" id="escala_dor" name="escala_dor" min="1" max="10">

            <label for="comorbidades">Possui alguma doença crônica?</label>
            <textarea id="comorbidades" name="comorbidades" rows="2" cols="50"></textarea>
            <br>
            <button type="submit">Enviar Pré-Consulta</button>
            <button type="reset">Limpar Tudo</button>

        </form>
    </div>
</body>
</html>
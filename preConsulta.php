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

    <main>
        <h1>Formulário de Pré-Consulta</h1>
        <p>Por favor, preencha os dados abaixo para podermos ajudar.</p>

        <form"> <!-- placeholder -->
            
            
                <legend>Informações do Paciente</legend>
                
                <p>
                    <label for="nome">Nome Completo:</label>
                    <input type="text" id="nome" name="nome" required autofocus>
                </p>
                
                <p>
                    <label for="data_nascimento">Data de Nascimento:</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" required>
                </p>
            

            
                <legend>Queixa Principal</legend>
                
                <p>
                    <label for="local_dor">Qual o principal local da dor ou desconforto?</label>
                    <input type="text" id="local_dor" name="local_dor" required placeholder="Ex: Dor no pinto">
                </p>

                <p>
                    <label for="tempo_sintoma">Há quanto tempo você sente isso?</label>
                    <input type="text" id="tempo_sintoma" name="tempo_sintoma">
                </p>

                <p>
                    <label for="descricao_sintoma">Descreva brevemente o que você está sentindo:</label>
                    <br>
                    <textarea id="descricao_sintoma" name="descricao_sintoma" rows="4" cols="50" placeholder="Escreva aqui..."></textarea>
                </p>
            

            
                <legend>Histórico Clínico</legend>

                <p>
                    <label for="escala_dor">De 1 a 10, qual o nível da sua dor atual? </label>
                    <input type="number" id="escala_dor" name="escala_dor" min="1" max="10">
                </p>

                <p>
                    <label for="cirurgia">Já passou por alguma cirurgia recente ou relacionada a essa queixa?</label>
                    <br>
                    <input type="radio" id="cirurgia_sim" name="cirurgia" value="sim">
                    <label mapping for="cirurgia_sim">Sim</label>
                    
                    <input type="radio" id="cirurgia_nao" name="cirurgia" value="nao">
                    <label for="cirurgia_nao">Não</label>
                </p>

                <p>
                    <label for="comorbidades">Possui alguma doença crônica?</label>
                    <br>
                    <textarea id="comorbidades" name="comorbidades" rows="2" cols="50"></textarea>
                </p>
            

            <br>
            <button type="submit">Enviar Pré-Consulta</button>
            <button type="reset">Limpar Tudo</button>

        </form>
    </main>

</body>
</html>
<?php include RAIZ . '/Views/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisio com a Ana</title>
</head>

<body>
    <style>
    body {
        position: relative;
        right:30px;
    }
    </style>
    <div class="conteudo" >
        <h2>Login</h2>
        <form action="<?= BASE_URL ?>/logar" method="POST"> <!-- O Apache (via .htaccess) redireciona tudo para index.php -->
            <input id="email" name="email" class="form-field" type="email" placeholder="Digite o E-mail.">
            <input id="password" name="password" class="form-field" type="password" placeholder="Digite a Senha."><br>
            <button>Logar</button>
            <a href="<?= BASE_URL ?>/cadastro">Não tem uma conta? Cadastre-se!</a>
        </form>
        <div style='text-align: center;'><?php if (isset($_GET['msg'])): echo $_GET['msg']; endif; ?></div>
    </div>
</body>
</html>

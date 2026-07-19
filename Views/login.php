<style>
    .conteudo {
        margin-left: 30px;
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
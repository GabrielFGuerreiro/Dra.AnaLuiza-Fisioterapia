<div class="conteudo">
    <h1>Cadastro de Usuário</h1>
    
    <form action="<?= BASE_URL ?>/cadastrar" method="POST" id="formCadastrar">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" size="70px">
        <spam id="msgObrigatoriaNome" class="msgObrigatoria">O <b>Nome</b> é Obrigatório.</spam>

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf">
        <spam id="msgObrigatoriaCpf" class="msgObrigatoria">O <b>CPF</b> é Obrigatório.</spam>

        <label for="dtNasc">Data de Nascimento</label>
        <input type="date" id="dtNasc" name="dtNasc">

        <label for="cel">Celular</label>
        <input type="text" id="cel" name="cel">

    <label for="emailCad">E-mail</label>
    <input type="email" id="emailCad" name="emailCad">
    <spam id="msgObrigatoriaEmail" class="msgObrigatoria"></spam>

        <label for="senhaCad">Senha</label>
        <input type="password" id="senhaCad" name="senhaCad">
        <spam id="msgSenha" class="msgObrigatoria"></spam>

        <div>
            <spam class="requisitosSenha"><i class="fa fa-circle"></i>8 Caracteres</spam>  
            <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Letra Minúscula</spam>  
            <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Letra Maiúscula</spam>  
            <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Número</spam>  
            <spam title="Exemplo: #, @, %, *" class="requisitosSenha"><i class="fa fa-circle" ></i >1 Caracter Especial</spam>  
        </div>

        <button type="button" id="btnCadastrar">Cadastrar</button>
        <a href="<?= BASE_URL ?>/login">Já tem uma conta? Faça Login!</a>

    <!-- <?php //if ($mensagem): ?>
        <div class="notif <?php //echo ($tipoMensagem === 'Sucesso') ? 'Sucesso' : 'Erro'; ?>">
            <?php //echo htmlspecialchars($mensagem); ?>
        </div>
    <?php //endif; ?> -->

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const msg = params.get("msg");
        if (msg)
            mostrarAlerta(msg);
    });

    var circulos = document.querySelectorAll(".password-hints .fa-circle");

    document.getElementById("btnCadastrar").addEventListener("click", function() {
        var nome = document.getElementById("nome").value;
        if (!nome) {
            mostrarAlerta("Informe seu nome completo.");
            return;
        }

        var cpf = document.getElementById("cpf").value;
        if (!cpf) {
            mostrarAlerta("Informe seu CPF.");
            return;
        }

        var senhaValida = true;
        var circulos = document.querySelectorAll(".fa-circle");

        document.getElementById("btnCadastrar").addEventListener("click", function()
        {
            var icCadastrar = true;

            var nome = document.getElementById("nome").value; //Verifica se o campo nome está vazio
            var msgNome = document.getElementById("msgObrigatoriaNome");
            if(!nome)
            {
                msgNome.style.display = "block";
                icCadastrar = false;
            }
            else        
                msgNome.style.display = "none";
            
            var cpf = document.getElementById("cpf").value; //Verifica se o campo cpf está vazio
            var msgCpf = document.getElementById("msgObrigatoriaCpf");
            if(!cpf)
            {
                msgCpf.style.display = "block";
                icCadastrar = false;
            }
            else        
                msgCpf.style.display = "none";
            

            circulos.forEach((circulo) => { //Verifica se algum requisito da senha não foi atendido com base na cor da bolinha
                if(circulo.style.color === "gray")
                    senhaValida = false;
            });

        var senhaCad = document.getElementById("senhaCad").value;
        var senhaAux = document.getElementById("confirmSenha").value;
        if (!senhaCad) {
            mostrarAlerta("Crie uma senha para continuar.");
            return;
        }
        
        if (!senhaValida) {
            mostrarAlerta("Sua senha não atende aos requisitos.");
            return;
        }

        if(senhaCad !== senhaAux)
        {
            mostrarAlerta("As senhas não coincidem.");
            return;
        }

        if (senhaValida) {
            document.getElementById("formCadastrar").submit();
            return;
        }
    });

    document.getElementById("senhaCad").addEventListener("input", function() {
        var senha = this.value;
        circulos[0].style.color = senha.length >= 8 ? "#4f9564" : "gray";
        circulos[1].style.color = senha.match(/[a-z]/g) ? "#4f9564" : "gray";
        circulos[2].style.color = senha.match(/[A-Z]/g) ? "#4f9564" : "gray";
        circulos[3].style.color = senha.match(/\d/g) ? "#4f9564" : "gray";
        circulos[4].style.color = senha.match(/\W|_/g) ? "#4f9564" : "gray";
    });
</script>

    </form>
</div>
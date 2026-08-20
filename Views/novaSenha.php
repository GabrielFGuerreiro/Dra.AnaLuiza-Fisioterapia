<section class="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="moving-card">
                    <div class="form-heading">
                        <span class="form-icon"><i class="fa-regular fa-user"></i></span>
                        <h1>Recuperar a Senha</h1>
                    </div>

                    <div id="msgAlerta" class="alerta-form form-alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span></span>
                    </div>
                    
                    <form action="<?= BASE_URL ?>/alterarSenha" method="POST" id="formAlterarSenha">
                        <label for="senha">Nova senha</label>
                        <input id="senha" name="senha" type="password">

                        <label for="confirmSenha">Confirmar senha</label>
                        <input id="confirmSenha" name="confirmSenha" type="password">

                        <button type="submit">Alterar Senha</button>
                        <a href="<?= BASE_URL ?>/verificacaoCodigo">Voltar</a>

                        
                        <div class="password-hints">
                            <span class="requisitosSenha"><i class="fa fa-circle"></i>8 caracteres</span>
                            <span class="requisitosSenha"><i class="fa fa-circle"></i>Letra minúscula</span>
                            <span class="requisitosSenha"><i class="fa fa-circle"></i>Letra maiúscula</span>
                            <span class="requisitosSenha"><i class="fa fa-circle"></i>Número</span>
                            <span class="requisitosSenha"><i class="fa fa-circle"></i>Caractere especial</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const msg = params.get("msg");
        const sucesso = params.get("sucesso");
        if (msg)
        {
            Swal.fire({
                title: msg,
                icon: sucesso === "1" ? "success" : "error",
                confirmButtonText: 'Ok'
            }).then((resulta) => {
                if(sucesso === "1")
                    window.location.href = "/Dra.AnaLuiza-Fisioterapia/login";
            });

            // O resultado já foi exibido; remove os dados do POST da URL.
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

    var circulos = document.querySelectorAll(".password-hints .fa-circle");
    document.getElementById("formAlterarSenha").addEventListener("submit", function(e)
    {
        e.preventDefault();

        let senha = document.getElementById("senha").value;
        let senhaConfirm = document.getElementById("confirmSenha").value;
        if(!senha)
        {
            mostrarAlerta("Digite a Nova Senha.");
            return;
        }

        if(!senhaConfirm)
        {
            mostrarAlerta("Confirme a Nova Senha.");
            return;
        }

        for (const circulo of circulos) {
            if (circulo.style.color === "gray") {
                mostrarAlerta("Sua Senha Não Atende aos Requisitos.");
                return;
            }
        }

        if(senha !== senhaConfirm)
        {
            mostrarAlerta("As Senhas Não Coincidem.");
            return;
        }

        this.submit();
    });

    document.getElementById("senha").addEventListener("input", function() {
        var senha = this.value;
        circulos[0].style.color = senha.length >= 8 ? "#4f9564" : "gray";
        circulos[1].style.color = /[a-z]/.test(senha) ? "#4f9564" : "gray";
        circulos[2].style.color = /[A-Z]/.test(senha) ? "#4f9564" : "gray";
        circulos[3].style.color = /\d/.test(senha) ? "#4f9564" : "gray";
        circulos[4].style.color = /[\W_]/.test(senha) ? "#4f9564" : "gray";
    });
</script>
<section class="register-page">
    <div class="container register-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 col-xl-8">
                <div class="register-card">
                    <div class="register-heading">
                        <span class="register-icon"><i class="fa-regular fa-user"></i></span>
                        <h1>Crie sua conta</h1>
                    </div>

                    <div id="msgAlerta" class="alerta-form">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span></span>
                    </div>

                    <form class="register-form" action="<?= BASE_URL ?>/cadastrar" method="POST" id="formCadastrar">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="register-field">
                                    <label for="nome">Nome completo</label>
                                    <div class="register-input-wrap">
                                        <i class="fa-regular fa-user"></i>
                                        <input type="text" id="nome" name="nome" class="form-control campo-form" placeholder="Como você gostaria de ser chamado?">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="register-field">
                                    <label for="cpf">CPF</label>
                                    <div class="register-input-wrap">
                                        <i class="fa-regular fa-id-card"></i>
                                        <input type="text" id="cpf" name="cpf" class="form-control campo-form" placeholder="000.000.000-00">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="register-field">
                                    <label for="dtNasc">Data de nascimento</label>
                                    <div class="register-input-wrap">
                                        <i class="fa-regular fa-calendar"></i>
                                        <input type="date" id="dtNasc" name="dtNasc" class="form-control campo-form">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="register-field">
                                    <label for="cel">Celular</label>
                                    <div class="register-input-wrap">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                        <input type="text" id="cel" name="cel" class="form-control campo-form" placeholder="(00) 00000-0000">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="register-field">
                                    <label for="emailCad">E-mail</label>
                                    <div class="register-input-wrap">
                                        <i class="fa-regular fa-envelope"></i>
                                        <input type="email" id="emailCad" name="emailCad" class="form-control campo-form" placeholder="voce@exemplo.com">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row g-3 password-fields">
                                    <div class="col-md-6">
                                        <div class="register-field">
                                            <label for="senhaCad">Crie uma senha</label>
                                            <div class="register-input-wrap">
                                                <i class="fa-solid fa-lock"></i>
                                                <input type="password" id="senhaCad" name="senhaCad" class="form-control campo-form" placeholder="Escolha uma senha segura">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="register-field">
                                            <label for="confirmSenha">Confirme sua senha</label>
                                            <div class="register-input-wrap">
                                                <i class="fa-solid fa-lock"></i>
                                                <input type="password" id="confirmSenha" name="confirmSenha" class="form-control campo-form" placeholder="Digite a senha novamente">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="password-hints">
                                    <span class="requisitosSenha"><i class="fa fa-circle"></i>8 caracteres</span>
                                    <span class="requisitosSenha"><i class="fa fa-circle"></i>Letra minúscula</span>
                                    <span class="requisitosSenha"><i class="fa fa-circle"></i>Letra maiúscula</span>
                                    <span class="requisitosSenha"><i class="fa fa-circle"></i>Número</span>
                                    <span class="requisitosSenha"><i class="fa fa-circle"></i>Caractere especial</span>
                                </div>
                            </div>
                        </div>

                        <button class="register-submit" type="button" id="btnCadastrar">
                            <span>Criar minha conta</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>

                    <p class="register-login">Já possui uma conta? <a href="<?= BASE_URL ?>/login">Entrar</a></p>
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
        }
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

        var cel = document.getElementById("cel").value;
        if (!cel) {
            mostrarAlerta("Informe seu Celular.");
            return;
        }

        var senhaCad = document.getElementById("senhaCad").value;
        var senhaAux = document.getElementById("confirmSenha").value;
        if (!senhaCad) {
            mostrarAlerta("Crie uma senha para continuar.");
            return;
        }
        
        for (const circulo of circulos) {
            if (circulo.style.color === "gray") {
                mostrarAlerta("Sua senha não atende aos requisitos.");
                return;
            }
        }

        if(senhaCad !== senhaAux)
        {
            mostrarAlerta("As senhas não coincidem.");
            return;
        }

        document.getElementById("formCadastrar").submit();
        return;
    });

    document.getElementById("senhaCad").addEventListener("input", function() {
        var senha = this.value;
        circulos[0].style.color = senha.length >= 8 ? "#4f9564" : "gray";
        circulos[1].style.color = senha.match(/[a-z]/g) ? "#4f9564" : "gray";
        circulos[2].style.color = senha.match(/[A-Z]/g) ? "#4f9564" : "gray";
        circulos[3].style.color = senha.match(/\d/g) ? "#4f9564" : "gray";
        circulos[4].style.color = senha.match(/\W|_/g) ? "#4f9564" : "gray";
    });

    document.getElementById("cpf").addEventListener("input", function ()
    {
        let cpfNum = this.value.replace(/\D/g, "");
        let valor = cpfNum;

        if (cpfNum.length > 3)
            valor = valor.substring(0, 3) + "." + valor.substring(3);

        if (cpfNum.length > 6)
            valor = valor.substring(0, 7) + "." + valor.substring(7);

        if (cpfNum.length > 9)
            valor = valor.substring(0, 11) + "-" + valor.substring(11);

        this.value = valor.substring(0, 14);
    });

    document.getElementById("cel").addEventListener("input", function ()
    {
        let celNum = this.value.replace(/\D/g, "");
        let valor = celNum;

        if (celNum.length > 0)
            valor = "(" + valor.substring(0);

        if (celNum.length > 2)
            valor = valor.substring(0, 3) + ") " + valor.substring(3);

        if (celNum.length > 7)
            valor = valor.substring(0, 10) + "-" + valor.substring(10);

        this.value = valor.substring(0, 15);
    });
</script>

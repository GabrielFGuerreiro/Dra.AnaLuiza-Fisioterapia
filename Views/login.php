<section class="page">
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="moving-card">
                    <div class="login-card-heading form-heading">
                        <span class="login-icon form-icon"><i class="fa-regular fa-heart"></i></span>
                        <h1>Área do Paciente</h1>
                    </div>

                    <div id="msgAlerta" class="alerta-form form-alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span></span>
                    </div>

                    <form id="formLogin" class="login-form form-layout" action="<?= BASE_URL ?>/logar" method="POST">
                        <div class="login-field form-field">
                            <label for="email">E-mail</label>
                            <div class="login-input-wrap form-input-wrap">
                                <i class="fa-regular fa-envelope"></i>
                                <input id="email" name="email" class="form-control campo-form" type="email" placeholder="voce@exemplo.com">
                            </div>
                        </div>

                        <div class="login-field form-field">
                            <label for="password">Senha</label>
                            <div class="login-input-wrap form-input-wrap">
                                <i class="fa-solid fa-lock"></i>
                                <input id="password" name="password" class="form-control campo-form" type="password" placeholder="Digite sua senha">
                            </div>
                        </div>
                        <a class="forgot-password" href="<?= BASE_URL ?>/esqueciMinhaSenha">Esqueceu sua senha?</a>

                        <button id="btnLogin" class="login-submit form-submit" type="button">
                            <span>Entrar na minha conta</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>

                    <p class="login-signup form-footer">Ainda não tem uma conta? <a class="form-footer-link" href="<?= BASE_URL ?>/cadastro">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const msg = params.get("msg");
        if (msg)
            mostrarAlerta(msg);
    });

    function logar()
    {
        const inputEmail = document.getElementById("email");
        if (!inputEmail.value.trim()) {
            mostrarAlerta("Digite o E-mail.");
            return;
        }
        
        if (!inputEmail.checkValidity()) {
            mostrarAlerta("Digite um E-mail Válido.");
            return;
        }
        
        const senha = document.getElementById("password").value;
        if (!senha) {
            mostrarAlerta("Digite a Senha.");
            return;
        }
        
        document.getElementById("formLogin").submit();
    }
    
    document.getElementById("btnLogin").addEventListener("click", function () {
        logar();
    });
</script>

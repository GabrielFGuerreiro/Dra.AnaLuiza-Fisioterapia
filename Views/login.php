<section class="login-page">
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="login-card">
                    <div class="login-card-heading">
                        <span class="login-icon"><i class="fa-regular fa-heart"></i></span>
                        <h1>Área do Paciente</h1>
                    </div>

                    <div id="msgAlerta" class="login-alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span></span>
                    </div>

                    <form id="formLogin" class="login-form" action="<?= BASE_URL ?>/logar" method="POST">
                        <div class="login-field">
                            <label for="email">E-mail</label>
                            <div class="login-input-wrap">
                                <i class="fa-regular fa-envelope"></i>
                                <input id="email" name="email" class="form-control" type="email" placeholder="voce@exemplo.com">
                            </div>
                        </div>

                        <div class="login-field">
                            <label for="password">Senha</label>
                            <div class="login-input-wrap">
                                <i class="fa-solid fa-lock"></i>
                                <input id="password" name="password" class="form-control" type="password" placeholder="Digite sua senha">
                            </div>
                        </div>

                        <button id="btnLogin" class="login-submit" type="button">
                            <span>Entrar na minha conta</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </form>

                    <p class="login-signup">Ainda não tem uma conta? <a href="<?= BASE_URL ?>/cadastro">Cadastre-se</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    document.addEventListener("DOMContentLoaded", function () {

        const alerta = document.getElementById("msgAlerta");
        function mostrarAlerta(msg) {

            alerta.querySelector("span").textContent = msg;

            alerta.classList.remove("login-alert");
            void alerta.offsetWidth; // força o navegador a reiniciar a animação
            alerta.classList.add("login-alert");

            alerta.style.display = "block";
        }

        const params = new URLSearchParams(window.location.search);
        const msg = params.get("msg");

        if (msg) {
            mostrarAlerta(msg);
        }

        document.getElementById("btnLogin").addEventListener("click", function () {

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
        });

        document.getElementById("email").addEventListener("input", () => {
            alerta.style.display = "none";
        });

        document.getElementById("password").addEventListener("input", () => {
            alerta.style.display = "none";
        });
    });


</script>

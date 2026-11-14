<section class="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="moving-card">
                    <div class="form-heading">
                        <span class="form-icon"><i class="fa-regular fa-user"></i></span>
                        <h1>Envio de E-mail de Verificação</h1>
                        <p class="verification-description">Para continuar, precisamos validar seu e-mail por meio de um código que você receberá.</p>
                    </div>

                    <div id="msgAlerta" class="alerta-form form-alert">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span></span>
                    </div>

                    <form class="form-layout recovery-form" action="<?= BASE_URL ?>/enviarEmailCodigo" method="POST" id="formEnvioEmail">

                        <div class="form-field">
                            <label for="email">E-mail</label>
                            <div class="form-input-wrap">
                                <i class="fa-regular fa-envelope"></i>
                                <input id="email" name="email" class="form-control" type="email" placeholder="voce@exemplo.com" <?= isset($_SESSION['emailCadastro']) ? 'disabled value="' . $_SESSION['emailCadastro'] . '"' : '' ?> >
                            </div>
                        </div>
                        <button type="submit">Enviar Código</button>
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
                    window.location.href = "<?= BASE_URL ?>/verificacaoCodigo";
            });

            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

    document.getElementById("formEnvioEmail").addEventListener("submit", function(e)
    {
        e.preventDefault();
        
        if(!document.getElementById("email").value)
        {
            mostrarAlerta("Digite o E-mail.");
            return;
        }

        this.submit();      
    });

</script>

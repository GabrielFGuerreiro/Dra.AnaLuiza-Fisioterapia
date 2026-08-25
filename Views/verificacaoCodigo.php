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

                    <form class="form-layout recovery-form" action="<?= BASE_URL ?>/verificarCodigo" method="POST" id="formVerificarCodigo">
                        <label for="codigo">Código</label>
                        <div class="form-input-wrap">
                            <i class="fa-solid fa-shield-halved" aria-hidden="true"></i>
                        <input class="form-control form-input"
                            id="codigo"
                            name="codigo"
                            type="text"
                            maxlength="6"
                            placeholder="Digite o código"
                        >
                        </div>

                        <button type="submit">Verificar Código</button>
                        <a href="<?= BASE_URL ?>/esqueciMinhaSenha">Voltar</a>
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
                    window.location.href = "<?= BASE_URL ?>/novaSenha";
            });

            // O resultado já foi exibido; remove os dados do POST da URL.
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

    document.getElementById("formVerificarCodigo").addEventListener("submit", function (e)
    {
        e.preventDefault();
        if(!document.getElementById("codigo").value)
        {
            mostrarAlerta("Informe o Código");
            return;
        }
        this.submit();
    });

</script>

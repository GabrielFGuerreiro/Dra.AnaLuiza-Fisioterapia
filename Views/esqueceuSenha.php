<section class="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="moving-card">
                    <div class="form-heading">
                        <span class="form-icon"><i class="fa-regular fa-user"></i></span>
                        <h1>Recuperar a Senha</h1>
                    </div>
                    <form class="form-layout" action="<?= BASE_URL ?>/enviarEmailCodigo" method="POST" id="formRecuperarSenha">

                        <div class="form-field">
                            <label for="email">E-mail</label>
                            <div class="form-input-wrap">
                                <i class="fa-regular fa-envelope"></i>
                                <input id="email" name="email" class="form-control campo-form" type="email" placeholder="voce@exemplo.com">
                            </div>
                        </div>
                        <button type="submit">Enviar Código</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
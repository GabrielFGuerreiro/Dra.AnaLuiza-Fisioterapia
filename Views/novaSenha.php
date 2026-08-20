<section class="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="moving-card">
                    <div class="form-heading">
                        <span class="form-icon"><i class="fa-regular fa-user"></i></span>
                        <h1>Recuperar a Senha</h1>
                    </div>
                    <form action="<?= BASE_URL ?>/alterarSenha" method="POST">

                        <label for="senha">Nova senha</label>
                        <input
                            id="senha"
                            name="senha"
                            type="password"
                        >

                        <label for="confirmSenha">Confirmar senha</label>
                        <input
                            id="confirmSenha"
                            name="confirmSenha"
                            type="password"
                        >

                        <button type="submit">Alterar Senha</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
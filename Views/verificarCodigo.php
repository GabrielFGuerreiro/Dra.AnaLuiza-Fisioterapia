<section class="page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="moving-card">
                    <div class="form-heading">
                        <span class="form-icon"><i class="fa-regular fa-user"></i></span>
                        <h1>Recuperar a Senha</h1>
                    </div>
                    <form action="<?= BASE_URL ?>/verificarCodigo" method="POST">

                        <label for="codigo">Código</label>

                        <input
                            id="codigo"
                            name="codigo"
                            type="text"
                            maxlength="6"
                            placeholder="Digite o código"
                        >

                        <button type="submit">Verificar Código</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
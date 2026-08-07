<section class="py-5">
    <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 55.9vh;">
        <div class="moving-card position-relative text-center" style="z-index: 2; max-width: 700px;">
            <div class="position-relative text-center w-100" style="z-index: 2;">
                <h1 class="display-4 fw-bold text-success mb-4">Pré-Consulta</h1>

                <form action="<?= BASE_URL ?>/preconsulta" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                    <label class="form-label fw-semibold" for="prefHora">Qual a sua preferencia de dia e horario?</label>
                    <input class="form-control" type="text" id="prefHora" name="prefHora" placeholder="Ex: Segunda às 14:00hrs" size="70px">

                    <label class="form-label fw-semibold" for="localDor">Qual o principal local da dor ou desconforto?</label>
                    <input class="form-control" type="text" id="localDor" name="localDor" required placeholder="Ex: Dor no pescoço">

                    <label class="form-label fw-semibold" for="tempoSintoma">Há quanto tempo você sente isso?</label>
                    <input class="form-control" type="text" id="tempoSintoma" name="tempoSintoma">

                    <label class="form-label fw-semibold" for="descricaoSintoma">Descreva brevemente o que você está sentindo:</label>
                    <textarea class="form-control" id="descricaoSintoma" name="descricaoSintoma" rows="4" cols="50" placeholder="Escreva aqui..."></textarea>

                    <label class="form-label fw-semibold" for="escalaDor">De 1 a 10, qual o nível da sua dor atual? </label>
                    <input class="form-control" type="number" id="escalaDor" name="escalaDor" min="1" max="10">

                    <label class="form-label fw-semibold" for="comorbidades">Possui alguma doença crônica?</label>
                    <textarea class="form-control" id="comorbidades" name="comorbidades" rows="2" cols="50" placeholder="Ex: Diabetes, pressão alta..."></textarea>
                    <br>
                    <button type="submit" class="btn btn-success btn-lg">Enviar Pré-Consulta</button>
                    <button type="reset" class="btn btn-secondary btn-lg">Limpar Tudo</button>

                </form>
            </div>
        </div>
    </div>
</section>

<?php require "footer.php"; ?>

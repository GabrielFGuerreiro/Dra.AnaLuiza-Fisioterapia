<section class="py-5">
    <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 55.9vh;">
        <div class="moving-card position-relative text-center" style="z-index: 2; max-width: 700px;">
            <div class="position-relative text-center w-100" style="z-index: 2;">
                <h1 class="display-4 fw-bold text-success mb-4">Pré-Consulta</h1>

                <?php if (!empty($_GET['msg'])) { ?>
                    <div class="alert <?= ($_GET['sucesso'] ?? '') === '1' ? 'alert-success' : 'alert-danger' ?> text-start">
                        <?= htmlspecialchars($_GET['msg']) ?>
                    </div>
                <?php } ?>

                <form action="<?= BASE_URL ?>/cadastrarConsulta" method="POST" class="d-flex flex-column gap-3">
                    <label class="form-label fw-semibold" for="nmDiaSemana">Qual a sua preferência de dia?</label>
                    <select class="form-control" id="nmDiaSemana" name="nmDiaSemana" required>
                        <option value="" selected disabled>Selecione um dia</option>
                        <option value="Segunda-feira">Segunda-feira</option>
                        <option value="Terça-feira">Terça-feira</option>
                        <option value="Quarta-feira">Quarta-feira</option>
                        <option value="Quinta-feira">Quinta-feira</option>
                        <option value="Sexta-feira">Sexta-feira</option>
                        <option value="Sábado">Sábado</option>
                    </select>

                    <label class="form-label fw-semibold" for="horarioInicial">Qual a sua preferência de horário?</label>
                    <input class="form-control" type="time" id="horarioInicial" name="horarioInicial" required>

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

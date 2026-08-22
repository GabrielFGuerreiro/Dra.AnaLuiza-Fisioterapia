<section class="py-5">
    <div class="text-center mb-5">
        <span class="section-kicker">Painel administrativo</span>
        <h2 class="fw-bold mb-2">Gerenciar Depoimentos</h2>
        <p>Visualize e gerencie os depoimentos dos pacientes.</p>
    </div>

    <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 55.9vh;">
        <div class="moving-card position-relative text-center" style="z-index: 2; max-width: 700px;">
            <img src="<?= BASE_URL ?>/Images/Fisioterapia.png"
                class="position-absolute top-50 start-50 translate-middle opacity-50"
                style="max-width: 650px; z-index: -1;">

            <div class="position-relative text-center w-100" style="z-index: 2;">
                <h1 class="display-4 fw-bold text-success mb-4">Avaliação de Atendimento</h1>

                <div style="max-width: 700px;">

                    <form action="<?= BASE_URL ?>/cadastrarDepoimento" method="POST" enctype="multipart/form-data" class="d-flex flex-column gap-3">
                        <div class="text-start">
                            <label for="opiniao" class="form-label fw-semibold">O que o cliente achou do atendimento?</label>
                            <textarea name="opiniao" id="opiniao" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="text-start ">
                            <label for="arqDepoimento" class="form-label fw-semibold">Insira uma foto ou vídeo do atendimento</label>
                            <input type="file" name="arqDepoimento" id="arqDepoimento" accept="image/*,video/*" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success btn-lg">Salvar Avaliação</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require "footer.php"; ?>

<!-- 
    Precisamos adicionar o integração ao banco, para que possa ser feito o ADD do depoimento, 
    quanto tambem receber os depoimentos anteriores para mostrar ordenado por datetime 
    

    no input de imagem/video, fazer uma função com javascript para mostrar um preview, para o usuario saber que esta enviando a midia correta.
 -->
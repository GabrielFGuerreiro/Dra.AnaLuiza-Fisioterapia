<div class="admin-testimonials-page">
    <section class="admin-testimonials container py-5">
        <div class="admin-testimonials-heading">
            <span class="section-kicker">Painel administrativo</span>
            <h1>Gerenciar depoimentos</h1>
            <p>Adicione novos relatos e mantenha as experiências dos pacientes sempre atualizadas.</p>
        </div>

        <div class="admin-testimonials-layout">
            <section class="testimonial-form-card">
                <div class="admin-card-heading">
                    <span class="admin-card-icon"><i class="fa-solid fa-plus"></i></span>
                    <div><h2>Novo depoimento</h2><p>Compartilhe uma nova experiência.</p></div>
                </div>
                <div id="msgAlerta" class="alerta-form form-alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span></span>
                </div>
                <form action="<?= BASE_URL ?>/cadastrarDepoimento" method="POST" enctype="multipart/form-data" class="testimonial-admin-form form-layout" id="formNovoDepoimento">
                    <div>
                        <label for="nomePaciente">Nome do paciente <span>(obrigatório com relato)</span></label>
                        <input type="text" name="nomePaciente" id="nomePaciente" maxlength="120" placeholder="Ex.: Maria Silva">
                    </div>
                    <div>
                        <label for="opiniao">Relato do paciente <span>(opcional apenas para vídeo)</span></label>
                        <textarea name="opiniao" id="opiniao" rows="6" maxlength="255" placeholder="Digite o depoimento..." style="resize: none"></textarea>
                    </div>
                    <div>
                        <label for="arqDepoimento">Foto ou vídeo</label>
                        <input type="file" name="arqDepoimento" id="arqDepoimento" accept="image/*,video/*"><small>Vídeos podem ser cadastrados sem nome ou relato. Imagens exigem nome e relato.</small>
                    </div>
                    <button type="submit" class="admin-primary-button"><i class="fa-solid fa-check"></i> Salvar depoimento</button>
                </form>
            </section>

            <section class="testimonial-list-section">
                <div class="testimonial-list-heading">
                    <div><span class="section-kicker">Conteúdo publicado</span>
                        <h2>Depoimentos salvos</h2>
                    </div>
                    <span class="testimonial-count"><?= count($depoimentos ?? []) ?> <?= count($depoimentos ?? []) === 1 ? 'depoimento' : 'depoimentos' ?></span>
                </div>
                <?php if (empty($depoimentos)) { ?>
                    <div class="testimonial-empty"><i class="fa-regular fa-comments"></i><p>Nenhum depoimento cadastrado ainda.</p></div>
                <?php } else { ?>
                    <div class="testimonial-admin-grid">
                        <?php foreach ($depoimentos as $depoimento) { $arquivo = $depoimento['caminhoArquivo'] ?? ''; $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION)); $ehVideo = in_array($extensao, ['mp4', 'mkv', 'avi', 'mov', 'webm'], true); $ativo = (int) ($depoimento['ativo'] ?? 1) === 1; ?>
                            <article class="testimonial-admin-card <?= $ehVideo ? 'has-video' : 'has-image' ?>">
                                <div class="testimonial-card-topline">
                                    <form action="<?= BASE_URL ?>/excluirDepoimento" method="POST" id="formExcluirDepoimento">
                                        <input type="hidden" name="idDepoimento" value="<?= (int) $depoimento['idDepoimento'] ?>">
                                        <button type="submit" class="status-toggle is-active" title="Excluir Depoimento">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    <span></span>
                                    <form action="<?= BASE_URL ?>/alternarDepoimento" method="POST">
                                        <input type="hidden" name="idDepoimento" value="<?= (int) $depoimento['idDepoimento'] ?>">
                                        <button type="submit" class="status-toggle <?= $ativo ? 'is-active' : 'is-inactive' ?>" title="<?= $ativo ? 'Inativar depoimento' : 'Ativar depoimento' ?>">
                                            <i class="fa-solid <?= $ativo ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="testimonial-media-preview <?= $ehVideo ? 'is-video' : 'is-image' ?>">
                                    <?php if ($arquivo) { ?>
                                        <?php if ($ehVideo) { ?><video src="<?= BASE_URL ?>/arquivosDepoimentos/<?= htmlspecialchars(basename($arquivo)) ?>" controls></video><?php } else { ?><img src="<?= BASE_URL ?>/arquivosDepoimentos/<?= htmlspecialchars(basename($arquivo)) ?>" alt="Mídia do depoimento"><?php } ?>
                                    <?php } ?>
                                </div>
                                <?php if (!$ehVideo) { ?><form action="<?= BASE_URL ?>/editarDepoimento" method="POST" class="testimonial-edit-form">
                                    <input type="hidden" name="idDepoimento" value="<?= (int) $depoimento['idDepoimento'] ?>">
                                    <label for="nome-<?= (int) $depoimento['idDepoimento'] ?>">Nome do paciente</label>
                                    <input id="nome-<?= (int) $depoimento['idDepoimento'] ?>" type="text" name="nomePaciente" maxlength="120" value="<?= htmlspecialchars($depoimento['nmPaciente'] ?? '') ?>">
                                    <label for="opiniao-<?= (int) $depoimento['idDepoimento'] ?>">Depoimento</label>
                                    <textarea id="opiniao-<?= (int) $depoimento['idDepoimento'] ?>" name="opiniao" maxlength="255" style="resize: none"><?= htmlspecialchars($depoimento['dsDepoimento']) ?></textarea>
                                    <button type="submit" class="admin-secondary-button"><i class="fa-solid fa-pen"></i> Atualizar</button>
                                </form><?php } ?>
                            </article>
                        <?php } ?>
                    </div>
                <?php } ?>
            </section>
        </div>
    </section>
</div>
<?php require "footer.php"; ?>

<script>

    document.addEventListener("DOMContentLoaded", function () {
        const params = new URLSearchParams(window.location.search);
        const msg = params.get("msg");
        const sucesso = params.get("sucesso");
        if (msg)
        {
            Swal.fire({
                toast: true,
                position: "top-end",
                icon: sucesso === "1" ? "success" : "error",
                title: msg,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            // O resultado já foi exibido; remove os dados do POST da URL.
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });


    document.getElementById("formNovoDepoimento").addEventListener("submit", function (e)
    {
        e.preventDefault();

        let nome = document.getElementById("nomePaciente").value;
        let opiniao = document.getElementById("opiniao").value;
        let arquivo = document.getElementById("arqDepoimento").files[0];
        let ehVideo = arquivo && arquivo.type.startsWith("video/");
        if(!arquivo)
        {
            mostrarAlerta("Selecione uma imagem ou um vídeo.");
            return;
        }
        if(!ehVideo && (!nome.trim() || !opiniao.trim()))
        {
            mostrarAlerta("Para imagens, informe o nome e o relato do paciente.");
            return;
        }
        this.submit();
    });

    document.getElementById("formExcluirDepoimento")?.addEventListener("submit", function(e)
    {
        e.preventDefault();
         Swal.fire({
                title: "Deseja Excluir o Depoimento?",
                icon: "warning",
                confirmButtonText: "Sim",
                showCancelButton: true,
                cancelButtonText: "Não"
            }).then((resultado) => {
                if(resultado.isConfirmed)
                    this.submit();
            });
    });


</script>

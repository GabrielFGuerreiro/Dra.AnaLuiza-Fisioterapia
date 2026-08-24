<section class="container py-5"> <!-- pc = pre consulta -->
    <div class="preconsultas-heading text-center mb-5">
        <span class="section-kicker">Painel administrativo</span>
        <h2 class="fw-bold mb-2">Pré-consultas pendentes</h2>
        <p>Preferências enviadas pelos pacientes, aguardando confirmação de data e horário.</p>
    </div>

    <?php if (!empty($_GET['msg'])) { ?>
        <div class="alert <?= ($_GET['sucesso'] ?? '') === '1' ? 'alert-success' : 'alert-danger' ?> text-center" style="max-width: 700px; margin: 0 auto 30px;">
            <?= htmlspecialchars($_GET['msg']) ?>
        </div>
    <?php } ?>

    <?php if (empty($pendentes)) { ?>
        <div class="moving-card text-center" style="max-width: 600px; margin: 0 auto;">
            <p class="mb-0">Nenhuma pré-consulta pendente no momento.</p>
        </div>
    <?php } else { ?>
        <div class="preconsultas-list">
            <?php foreach ($pendentes as $p) { ?>
                <?php
                    $dataPreferida = '';
                    if (preg_match('/Data de preferência:\s*(\d{4}-\d{2}-\d{2})/', $p['observacao'] ?? '', $dataMatch)) {
                        $dataPreferida = $dataMatch[1];
                    }
                ?>
                <article class="preconsulta-pendente-card">
                    <div class="preconsulta-pendente-header">
                        <div>
                            <span class="section-kicker">Solicitação recebida</span>
                            <h3><?= htmlspecialchars($p['nmUsuario']) ?></h3>
                        </div>
                        <span class="preconsulta-status">Aguardando análise</span>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-5">
                            <div class="preconsulta-resumo">
                                <p><strong>Data solicitada</strong><span><?= $dataPreferida ? date('d/m/Y', strtotime($dataPreferida)) : 'Não informada' ?></span></p>
                                <p><strong>Horário</strong><span><?= substr($p['horarioInicial'], 0, 5) ?> às <?= substr($p['horarioFinal'], 0, 5) ?></span></p>
                                <?php if (!empty($p['observacao'])) { ?>
                                    <p><strong>Observação</strong><span><?= nl2br(htmlspecialchars(preg_replace('/Data de preferência:\s*\d{4}-\d{2}-\d{2}\s*/', '', $p['observacao']))) ?></span></p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <form action="<?= BASE_URL ?>/confirmarConsulta" method="POST" class="d-flex flex-column gap-3">
                                <input type="hidden" name="idPreConsulta" value="<?= (int) $p['idPreConsulta'] ?>">

                                <div>
                                    <label class="form-label fw-semibold" for="dtConsulta-<?= $p['idPreConsulta'] ?>">Data da consulta</label>
                                    <input class="form-control" type="date" id="dtConsulta-<?= $p['idPreConsulta'] ?>" name="dtConsulta" value="<?= htmlspecialchars($dataPreferida) ?>" required>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label fw-semibold" for="horarioInicial-<?= $p['idPreConsulta'] ?>">Horário inicial</label>
                                        <input class="form-control" type="time" id="horarioInicial-<?= $p['idPreConsulta'] ?>" name="horarioInicial" value="<?= substr($p['horarioInicial'], 0, 5) ?>" required>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label fw-semibold" for="horarioFinal-<?= $p['idPreConsulta'] ?>">Horário final</label>
                                        <input class="form-control" type="time" id="horarioFinal-<?= $p['idPreConsulta'] ?>" name="horarioFinal" value="<?= substr($p['horarioFinal'], 0, 5) ?>" required>
                                    </div>
                                </div>

                                <button type="submit" class="preconsulta-confirmar-button"><i class="fa-solid fa-check"></i> Aceitar e confirmar</button>
                            </form>
                            <button type="button" class="preconsulta-negar-trigger" data-target="negacao-<?= (int) $p['idPreConsulta'] ?>"><i class="fa-solid fa-xmark"></i> Negar solicitação</button>
                            <form action="<?= BASE_URL ?>/negarConsulta" method="POST" class="preconsulta-negacao-form" id="negacao-<?= (int) $p['idPreConsulta'] ?>" hidden>
                                <input type="hidden" name="idPreConsulta" value="<?= (int) $p['idPreConsulta'] ?>">
                                <label for="motivo-<?= (int) $p['idPreConsulta'] ?>">Motivo da negativa</label>
                                <textarea id="motivo-<?= (int) $p['idPreConsulta'] ?>" name="motivoNegacao" rows="3" maxlength="500" required placeholder="Explique brevemente o motivo..."></textarea>
                                <button type="submit" class="preconsulta-negar-button">Enviar negativa</button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="text-center mt-5">
        <a href="<?= BASE_URL ?>/agendamentos" class="btn btn-outline-success">&larr; Voltar para a agenda</a>
    </div>
</section>

<?php require "footer.php"; ?>

<script>
document.querySelectorAll('.preconsulta-negar-trigger').forEach((botao) => {
    botao.addEventListener('click', () => {
        const formulario = document.getElementById(botao.dataset.target);
        formulario.hidden = !formulario.hidden;
        botao.setAttribute('aria-expanded', String(!formulario.hidden));
        if (!formulario.hidden) formulario.querySelector('textarea').focus();
    });
});
</script>

<section class="container py-5"> <!-- pc = pre consulta -->
    <div class="text-center mb-5">
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
        <div class="d-flex flex-column gap-4" style="max-width: 900px; margin: 0 auto;">
            <?php foreach ($pendentes as $p) { ?>
                <div class="moving-card">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold mb-3"><?= htmlspecialchars($p['nmUsuario']) ?></h5>

                            <p class="mb-1"><strong>Preferência:</strong> <?= htmlspecialchars($p['nmDiaSemana']) ?>, às <?= substr($p['horarioInicial'], 0, 5) ?></p>
                            <p class="mb-1"><strong>Local da dor:</strong> <?= htmlspecialchars($p['localDor']) ?></p>

                            <?php if (!empty($p['tempoSintoma'])) { ?>
                                <p class="mb-1"><strong>Há quanto tempo:</strong> <?= htmlspecialchars($p['tempoSintoma']) ?></p>
                            <?php } ?>

                            <?php if (!empty($p['descricaoSintoma'])) { ?>
                                <p class="mb-1"><strong>Descrição:</strong> <?= htmlspecialchars($p['descricaoSintoma']) ?></p>
                            <?php } ?>

                            <?php if ($p['escalaDor'] !== null) { ?>
                                <p class="mb-1"><strong>Nível de dor:</strong> <?= (int) $p['escalaDor'] ?>/10</p>
                            <?php } ?>

                            <?php if (!empty($p['comorbidades'])) { ?>
                                <p class="mb-0"><strong>Comorbidades:</strong> <?= htmlspecialchars($p['comorbidades']) ?></p>
                            <?php } ?>
                        </div>

                        <div class="col-md-6">
                            <form action="<?= BASE_URL ?>/confirmarConsulta" method="POST" class="d-flex flex-column gap-3">
                                <input type="hidden" name="idPreConsulta" value="<?= (int) $p['idPreConsulta'] ?>">

                                <div>
                                    <label class="form-label fw-semibold" for="dtConsulta-<?= $p['idPreConsulta'] ?>">Data da consulta</label>
                                    <input class="form-control" type="date" id="dtConsulta-<?= $p['idPreConsulta'] ?>" name="dtConsulta" required>
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

                                <button type="submit" class="btn btn-success">Confirmar agendamento</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="text-center mt-5">
        <a href="<?= BASE_URL ?>/agendamentos" class="btn btn-outline-success">&larr; Voltar para a agenda</a>
    </div>
</section>

<?php require "footer.php"; ?>

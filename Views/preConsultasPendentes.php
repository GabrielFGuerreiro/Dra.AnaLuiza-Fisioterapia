<section class="container py-5"> <!-- pc = pre consulta -->
    <div class="preconsultas-heading text-center mb-5">
        <span class="section-kicker">Painel administrativo</span>
        <h2 class="fw-bold mb-2">Pré-consultas pendentes</h2>
        <p>Analise cada preferência e confirme, proponha outro horário ou informe a indisponibilidade.</p>
    </div>

    <?php if (empty($pendentes)) { ?>
        <div class="preconsultas-empty text-center">
            <span class="preconsultas-empty-icon"><i class="fa-regular fa-calendar-check"></i></span>
            <h3>Tudo em dia por aqui</h3>
            <p class="mb-0">Nenhuma pré-consulta pendente no momento.</p>
        </div>
    <?php } else { ?>
        <div class="preconsultas-list">
            <?php foreach ($pendentes as $p) { ?>
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
                                <p><strong>Data solicitada</strong><span><?= $p['dtConsulta'] ? date('d/m/Y', strtotime($p['dtConsulta'])) : 'Não informada' ?></span></p>
                                <p><strong>Horário</strong><span><?= substr($p['horarioInicial'], 0, 5) ?> às <?= substr($p['horarioFinal'], 0, 5) ?></span></p>
                                <?php if (!empty($p['observacao'])) { ?>
                                    <p><strong>Observação</strong><span><?= nl2br(htmlspecialchars($p['observacao'])) ?></span></p>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <form action="<?= BASE_URL ?>/confirmarConsulta" method="POST" class="form-layout">
                                <input type="hidden" name="idPreConsulta" value="<?= (int) $p['idPreConsulta'] ?>">
                                <button type="submit" class="preconsulta-confirmar-button"><i class="fa-solid fa-check"></i> Confirmar horário solicitado</button>
                            </form>
                            <button type="button" class="preconsulta-negar-trigger" data-target="proposta-<?= (int) $p['idPreConsulta'] ?>"><i class="fa-regular fa-calendar-days"></i> Propor outro horário</button>
                            <form action="<?= BASE_URL ?>/proporHorario" method="POST" class="preconsulta-negacao-form preconsulta-proposta-form formProporHorario" id="proposta-<?= (int) $p['idPreConsulta'] ?>" hidden>
                                <input type="hidden" name="idPreConsulta" value="<?= (int) $p['idPreConsulta'] ?>">
                                <label for="dtConsulta-<?= (int) $p['idPreConsulta'] ?>">Nova data</label>
                                <input type="date" id="dtConsulta-<?= (int) $p['idPreConsulta'] ?>" name="dtConsulta" value="<?= htmlspecialchars($p['dtConsulta']) ?>" required>
                                <label for="horarioInicial-<?= (int) $p['idPreConsulta'] ?>">Novo horário</label>
                                <input type="time" id="horarioInicial-<?= (int) $p['idPreConsulta'] ?>" name="horarioInicial" value="<?= substr($p['horarioInicial'], 0, 5) ?>" required>
                                <small>A duração prevista continua sendo de uma hora.</small>
                                <label for="mensagem-proposta-<?= (int) $p['idPreConsulta'] ?>">Mensagem ao paciente <span>(opcional)</span></label>
                                <textarea id="mensagem-proposta-<?= (int) $p['idPreConsulta'] ?>" name="mensagem" rows="3" maxlength="500" placeholder="Ex.: Este é o horário disponível mais próximo."></textarea>
                                <button type="submit" class="preconsulta-confirmar-button">Enviar proposta</button>
                            </form>
                            <button type="button" class="preconsulta-negar-trigger preconsulta-indisponivel-trigger" data-target="indisponibilidade-<?= (int) $p['idPreConsulta'] ?>"><i class="fa-solid fa-xmark"></i> Horário indisponível</button>
                            <form action="<?= BASE_URL ?>/indisponibilizarConsulta" method="POST" class="preconsulta-negacao-form" id="indisponibilidade-<?= (int) $p['idPreConsulta'] ?>" hidden>
                                <input type="hidden" name="idPreConsulta" value="<?= (int) $p['idPreConsulta'] ?>">
                                <label for="mensagem-indisponibilidade-<?= (int) $p['idPreConsulta'] ?>">Mensagem ao paciente</label>
                                <textarea id="mensagem-indisponibilidade-<?= (int) $p['idPreConsulta'] ?>" name="mensagem" rows="3" maxlength="500" required placeholder="Explique brevemente e oriente o próximo passo..."></textarea>
                                <button type="submit" class="preconsulta-negar-button">Informar indisponibilidade</button>
                            </form>
                        </div>
                    </div>
                </article>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="text-center mt-5">
        <a href="<?= BASE_URL ?>/agendamentos" class="preconsultas-back-button"><i class="fa-solid fa-arrow-left"></i><span>Voltar para a agenda</span></a>
    </div>
</section>

<?php require "footer.php"; ?>

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
            showCancelButton: <?= !empty($whatsappUrl) ? 'true' : 'false' ?>,
            confirmButtonText: <?= !empty($whatsappUrl) ? "'Abrir WhatsApp'" : "'Ok'" ?>,
            cancelButtonText: 'Fechar'
        }).then((resultado) => {
            <?php if (!empty($whatsappUrl)) { ?>
            if (resultado.isConfirmed) window.open(<?= json_encode($whatsappUrl) ?>, '_blank', 'noopener');
            <?php } ?>
        });

        // O resultado já foi exibido; remove os dados do POST da URL.
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

document.querySelectorAll(".formProporHorario").forEach(form => {
    form.addEventListener("submit", function(e)
    {
        const idPreConsulta = this.querySelector('input[name="idPreConsulta"]').value;
        let dataConsulta = document.getElementById(`dtConsulta-${idPreConsulta}`).value;

        const hoje = new Date();
        const ano = hoje.getFullYear();
        const mes = String(hoje.getMonth() + 1).padStart(2, "0");
        const dia = String(hoje.getDate()).padStart(2, "0");

        if(!dataConsulta) {
            e.preventDefault();
            return;
        }

        if(dataConsulta < `${ano}-${mes}-${dia}`)
        {
            e.preventDefault();
            Swal.fire({ title: 'A nova data não pode ser anterior à data atual.', icon: 'error', confirmButtonText: 'Ok' });
            return;
        }

        if(!document.getElementById(`horarioInicial-${idPreConsulta}`).value) {
            e.preventDefault();
        }
    });
});

document.querySelectorAll('.preconsulta-negar-trigger').forEach((botao) => {
    botao.addEventListener('click', () => {
        const formulario = document.getElementById(botao.dataset.target);
        const areaAcoes = botao.closest('.col-md-7');
        const seraAberto = formulario.hidden;

        areaAcoes.querySelectorAll('.preconsulta-negacao-form').forEach((outroFormulario) => {
            outroFormulario.hidden = true;
        });
        areaAcoes.querySelectorAll('.preconsulta-negar-trigger').forEach((outroBotao) => {
            outroBotao.setAttribute('aria-expanded', 'false');
        });

        formulario.hidden = !seraAberto;
        botao.setAttribute('aria-expanded', String(seraAberto));

        if (seraAberto) formulario.querySelector('input:not([type="hidden"]), textarea').focus();
    });
});
</script>

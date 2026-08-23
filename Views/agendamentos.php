<?php
    require_once RAIZ . "/scripts/calendario-lib.html";
?>

<section class="container py-5">
    <div class="text-center mb-5">
        <span class="section-kicker">Painel administrativo</span>
        <h2 class="fw-bold mb-2">Agenda de consultas</h2>
        <p>Visualize os agendamentos dos pacientes por mês, semana ou em lista.</p>
    </div>

    <div class="moving-card">
        <div id="calendario"></div>
    </div>

    <div class="text-center mt-4">
        <a href="<?= BASE_URL ?>/preConsultasPendentes" class="btn btn-success btn-lg">Ver pré-consultas pendentes</a>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const calendarioEl = document.getElementById("calendario");

        const calendario = new FullCalendar.Calendar(calendarioEl, {
            locale: "pt-br",
            initialView: "dayGridMonth",
            height: "auto",
            eventColor: "#577A61",
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,timeGridWeek,listWeek"
            },
            events: {
                url: "<?= BASE_URL ?>/listarAgendamentosJson",
                failure: function () {
                    console.error("Não foi possível carregar os agendamentos.");
                }
            }
        });

        calendario.render();
    });
</script>
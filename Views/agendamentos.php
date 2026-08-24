<?php
    require_once RAIZ . "/scripts/calendario-lib.html";
?>

<section class="appointments-page container py-5">
    <div class="appointments-heading text-center">
        <span class="section-kicker">Painel administrativo</span>
        <h2 class="fw-bold mb-2">Agenda de consultas</h2>
        <p>Visualize os agendamentos dos pacientes por mês, semana ou em lista.</p>
    </div>

    <div class="appointments-card moving-card">
        <div id="calendario"></div>
    </div>

    <div class="text-center mt-4">
        <a href="<?= BASE_URL ?>/preConsultasPendentes" class="appointments-action">Ver pré-consultas pendentes <i class="fa-solid fa-arrow-right"></i></a>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const calendarioEl = document.getElementById("calendario");

        const mobile = window.matchMedia("(max-width: 575.98px)");
        const calendario = new FullCalendar.Calendar(calendarioEl, {
            locale: "pt-br",
            initialView: mobile.matches ? "listWeek" : "dayGridMonth",
            height: "auto",
            eventColor: "#577A61",
            displayEventTime: true,
            allDaySlot: false,
            noEventsContent: "Nenhum agendamento neste período",
            headerToolbar: mobile.matches ? { left: "prev,next", center: "title", right: "listWeek" } : { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,listWeek" },
            events: {
                url: "<?= BASE_URL ?>/listarAgendamentosJson",
                method: "GET",
                failure: function () {
                    calendarioEl.insertAdjacentHTML("beforebegin", '<div class="calendar-error">Não foi possível carregar os agendamentos.</div>');
                }
            },
            eventDidMount: function (info) {
                info.el.title = info.event.title;
            },
            eventClick: function (info) {
                fetch("<?= BASE_URL ?>/obterObservacaoAgendamento?id=" + encodeURIComponent(info.event.id))
                    .then(response => response.json())
                    .then(data => Swal.fire({
                        title: info.event.title,
                        text: data.observacao || "Nenhuma observação registrada.",
                        confirmButtonText: "Fechar"
                    }))
                    .catch(() => Swal.fire({
                        title: info.event.title,
                        text: "Não foi possível carregar a observação.",
                        confirmButtonText: "Fechar"
                    }));
            },
            loading: function (isLoading) {
                calendarioEl.classList.toggle("is-loading", isLoading);
            }
        });

        calendario.render();

        mobile.addEventListener("change", function (event) {
            calendario.setOption("headerToolbar", event.matches ? { left: "prev,next", center: "title", right: "listWeek" } : { left: "prev,next today", center: "title", right: "dayGridMonth,timeGridWeek,listWeek" });
            calendario.changeView(event.matches ? "listWeek" : "dayGridMonth");
        });
    });
</script>

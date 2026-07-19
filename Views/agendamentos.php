<?php
    require_once RAIZ . "/scripts/calendario-lib.html";
?>
<div class="conteudo">
    <h2>Lista de Agendamentos</h2>
    <div id="listaAgendamentos"></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function()
{
    chamarListaAgendamentos();
});

function chamarListaAgendamentos()
{
    fetch("/Dra.AnaLuiza-Fisioterapia/listarAgendamentosJson") // uma rota que devolve JSON puro
        .then(response => response.json())
        .then(dados => {
            const { Schedule } = calendarjs;
        

            Schedule(document.getElementById('listaAgendamentos'), {
                type: 'week',
                value: '2026-07-12',
                data: dados
            });
        });
}
</script>
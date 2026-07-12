<?php
    include RAIZ . '/Views/header.php'; 
    require_once RAIZ . "/scripts/calendario-lib.html";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles\custom-style.css">
    <title>Agendamentos</title>
</head>
<body>
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
</body>
</html>


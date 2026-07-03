<?php 
include "header.php";
require_once "Models/Database.php";
require_once "scripts/calendario-lib.html";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos</title>
</head>
<body>
    <div class="conteudo">
        <h2>Lista de Agendamentos</h2>
        <div class="card" id='schdl' style="width: 1400px; height: 650px; position: fixed;"></div>

        <script>
            const { Schedule } = calendarjs;

            Schedule(document.getElementById('schdl'), {
                type: 'week',
                value: '2025-12-01',
                data: [
                    { guid: 'evt-1', title: 'Team Meeting', date: '2025-12-03', start: '10:00', end: '11:00', color: '#3498db' },
                    { guid: 'evt-2', title: 'Project Review', date: '2025-12-04', start: '14:00', end: '15:30', color: '#e74c3c' }
                ]
            });
        </script>
    </div>
</body>
</html>
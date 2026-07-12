<?php include RAIZ . '/Views/header.php'; ?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar</title>
</head>
<body>
    <div class="conteudo">
        <h2>Lista de Agendamentos</h2>
        <div class="card" id='calendar' style="width: 400px; height: 550px;"></div>
        <script >
            const { Calendar } = calendarjs;

            Calendar(document.getElementById('calendar'), {
                type: 'inline',
                time: true,
                grid: true,
                value: new Date()
            });
        </script>
    </div>
</body>
</html>
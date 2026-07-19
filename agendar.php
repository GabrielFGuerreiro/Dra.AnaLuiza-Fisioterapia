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
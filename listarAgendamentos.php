<?php 
require_once __DIR__ . "/vendor/autoload.php";

use DraAnaLuiza\Models\Database;

include "header.php";
require_once "scripts/calendario-lib.html";

$db = new Database();
$pdo = $db->getConnection();
$sql = 'SELECT idPreConsulta, u.nmUsuario, horarioInicial, horarioFinal FROM preconsultas pc JOIN usuarios u ON pc.idUsuario = u.idUsuario';

$stmt = $pdo->prepare($sql);
$stmt->execute();
$consultas = $stmt->fetch(PDO::FETCH_ASSOC);

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
        <div class="card" id='schdl' style="width: 1400px; height: 650px; position: fixed;"></div>



        <script>
            const { Schedule } = calendarjs;

            Schedule(document.getElementById('schdl'), {
                type: 'week',
                value: '2025-12-01',
                data: [
                   <?php 
                        echo "{ 
                        guid: 'evt-" . $consultas['idPreConsulta']  . "',
                        title:'" . $consultas['nmUsuario']  . "',
                        date:'2025-12-07' , start: '06:00',
                        end: '10:00',
                        color: 'red'
                        }";
                    ?>
                    
                    // {guid: 'evt-".$consulta['idPreConsulta']  . "',title:" . $consulta['nmUsuario']  . ", date:'2025-12-07' , start: '06:00', end: '10:00', color: 'red' }
                    { guid: 'evt-1', title: 'Team Meeting', date: '2025-12-03', start: '10:00', end: '11:00', color: '#3498db' }
                    // { guid: 'evt-2', title: 'Project Review', date: '2025-12-04', start: '14:00', end: '15:30', color: '#e74c3c' }
                    // { guid: 'evt-3', title: 'Matheus', date: '2025-12-06', start: '15:00', end: '17:00', color: '#a8f8f1'}
                ]
            });
        </script>
    </div>
            <form action="" method="POST">
            <input type="text" name="a" id="a">
            <button type="submit">test</button>
            <?php echo $consultas['nmUsuario']; ?>
        </form>
</body>
</html>
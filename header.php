<?php 
    include "Models/Database.php";
    $db = new Database();
    $pdo = $db->getConnection();

    $sql = "SELECT isAdmin FROM usuarios Where email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => 'senac@gmail.com']);
    $isAdmin = $stmt->fetchColumn();

    
?>

<header>
    <style>html {color-scheme: light;}</style>
    <link rel="stylesheet" href="styles/light.css">
    <div class="lateral">
        <div class="lateral-texto">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <h2>&nbsp;&nbsp;Dra. Ana &nbsp;&nbsp;Fisioterapia</h2>
            </div>

            <a class="msg" href="index.php">Inicio</a>
            <a class="msg" href="avalie.php">Depoimentos</a>
            <a class="msg" href="preConsulta.php">Entre em Contato</a>

            <?php 
                
                if ($isAdmin === true)
                {
                    echo 'cock vore';
                }
            ?>
        </div>
    </div>
</header>


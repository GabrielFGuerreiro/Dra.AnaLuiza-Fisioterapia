<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    require_once "Models/Database.php";
    $db = new Database();
    $pdo = $db->getConnection();

    $isAdmin = 0;
    $nomeUsuario = '';

    if (isset($_SESSION['email'])) {
        $sql = "SELECT nmUsuario, isAdmin FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $_SESSION['email']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            $nomeUsuario = $user['nmUsuario'];
            $isAdmin = $user['isAdmin'];
        }
    }
?>

<header>
    <style>html {color-scheme: light;}</style>
    <link rel="stylesheet" href="styles/light.css">
    <div class="lateral">
        <div class="lateral-texto">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2>&nbsp;&nbsp;Dra. Ana &nbsp;&nbsp;Fisioterapia</h2>
                </div>

                <a class="msg" href="inicio.php">Inicio</a>
                
                <a class="msg" href="preConsulta.php">Entre em Contato</a>

            </div>

            <div>
                <?php 
                    if (isset($_SESSION['email'])) {
                        if ($isAdmin == 0) {
                            echo '<a class="msg" href="listarAgendamentos.php">Ver Agendamentos</a>';
                            echo '<a class="msg" href="Depoimentos.php">Gerenciar Depoimentos</a>';
                        }
                        echo '<div><a class="user">Olá, ' . htmlspecialchars($nomeUsuario) . '!</a>';
                        echo '<a class="user out" href="logout.php">Sair</a></div>';
                        
                        
                    } else {
                        echo '<a class="msg" href="login.php">Faça Login</a>';
                        echo '<a class="msg" href="cadastrar.php">Cadastre-se</a>';
                    }
                ?>
            </div>
        </div>
    </div>
</header>


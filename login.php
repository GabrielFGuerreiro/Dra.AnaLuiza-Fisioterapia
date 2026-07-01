<?php
    include "header.php";

    if(session_id() == ''){
        session_start();
    }
    
    require_once "Models/Database.php";
    
    // Se já está logado, redireciona para inicio
    if (isset($_SESSION['email'])) {
        header("Location: inicio.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/light.css">
    <title>Fisio com a Ana</title>
</head>

<body>
    <style>
    body {
        position: relative;
        right:30px;
    }
    </style>
    <div class="conteudo" >
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <input id="email" name="email" class="form-field" type="email" placeholder="Digite o E-mail.">
            <input id="password" name="password" class="form-field" type="password" placeholder="Digite a Senha."><br>
            <button>Logar!</button>
            
    <?php 
    if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $email = $_POST['email'];
        $senha = $_POST['password'];
        $db = new Database();
        $pdo = $db->getConnection();
        
        $sql = "SELECT senha FROM USUARIOS WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if( password_verify($senha, $usuario["senha"]))
        {
            $_SESSION['email'] = $email;
            header("Location: inicio.php");
            exit();
        }
        else
            echo "<p style='text-align: center;'>E-mail ou Senha Inválido.</p>";
    }
    ?>
        </form>
    </div>
</body>
</html>

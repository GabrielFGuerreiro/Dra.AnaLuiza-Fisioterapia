<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisio com a Ana</title>
    <link rel="stylesheet" href="../styles/light.css">
</head>

<body>
    <style>
        body {
            position: relative;
            right:150px;
        }
    </style>
    <div class="conteudo" >
        <h2>Login</h2>
        <form action="inicio.php" method="POST">
            <input id="email" name="email" class="form-field" type="email" placeholder="Digite o E-mail.">
            <input id="password" name="password" class="form-field" type="password" placeholder="Digite a Senha."><br>
            <button>Cadastrar-se!</button>
        </form>
    </div>
</body>
</html>

<?php 
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $db = new Database();
    $pdo = $db->getConnection();

    $sql = "SELECT SENHA FROM USUARIOS WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($senha, $usuario["senha"]))
    {
        
    }
    else
        echo "E-mail ou Senha Inválido.";
}


?>


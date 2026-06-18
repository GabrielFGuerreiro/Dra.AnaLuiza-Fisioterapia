<?php 
    include "Models/Database.php";
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
            right:150px;
        }
    </style>
    <div class="conteudo" >
        <h2>Login</h2>
        <form action="" method="post">
                <input id="email" name="email" type="email" placeholder="Digite o E-mail.">
                <input id="senha" name="senha" type="senha" placeholder="Digite a Senha."><br>
            <button>Cadastrar-se!</button>


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
        echo "<p style='text-align: center;'>E-mail ou Senha Inválido.</p>";
}
?>
        </form>
    </div>
</body>
</html>

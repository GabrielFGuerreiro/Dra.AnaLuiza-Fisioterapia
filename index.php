<?php 
    include "header.php";
    include "Models/Database.php";
    function mensagem() {
        echo "Boas Vindas!";
    }
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/placeholder.css">
    <title>Fisio com a Ana</title>
</head>

<body>
    <form action="" method="post">
        <div class="container" >
            <h2 class="conteudo">Login</h2>
    
            <div class="form-group">
                <input id="email" name="email" class="form-field" type="email" placeholder="Digite o E-mail.">
                <input id="password" name="password" class="form-field" type="password" placeholder="Digite a Senha."><br>
            </div>
        </div>
        <br>0,
        
        <button>Cadastrar-se!</button>
    </form>
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


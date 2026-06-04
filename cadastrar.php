<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <form action="" method="post">
        <label for="">Nome</label>
        <input type="text" id="nome" name="nome">

        <label for="">E-mail</label>
        <input type="email" id="email" name="email">

        <label for="">Senha</label>
        <input type="text" name="password" id="password">

        <button>Cadastrar</button>
    </form>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    try
    {
        $sql = "INSERT INTO USUARIO (nmUsuario, cpf, dataNasc, email, celular, isAdmin, senha) 
                VALUES (:nome, :cpf, :dataNasc, :email, :celular, 0, :senha)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":nome" => $nome,
            ":cfp" => $cpf,
            
        ]);

    }
    catch(PDOException $e)
    {

    }

}

?>
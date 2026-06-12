<?php 
    include "header.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
</head>
<body>
    <div class="conteudo">
        <form action="" method="post">
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome">

            <label for="cpf">CPF</label>
            <input type="text" id="cpf" name="cpf">

            <label for="dtNasc">Data de Nascimento</label>
            <input type="date" id="dtNasc" name="dtNasc">

            <label for="cel">Celular</label>
            <input type="text" id="cel" name="cel">

            <label for="emailCad">E-mail</label>
            <input type="email" id="emailCad" name="emailCad">

            <label for="senhaCad">Senha</label>
            <input type="password" id="senhaCad" name="senhaCad">

            <button>Cadastrar</button>
        </form>
    </div>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $dtNasc = $_POST['dtNasc'];
    $email = $_POST['emailCad'];
    $cel = $_POST['cel'];
    $senha = password_hash($_POST['senhaCad'], PASSWORD_DEFAULT);

    try
    {
        // $sql = "INSERT INTO USUARIOS (nmUsuario, cpf, dataNasc, email, celular, isAdmin, senha) 
        //         VALUES (:nome, :cpf, :dataNasc, :email, :celular, 0, :senha)";
        // $stmt = $pdo->prepare($sql);
        // $stmt->execute([
        //     ":nome" => $nome,
        //     ":cpf" => $cpf,
        //     ":dataNasc" => $dtNasc,
        //     ":email" => $email,
        //     ":celular" => $cel,
        //     ":senha" => $senha            
        // ]);

    }
    catch(PDOException $e)
    {

    }
}

?>
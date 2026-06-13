<?php 
include "header.php";
include "Models/Database.php";

if (isset($_GET['sucesso'])) {
    echo "Cadastro realizado com sucesso!";
}

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
        $db = new Database();
        $pdo = $db->getConnection();

        $sql = "SELECT COUNT(*) FROM USUARIOS WHERE cpf = :cpf";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":cpf" => $cpf]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "CPF Já Cadastrado.";
        }
        else
        {            
            $sql = "INSERT INTO USUARIOS (nmUsuario, cpf, dataNasc, email, celular, isAdmin, senha) 
                VALUES (:nome, :cpf, :dataNasc, :email, :celular, 0, :senha)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
            ":nome" => $nome,
            ":cpf" => $cpf,
            ":dataNasc" => $dtNasc,
            ":email" => $email,
            ":celular" => $cel,
            ":senha" => $senha            
            ]);
            header("Location: cadastrar.php?sucesso=1"); //Quando cadastrar, não fica na requisição POST, vai para GET, impedindo o reenvio do form quando recarregar.
            exit();
        }
    }
    catch(PDOException $e)
    {
        echo "Erro: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
</head>
<body>
    <form action="" method="POST" id="formCadastrar">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome">
        <spam id="msgObrigatoriaNome" class="msgObrigatoria">O <b>Nome</b> é Obrigatório.</spam>

        <label for="cpf">CPF</label>
        <input type="text" id="cpf" name="cpf">
        <spam id="msgObrigatoriaCpf" class="msgObrigatoria">O <b>CPF</b> é Obrigatório.</spam>

        <label for="dtNasc">Data de Nascimento</label>
        <input type="date" id="dtNasc" name="dtNasc">

        <label for="cel">Celular</label>
        <input type="text" id="cel" name="cel">

        <label for="emailCad">E-mail</label>
        <input type="email" id="emailCad" name="emailCad">
        <spam id="msgObrigatoriaEmail" class="msgObrigatoria">O <b>CPF</b> é Obrigatório.</spam>

        <label for="senhaCad">Senha</label>
        <input type="password" id="senhaCad" name="senhaCad">
        <spam id="msgObrigatoriaSenha" class="msgObrigatoria">A <b>Senha</b> é Obrigatória.</spam>

        <spam class="requisitosSenha"><i class="fa fa-circle"></i>8 Caracteres</spam>  
        <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Letra Minúscula</spam>  
        <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Letra Maiúscula</spam>  
        <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Número</spam>  
        <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Caracter Especial</spam>  

        <button type="button" id="btnCadastrar">Cadastrar</button>
    </form>
</body>
</html>


<style>
    .msgObrigatoria {
        display: none;
        color:red;
    }

    .requisitosSenha {
        font-size: 10px;
    }

    .fa-circle {
        color:gray;
        font-size: 10px;
        margin-right: 5px;
    }
</style>


<script>
    document.getElementById("btnCadastrar").addEventListener("click", function()
    {
        var icCadastrar = true;
        // var nome = document.getElementById("nome").value;
        // if(!nome)
        // {
        //     document.getElementById("msgObrigatoriaNome").style.display = "block";
        //     icCadastrar = false;
        // }

        // var cpf = document.getElementById("cpf").value;
        // if(!cpf)
        // {
        //     document.getElementById("msgObrigatoriaCpf").style.display = "block";
        //     icCadastrar = false;
        // }

        
        var senhaCad = document.getElementById("senhaCad").value;
        if(!senhaCad)
        {
            document.getElementById("msgObrigatoriaSenha").style.display = "block";
            icCadastrar = false;
        }

        //if(icCadastrar == true)
        if(1==0)
        {
            document.getElementById("formCadastrar").submit();
        }
        
        document.querySelectorAll(".fa-circle").forEach((element) => {
            element.style.color = "red";
        });
        
    });


    document.getElementById("senhaCad").addEventListener("input", function()
    {
        console.log(this.value);
        var senha = this.value;
        var circulos = document.getElementsByClassName("fa-circle");

        circulos[0].style.color = senha.length >= 8 ? "red" : "gray";

        
        circulos[1].style.color = senha.match(/\w/g) ? "red" : "gray";
        circulos[3].style.color = senha.match(/[a-z]/g) ? "red" : "gray";

    });
</script>
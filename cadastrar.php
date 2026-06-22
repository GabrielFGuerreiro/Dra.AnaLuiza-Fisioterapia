<?php 
include "header.php";

$mensagem = '';
$tipoMensagem = '';

if (isset($_GET['sucesso'])) {
    $mensagem = "Cadastro realizado com sucesso!";
    $tipoMensagem = "Sucesso";
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

        if ($count == 0)
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
        else
        {
            $mensagem = "CPF Já Cadastrado!";
            $tipoMensagem = "Erro";
        }
    }
    catch(PDOException $e)
    {
        $mensagem = "Erro: " . $e->getMessage();
        $tipoMensagem = "Erro";
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
    <style>
    body {
        position: relative;
        right:30px;
    }
    </style>
    <div class="conteudo">
        <h2>Cadastro de Usuário</h2>
        
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
        <spam id="msgObrigatoriaEmail" class="msgObrigatoria"></spam>

            <label for="senhaCad">Senha</label>
            <input type="password" id="senhaCad" name="senhaCad">
            <spam id="msgSenha" class="msgObrigatoria"></spam>

            <div>
                <spam class="requisitosSenha"><i class="fa fa-circle"></i>8 Caracteres</spam>  
                <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Letra Minúscula</spam>  
                <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Letra Maiúscula</spam>  
                <spam class="requisitosSenha"><i class="fa fa-circle"></i>1 Número</spam>  
                <spam title="Exemplo: #, @, %, *" class="requisitosSenha"><i class="fa fa-circle" ></i >1 Caracter Especial</spam>  
            </div>

            <button type="button" id="btnCadastrar">Cadastrar</button>
        
        <?php if ($mensagem): ?>
            <div class="notif <?php echo ($tipoMensagem === 'Sucesso') ? 'Sucesso' : 'Erro'; ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
        <?php endif; ?>

        <script>
            var senhaValida = true;
            var circulos = document.querySelectorAll(".fa-circle");

            document.getElementById("btnCadastrar").addEventListener("click", function()
            {
                var icCadastrar = true;

                var nome = document.getElementById("nome").value; //Verifica se o campo nome está vazio
                var msgNome = document.getElementById("msgObrigatoriaNome");
                if(!nome)
                {
                    msgNome.style.display = "block";
                    icCadastrar = false;
                }
                else        
                    msgNome.style.display = "none";
                
                var cpf = document.getElementById("cpf").value; //Verifica se o campo cpf está vazio
                var msgCpf = document.getElementById("msgObrigatoriaCpf");
                if(!cpf)
                {
                    msgCpf.style.display = "block";
                    icCadastrar = false;
                }
                else        
                    msgCpf.style.display = "none";
                

                circulos.forEach((circulo) => { //Verifica se algum requisito da senha não foi atendido com base na cor da bolinha
                    if(circulo.style.color === "gray")
                        senhaValida = false;
                });

                var senhaCad = document.getElementById("senhaCad").value;  
                var msgSenha = document.getElementById("msgSenha");
                if(!senhaCad) //Verifica se o campo senha está vazio
                {
                    msgSenha.style.display = "block";
                    msgSenha.innerHTML = "A <b>Senha</b> é Obrigatória.";
                    icCadastrar = false;
                }
                else if(!senhaValida) //E se os requisitos da senha foram atendidos
                {
                    msgSenha.style.display = "block";
                    msgSenha.innerHTML = "Requisitos da Senha não Foram Atendidos.";
                }
                else
                    msgSenha.style.display = "none";

                if(senhaValida && icCadastrar)        
                    document.getElementById("formCadastrar").submit();        

                senhaValida = true;
            });

            document.getElementById("senhaCad").addEventListener("input", function()
            {
                var senha = this.value;

                circulos[0].style.color = senha.length >= 8 ? "#61c9b4" : "gray";
                circulos[1].style.color = senha.match(/[a-z]/g) ? "#61c9b4" : "gray";
                circulos[2].style.color = senha.match(/[A-Z]/g) ? "#61c9b4" : "gray";
                circulos[3].style.color = senha.match(/\d/g) ? "#61c9b4" : "gray";
                circulos[4].style.color = senha.match(/\W|_/g) ? "#61c9b4" : "gray";
            });
        </script>

        </form>
    </div>
</body>
</html>
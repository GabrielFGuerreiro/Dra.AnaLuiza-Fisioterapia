<?php

namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Usuario;

class UsuarioController
{
    public function Login()
    {
        require_once RAIZ . "/Views/login.php";
    }

    public function Cadastro()
    {
        require_once RAIZ . "/Views/cadastrar.php";
    }

    public function Cadastrar()
    {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $dtNasc = $_POST['dtNasc'];
        $email = $_POST['emailCad'];
        $cel = $_POST['cel'];
        $senha = $_POST['senhaCad'];

        $usuario = new Usuario();
        $retorno = $usuario->CadastrarUsuario($nome, $cpf, $dtNasc, $email, $cel, $senha);

        header("Location: /Dra.AnaLuiza-Fisioterapia/cadastro?sucesso={$retorno["sucesso"]}&msg={$retorno["mensagem"]}"); //Quando cadastrar, não fica na requisição POST, vai para GET, impedindo o reenvio do form quando recarregar.
    }

    public function Logar()
    {
        $usuario = new Usuario();
        $senhaForm = $_POST['password'];
        $emailForm = $_POST['email'];

        $dadosUsuario = $usuario->Logar($emailForm, $senhaForm);

        if($dadosUsuario !== null && password_verify($senhaForm, $dadosUsuario["senha"]))
        {
            $_SESSION['email'] = $emailForm;
            $_SESSION['nome'] = $dadosUsuario['nmUsuario'];
            $_SESSION['isAdm'] = $dadosUsuario['isAdm'];
            header("Location: /Dra.AnaLuiza-Fisioterapia/");
            exit();
        }
        else
        {
            header("Location: /Dra.AnaLuiza-Fisioterapia/login?msg=E-mail ou Senha Inválidos.");
            exit();          
        }
    }

    public function Logout()
    {
        if (session_id() == '') {
            session_start();
        }
        session_destroy();
        header("Location: " . BASE_URL . "/login");
        exit();
    }
}
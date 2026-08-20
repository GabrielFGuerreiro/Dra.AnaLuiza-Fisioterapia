<?php

namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Usuario;

class UsuarioController extends GeralController
{
    public function Login()
    {
        $this->MostrarView("login");
    }

    public function Cadastro()
    {
        $this->MostrarView("cadastrar");
    }

    public function Cadastrar()
    {
        $nome = $_POST['nome'];
        $cpf = preg_replace('/\D/', '', $_POST['cpf']);
        $dtNasc = !empty($_POST['dtNasc']) ? $_POST['dtNasc'] : null;
        $email = !empty($_POST['emailCad']) ? $_POST['emailCad'] : null;
        $cel = preg_replace('/\D/', '', $_POST['cel']);
        $senha = $_POST['senhaCad'];

        $usuario = new Usuario();
        $retorno = $usuario->CadastrarUsuario($nome, $cpf, $dtNasc, $email, $cel, $senha);

        header("Location: " . BASE_URL . "/cadastro?sucesso=" . $retorno['sucesso'] . "&msg=" . urlencode($retorno['mensagem']), true, 303); //303 = Após o POST, redireciona para GET, evitando o reenvio do formulário ao recarregar.
        exit();
    }

    public function cadastrarConsulta()
    {
        $preHora = $_POST['preHora'];
        $localDor = $_POST['localDor'];
        $tempoSintoma = $_POST['tempoSintoma'];
        $descricaoSintoma = $_POST['descricaoSintoma'];
        $escalaDor = $_POST['escalaDor'];
        $comorbidades = $_POST['comorbidades'];

        
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
            $_SESSION['isAdmin'] = $dadosUsuario['isAdmin'];
            header("Location: " . BASE_URL . "/", true, 303);
            exit();
        }
        else
        {
            header("Location: " . BASE_URL . "/login?msg=" . urlencode("E-mail ou Senha Inválidos."), true, 303);
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

    public function PreConsulta()
    {
        $this->MostrarView("preConsulta");
    }
}
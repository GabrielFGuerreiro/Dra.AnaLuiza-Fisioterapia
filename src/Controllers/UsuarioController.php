<?php

namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Usuario;
use DraAnaLuiza\Services\EmailService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

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
        $email = $_POST['emailCad'];
        $cel = preg_replace('/\D/', '', $_POST['cel']);
        $senha = $_POST['senhaCad'];

        $usuario = new Usuario();

        if($usuario->EmailExiste($email))
        {
            header("Location: " . BASE_URL . "/cadastro?sucesso=0&msg=E-mail já Cadastrado.");
            exit();
        }

        $retorno = $usuario->CadastrarUsuario($nome, $cpf, $dtNasc, $email, $cel, $senha);

        header("Location: " . BASE_URL . "/cadastro?sucesso=" . $retorno['sucesso'] . "&msg=" . urlencode($retorno['mensagem']), true, 303); //303 = Após o POST, redireciona para GET, evitando o reenvio do formulário ao recarregar.
        exit();
    }

    public function CadastrarConsulta()
    {
        $dtPreferencia = $_POST['dtPreferencia'] ?? '';
        $horarioInicial = $_POST['horarioInicial'] ?? '';
        $observacao = trim($_POST['observacao'] ?? '');

        if ($dtPreferencia === '' || $horarioInicial === '') {
            header("Location: " . BASE_URL . "/preconsulta?sucesso=0&msg=" . urlencode("Informe a data e o horário de preferência."), true, 303);
            exit();
        }

        // Duração fixa de 1h por consulta (ajustar se a Dra usar outra duração padrão)
        $horarioFinal = date('H:i:s', strtotime($horarioInicial . ' +1 hour'));

        $usuario = new Usuario();
        $retorno = $usuario->CadastrarPreConsulta($_SESSION['email'], $dtPreferencia, $horarioInicial, $horarioFinal, $observacao);

        if ($retorno['sucesso']) {
            $emailAdm = $usuario->ObterEmailAdministrador();
            if ($emailAdm) {
                EmailService::enviar(
                    $emailAdm,
                    'Nova pré-consulta solicitada',
                    "Uma nova pré-consulta foi solicitada.\n\nData: " . date('d/m/Y', strtotime($dtPreferencia)) .
                    "\nHorário: " . substr($horarioInicial, 0, 5) . " às " . substr($horarioFinal, 0, 5) .
                    "\nAcesse o painel administrativo para confirmar ou negar o atendimento."
                );
            }
        }

        header("Location: " . BASE_URL . "/preconsulta?sucesso=" . $retorno['sucesso'] . "&msg=" . urlencode($retorno['mensagem']), true, 303);
        exit();
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

    public function EsqueceuSenha()
    {
        $this->MostrarView("esqueceuSenha");
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

    public function EnviarEmailCodigo()
    {
        $codigo = random_int(100000, 999999);
        $email = $_POST['email'];
        $_SESSION['emailRecuperacao'] = $email;

        $usuario = new Usuario();

        if (!$usuario->EmailExiste($email))
        {
            header(
                "Location: " . BASE_URL .
                "/esqueciMinhaSenha?sucesso=0&msg=" .
                urlencode("E-mail Não Cadastrado.")
            );
            exit();
        }

        try
        {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = "smtp.gmail.com";
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->Username = "gaferg2004@gmail.com";
            $mail->Password = "wqbs viaf fdev qnio";

            $mail->setFrom("gaferg2004@gmail.com");
            $mail->addAddress($email);

            $mail->Subject = "Recuperação de senha";
            $mail->Body = "Seu código para recuperar a senha é: " . $codigo;
            $mail->CharSet = 'UTF-8';
            
            $mail->send();
        }
        catch (\Throwable $th)
        {
            header(
                "Location: " . BASE_URL .
                "/esqueciMinhaSenha?sucesso=0&msg=" .
                urlencode("Erro ao enviar o e-mail. Favor entrar em contato.")
            );
            exit();
        }

        $retorno = $usuario->SalvarCodigoRecuperacaoSenha($codigo, $email);
        if (!$retorno['sucesso'])
        {
            header(
                "Location: " . BASE_URL .
                "/esqueciMinhaSenha?sucesso=0&msg=" .
                urlencode($retorno['mensagem'])
            );
            exit();
        }

        header("Location: " . BASE_URL ."/verificacaoCodigo");
        exit();
    }

    public function VerificacaoCodigo()
    {
        $this->MostrarView("verificacaoCodigo");
    }

    public function VerificarCodigo()
    {
        $email = $_SESSION['emailRecuperacao'];
        $dadosCodigo = (new Usuario())->RetornarCodigoRecuperacao($email);
        
        if (strtotime($dadosCodigo['dtExpiracao']) < time())
        {
            header("Location: " . BASE_URL .  "/verificacaoCodigo?sucesso=0&msg=Código Expirado.");
            exit();     
        }
        
        if($_POST['codigo'] != $dadosCodigo['codigo'])
        {
            header("Location: " . BASE_URL .  "/verificacaoCodigo?sucesso=0&msg=Código Inválido.");
            exit();
        }
            
        $_SESSION['codigoRecuperacaoValidado'] = true;
        header("Location: " . BASE_URL .  "/novaSenha");
        exit();
    }

    public function NovaSenha()
    {
        if (!isset($_SESSION['codigoRecuperacaoValidado']) ||
            $_SESSION['codigoRecuperacaoValidado'] !== true)
        {
            header("Location: " . BASE_URL . "/esqueciMinhaSenha?teste");
            exit();
        }

        $this->MostrarView("novaSenha");
    }

    public function AlterarSenha()
    {
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $retorno = (new Usuario())->AlterarSenha($_SESSION['emailRecuperacao'], $senha);

        header("Location: " . BASE_URL . "/novaSenha?sucesso=" . $retorno['sucesso'] . "&msg=" . $retorno['mensagem']);
        exit();
    }
}

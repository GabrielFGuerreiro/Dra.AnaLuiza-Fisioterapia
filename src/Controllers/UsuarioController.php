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
        unset($_SESSION['emailCadastro']);
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

        if($usuario->VerificaCampoUnicoJaExiste($email, "email"))
        {
            header("Location: " . BASE_URL . "/cadastro?msgErro=E-mail já Cadastrado.");
            exit();
        }

        if($usuario->VerificaCampoUnicoJaExiste($cpf, "cpf"))
        {
            header("Location: " . BASE_URL . "/cadastro?msgErro=CPF já Cadastrado.");
            exit();
        }

        $sucesso = $usuario->CadastrarUsuario($nome, $cpf, $dtNasc, $email, $cel, $senha);
        if($sucesso)
        {
            $_SESSION['emailCadastro'] = $email;
            header("Location: " . BASE_URL . "/envioEmailVerificacao", true, 303);
            exit();
        }
        else
        {
            header("Location: " . BASE_URL . "/cadastro?msgErro=Erro ao Realizar o Cadastro.", true, 303); //303 = Após o POST, redireciona para GET, evitando o reenvio do formulário ao recarregar.
            exit();
        }
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
        $retorno = $usuario->CadastrarPreConsulta($_SESSION['idUsuario'], $dtPreferencia, $horarioInicial, $horarioFinal, $observacao);

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

        if($dadosUsuario !== null)
        {
            if(!$dadosUsuario['emailVerificado'])
            {
                $_SESSION['emailCadastro'] = $emailForm;
                header("Location: " . BASE_URL . "/envioEmailVerificacao?sucesso=0&msg=E-mail Não Verificado.", true, 303);
                exit();
            }
            else if(password_verify($senhaForm, $dadosUsuario["senha"]))
            {
                $_SESSION['email'] = $emailForm;
                $_SESSION['nome'] = $dadosUsuario['nmUsuario'];
                $_SESSION['isAdmin'] = $dadosUsuario['isAdmin'];
                $_SESSION['idUsuario'] = $dadosUsuario['idUsuario'];
                
                header("Location: " . BASE_URL . "/", true, 303);
                exit();                
            }
            else
            {
                header("Location: " . BASE_URL . "/login?msgLogin=" . urlencode("E-mail ou Senha Inválidos."), true, 303);
                exit();    
            }
        }
        else
        {
            header("Location: " . BASE_URL . "/login?msgLogin=" . urlencode("Erro ao Realizar o Login."), true, 303);
            exit();  
        }       
    }

    public function EnvioEmailVerificacao()
    {
        if (isset($_SESSION['email'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }

        $this->MostrarView("envioEmailVerificacao");
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
        $email = $_POST['email'] ?? $_SESSION['emailCadastro'];
        $_SESSION['emailVerificado'] = $email;

        $usuario = new Usuario();
        if (!$usuario->VerificaCampoUnicoJaExiste($email, "email"))
        {
            header(
                "Location: " . BASE_URL .
                "/envioEmailVerificacao?sucesso=0&msg=" .
                urlencode("E-mail Não Cadastrado.")
            );
            exit();
        }

        $codigo = random_int(100000, 999999);
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

            $mail->Subject = "Validação de E-mail";
            $mail->Body = "Seu código de verificação é: " . $codigo;
            $mail->CharSet = 'UTF-8';
            
            $mail->send();
        }
        catch (\Throwable $th)
        {
            header(
                "Location: " . BASE_URL .
                "/envioEmailVerificacao?sucesso=0&msg=" .
                urlencode("Erro ao Enviar o E-mail. Favor entrar em contato.")
            );
            exit();
        }

        $retorno = $usuario->SalvarCodigoVerificacao($codigo, $email);
        if (!$retorno['sucesso'])
        {
            header(
                "Location: " . BASE_URL .
                "/envioEmailVerificacao?sucesso=0&msg=" .
                urlencode($retorno['mensagem'])
            );
            exit();
        }

        header("Location: " . BASE_URL ."/verificacaoCodigo");
        exit();
    }

    public function VerificacaoCodigo()
    {
        if (isset($_SESSION['email'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }

        if (empty($_SESSION['emailVerificado'])) {
            header("Location: " . BASE_URL . "/envioEmailVerificacao");
            exit();
        }

        $this->MostrarView("verificacaoCodigo");
    }

    public function VerificarCodigo()
    {
        if (isset($_SESSION['email'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }

        if (empty($_SESSION['emailVerificado'])) {
            header("Location: " . BASE_URL . "/envioEmailVerificacao");
            exit();
        }

        $usuario = new Usuario();
        $email = $_SESSION['emailVerificado'];
        $dadosCodigo = $usuario->RetornarCodigoRecuperacao($email);
        
        if (strtotime($dadosCodigo['dtExpiracao']) < time())
        {
            header("Location: " . BASE_URL .  "/verificacaoCodigo?msgErro=Código Expirado.");
            exit();     
        }
        
        if($_POST['codigo'] != $dadosCodigo['codigo'])
        {
            header("Location: " . BASE_URL .  "/verificacaoCodigo?msgErro=Código Inválido.");
            exit();
        }
        
        if (isset($_SESSION['emailCadastro'])) {
            $usuario->ValidarEmailUsuario($email);

            unset(
                $_SESSION['emailVerificado'],
                $_SESSION['emailCadastro'],
                $_SESSION['codigoVerificacaoValidado']
            );

            header("Location: " . BASE_URL . "/login?cadastroSucesso=1");
            exit();
        }

        $_SESSION['codigoVerificacaoValidado'] = true;

        header("Location: " . BASE_URL . "/novaSenha");
        exit();
    }

    public function NovaSenha()
    {
        if (isset($_SESSION['email'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }

        if (!isset($_SESSION['codigoVerificacaoValidado']) ||
            $_SESSION['codigoVerificacaoValidado'] !== true ||
            empty($_SESSION['emailVerificado']))
        {
            header("Location: " . BASE_URL . "/envioEmailVerificacao");
            exit();
        }

        $this->MostrarView("novaSenha");
    }

    public function AlterarSenha()
    {
        if (isset($_SESSION['email'])) {
            header("Location: " . BASE_URL . "/");
            exit();
        }

        if (
            empty($_SESSION['emailVerificado']) ||
            ($_SESSION['codigoVerificacaoValidado'] ?? false) !== true
        ) {
            header("Location: " . BASE_URL . "/envioEmailVerificacao");
            exit();
        }

        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

        $retorno = (new Usuario())->AlterarSenha($_SESSION['emailVerificado'], $senha);

        unset($_SESSION['codigoVerificacaoValidado']);
        unset($_SESSION['emailVerificado']);

        header("Location: " . BASE_URL . "/login?sucesso=" . $retorno['sucesso'] . "&msgAlteracaoSenha=" . $retorno['mensagem']);
        exit();
    }

    public function Documentos()
    {
        $usuario = new Usuario();
        $documentos = $usuario->RetornarDocumentosPaciente($_SESSION['idUsuario'], '', null);
        $this->MostrarView("documentos", ['documentos' => $documentos]);
    }
}

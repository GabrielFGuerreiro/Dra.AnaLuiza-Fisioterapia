<?php
namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Database;
use DraAnaLuiza\Models\Adm;

class AdmController extends GeralController
{
    public function __construct()
    {
        $this->VerificarEhAdm();
    }

    public function Agendamentos()
    {
        $this->MostrarView("agendamentos");
    }

    public function ListarAgendamentosJson()
    {
        $adm = new Adm();
        $agendamentos = $adm->ListarAgendamentos() ?? [];

        header('Content-Type: application/json');
        echo json_encode($agendamentos);
        exit();
    }

    public function ObterObservacaoAgendamento()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $observacao = $id ? (new Adm())->ObterObservacaoAgendamento($id) : null;
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['observacao' => $observacao]);
        exit();
    }

    public function GerenciarDepoimentos()
    {
        $adm = new Adm();
        $this->MostrarView("gerenciarDepoimentos", [
            'depoimentos' => $adm->ListarDepoimentos(null)
        ]);
    }

    public function CadastrarDepoimento()
    {
        $adm = new Adm();
        $retorno = $adm->CadastrarDepoimento($_POST['opiniao'] ?? '', $_POST['nomePaciente'] ?? '', $_FILES['arqDepoimento'] ?? []);

        header("Location: " . BASE_URL . "/gerenciarDepoimentos?sucesso=" . (int) $retorno['sucesso'] . "&msg=" . urlencode($retorno['msg']), true, 303);
        exit();
    }

    public function EditarDepoimento()
    {
        $adm = new Adm();
        $id = filter_input(INPUT_POST, 'idDepoimento', FILTER_VALIDATE_INT);
        $opiniao = trim($_POST['opiniao'] ?? '');
        $nomePaciente = trim($_POST['nomePaciente'] ?? '');
        $sucesso = $id && $nomePaciente !== '' && $opiniao !== '' && $adm->EditarDepoimento($id, $opiniao, $nomePaciente);
        $msg = $sucesso ? 'Depoimento Atualizado com Sucesso!' : 'Informe o Nome e o Relato do Paciente.';
        header("Location: " . BASE_URL . "/gerenciarDepoimentos?sucesso=" . (int) $sucesso . "&msg=" . urlencode($msg), true, 303);
        exit();
    }

    public function AlternarDepoimento()
    {
        $adm = new Adm();
        $id = filter_input(INPUT_POST, 'idDepoimento', FILTER_VALIDATE_INT);
        $sucesso = $id && $adm->AlternarDepoimento($id);
        $msg = $sucesso ? 'Status do Depoimento Atualizado.' : 'Não foi Possível Alterar o Status.';
        header("Location: " . BASE_URL . "/gerenciarDepoimentos?sucesso=" . (int) $sucesso . "&msg=" . urlencode($msg), true, 303);
        exit();
    }

    public function ExcluirDepoimento()
    {
        $sucesso = (new Adm())->ExcluirDepoimento($_POST['idDepoimento']);
        $msg = $sucesso ? 'Depoimento Excluído com Sucesso!' : 'Não foi Possível Excluir o Depoimento.';
        header("Location: " . BASE_URL . "/gerenciarDepoimentos?sucesso=" . (int) $sucesso . "&msg=" . urlencode($msg), true, 303);
    }

    public function PreConsultasPendentes()
    {
        $adm = new Adm();
        $pendentes = $adm->ListarPreConsultasPendentes() ?? [];

        $whatsappUrl = $_SESSION['whatsappUrl'] ?? null;
        unset($_SESSION['whatsappUrl']);
        $this->MostrarView("preConsultasPendentes", ['pendentes' => $pendentes, 'whatsappUrl' => $whatsappUrl]);
    }

    public function ConfirmarConsulta()
    {
        $adm = new Adm();
        $retorno = $adm->ConfirmarConsulta(filter_input(INPUT_POST, 'idPreConsulta', FILTER_VALIDATE_INT));

        $this->RedirecionarPreConsultasPendentes($retorno);
    }

    public function ProporHorario()
    {
        $adm = new Adm();
        $retorno = $adm->ProporHorario(
            filter_input(INPUT_POST, 'idPreConsulta', FILTER_VALIDATE_INT),
            $_POST['dtConsulta'] ?? '',
            $_POST['horarioInicial'] ?? '',
            $_POST['mensagem'] ?? ''
        );

        $this->RedirecionarPreConsultasPendentes($retorno);
    }

    public function IndisponibilizarConsulta()
    {
        $adm = new Adm();
        $retorno = $adm->IndisponibilizarConsulta(
            filter_input(INPUT_POST, 'idPreConsulta', FILTER_VALIDATE_INT),
            $_POST['mensagem'] ?? ''
        );

        $this->RedirecionarPreConsultasPendentes($retorno);
    }

    private function RedirecionarPreConsultasPendentes(array $retorno): void
    {
        if (!empty($retorno['whatsappUrl'])) $_SESSION['whatsappUrl'] = $retorno['whatsappUrl'];
        header(
            "Location: " . BASE_URL . "/preConsultasPendentes?sucesso=" . (int) $retorno['sucesso'] . "&msg=" . urlencode($retorno['mensagem']),
            true,
            303
        );
        exit();
    }
}

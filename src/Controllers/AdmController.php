<?php
namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Database;
use DraAnaLuiza\Models\Adm;

class AdmController extends GeralController
{
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

        header("Location: " . BASE_URL . "/gerenciarDepoimentos?retorno=" . (int) $retorno['sucesso'] . "&msg=" . urlencode($retorno['msg']), true, 303);
        exit();
    }
    public function ExcluirDepoimento()
    {
        $retorno = (new Adm())->ExcluirDepoimento($_POST['idDepoimento']);        
    }

    public function PreConsultasPendentes()
    {
        $adm = new Adm();
        $pendentes = $adm->ListarPreConsultasPendentes() ?? [];

        $this->MostrarView("preConsultasPendentes", ['pendentes' => $pendentes]);
    }

    public function ConfirmarConsulta()
    {
        $adm = new Adm();
        $retorno = $adm->ConfirmarConsulta(
            $_POST['idPreConsulta'],
            $_POST['dtConsulta'],
            $_POST['horarioInicial'],
            $_POST['horarioFinal']
        );

        header(
            "Location: " . BASE_URL . "/preConsultasPendentes?sucesso={$retorno['sucesso']}&msg=" . urlencode($retorno['mensagem']),
            true,
            303
        );
        exit();
    }
}
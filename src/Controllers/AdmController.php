<?php
namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Database;
use DraAnaLuiza\Models\Adm;

class AdmController
{
    protected function MostrarView(string $view)
    {
        $view = RAIZ . "/Views/" . $view . ".php";
        include RAIZ . "/Views/layout.php";
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

    public function GerenciarDepoimentos()
    {
        $this->MostrarView("gerenciarDepoimentos");
    }

    public function CadastrarDepoimento()
    {
        $adm = new Adm();
        $retorno = $adm->CadastrarDepoimento($_POST['opiniao'], $_FILES['arqDepoimento']);

        header("Location: " . BASE_URL . "/gerenciarDepoimentos?retorno={$retorno["sucesso"]}&msg={$retorno["msg"]}");
    }
}
<?php
namespace DraAnaLuiza\Controllers;
use DraAnaLuiza\Models\Database;
use DraAnaLuiza\Models\Adm;

class AdmController
{
    public function Agendamentos()
    {
        require_once RAIZ . "/Views/agendamentos.php";
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
        require_once RAIZ . "/Views/gerenciarDepoimentos.php";
    }

    public function CadastrarDepoimento()
    {
        $adm = new Adm();
        $retorno = $adm->CadastrarDepoimento($_POST['opiniao'], $_FILES['arqDepoimento']);

        header("Location: " . BASE_URL . "/gerenciarDepoimentos?retorno={$retorno["sucesso"]}&msg={$retorno["msg"]}");
    }
}
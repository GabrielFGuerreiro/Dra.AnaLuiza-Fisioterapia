<?php
namespace DraAnaLuiza\Controllers;

class GeralController
{
    protected function MostrarView(string $view, $dados = [])
    {
        extract($dados);

        $view = RAIZ . "/Views/" . $view . ".php";
        include RAIZ . "/Views/layout.php";
    }

    public function notFound() {
        $this->MostrarView('404');
    }
    
    public function VerificarEhAdm()
    {
        if($_SESSION["isAdmin"] == false)
        {
            header("Location: " . BASE_URL . "/");
            exit();
        }
    }
}
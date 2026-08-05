<?php
namespace DraAnaLuiza\Controllers;

class GeralController
{
    protected function MostrarView(string $view)
    {
        $view = RAIZ . "/Views/" . $view . ".php";
        include RAIZ . "/Views/layout.php";
    }
}
<?php
namespace DraAnaLuiza\Controllers;

class HomeController
{
    public function Home()
    {
        $view = RAIZ."/Views/home.php";
        include RAIZ."/Views/layout.php";
    }
}
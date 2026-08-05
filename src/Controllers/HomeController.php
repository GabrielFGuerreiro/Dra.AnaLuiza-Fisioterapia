<?php
namespace DraAnaLuiza\Controllers;

class HomeController extends GeralController
{
    public function Home()
    {
        $this->MostrarView("home");
    }
}
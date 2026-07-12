<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once __DIR__ . "/vendor/autoload.php";
define('BASE_URL', '/Dra.AnaLuiza-Fisioterapia');
define('RAIZ', __DIR__);

use DraAnaLuiza\Core\Router;

//Executa o arquivo routes.php, guardando as rotas.
$routes = require_once __DIR__ . '/Config/routes.php';

$router = new Router($routes); //Envia as rotas para o Router

$router->run();
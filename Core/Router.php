<?php
namespace DraAnaLuiza\Core;

Class Router
{
    private array $rotas;

    public function __construct(array $rotas)
    {
        $this->rotas = $rotas;
    }

    public function run(): void
    {
        //$_SERVER é um array criado automaticamente pelo PHP com informações da requisição.

        //Qual foi o método HTTP da requisição (GET, POST...)
        $requisicao = $_SERVER['REQUEST_METHOD'];

        //URL sem parâmetros. Exemplo: http://localhost/salvar?id=10 com "parse_url" vira um array, separando o "path"(/salvar) e a "query"(id=10)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace('/Dra.AnaLuiza-Fisioterapia', '', $uri);

        //Busca, no array de rotas, a rota correspondente ao método da requisição (GET/POST) e à URL acessada.
        //Exemplo: $this->rotas['POST']['/login'] => "UsuarioController@logar"
        $rota = $this->rotas[$requisicao][$uri];

        //Verifica se a rota existe
        if (!isset($rota))
        {
            http_response_code(404);
            echo "Página não encontrada.";
            return;
        }
        
        $partes = explode('@', $rota);
        $controller = $partes[0];
        $funcao = $partes[1];

        $controller = "DraAnaLuiza\\Controllers\\$controller";
        $obj = new $controller();
        $obj->$funcao(); //Chama o método
    }
}
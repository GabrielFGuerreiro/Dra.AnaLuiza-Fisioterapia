<?php

return [

    'GET' => [
        '/' => 'HomeController@Home',
        '/login' => 'UsuarioController@Login',
        '/cadastro' => 'UsuarioController@Cadastro',
        '/logout' => 'UsuarioController@Logout'
    ],

    'POST' => [
        '/cadastrar' => 'UsuarioController@Cadastrar',
        '/logar' => 'UsuarioController@Logar'
    ]

];
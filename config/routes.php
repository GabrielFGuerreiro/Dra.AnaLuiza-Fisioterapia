<?php

return [

    'GET' => [
        '/' => 'HomeController@Home',
        '/login' => 'UsuarioController@Login',
        '/cadastro' => 'UsuarioController@Cadastro',
        '/logout' => 'UsuarioController@Logout',
        '/agendamentos' => 'AdmController@Agendamentos',
        '/listarAgendamentosJson' => 'AdmController@ListarAgendamentosJson'
    ],

    'POST' => [
        '/cadastrar' => 'UsuarioController@Cadastrar',
        '/logar' => 'UsuarioController@Logar'
    ]

];
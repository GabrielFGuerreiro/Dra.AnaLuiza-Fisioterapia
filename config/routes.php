<?php

return [

    'GET' => [
        '/' => 'HomeController@Home',
        '/login' => 'UsuarioController@Login',
        '/cadastro' => 'UsuarioController@Cadastro',
        '/logout' => 'UsuarioController@Logout',
        '/preconsulta' => 'UsuarioController@PreConsulta',
        '/agendamentos' => 'AdmController@Agendamentos',
        '/listarAgendamentosJson' => 'AdmController@ListarAgendamentosJson',
        '/gerenciarDepoimentos' => 'AdmController@GerenciarDepoimentos',
        '/esqueciMinhaSenha' => 'UsuarioController@EsqueceuSenha'
    ],

    'POST' => [
        '/cadastrar' => 'UsuarioController@Cadastrar',
        '/logar' => 'UsuarioController@Logar',
        '/cadastrarDepoimento' => 'AdmController@CadastrarDepoimento',
        '/cadastrarConsulta' => 'UsuarioController@PreConsulta',
        '/enviarEmailCodigo' => 'UsuarioController@EnviarEmailCodigo'
    ]

];
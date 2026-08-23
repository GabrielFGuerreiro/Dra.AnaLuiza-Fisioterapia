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
        '/preConsultasPendentes' => 'AdmController@PreConsultasPendentes',
        '/esqueciMinhaSenha' => 'UsuarioController@EsqueceuSenha',
        '/verificacaoCodigo' => 'UsuarioController@VerificacaoCodigo',
        '/novaSenha' => 'UsuarioController@NovaSenha'
    ],

    'POST' => [
        '/cadastrar' => 'UsuarioController@Cadastrar',
        '/logar' => 'UsuarioController@Logar',
        '/cadastrarDepoimento' => 'AdmController@CadastrarDepoimento',
        '/editarDepoimento' => 'AdmController@EditarDepoimento',
        '/alternarDepoimento' => 'AdmController@AlternarDepoimento',
        '/excluirDepoimento' => 'AdmController@ExcluirDepoimento',
        '/cadastrarConsulta' => 'UsuarioController@CadastrarConsulta',
        '/enviarEmailCodigo' => 'UsuarioController@EnviarEmailCodigo',
        '/verificarCodigo' => 'UsuarioController@VerificarCodigo',
        '/alterarSenha' => 'UsuarioController@AlterarSenha',
        '/confirmarConsulta' => 'AdmController@ConfirmarConsulta'
    ]

];

<?php
namespace DraAnaLuiza\Controllers;

class HomeController extends GeralController
{
    public function Home()
    {
        $servicos = [
            [
                "titulo" => "Reabilitação Ortopédica",
                "descricao" => "Tratamento personalizado para recuperação de lesões, dores e limitações, promovendo mais mobilidade, força e qualidade de vida."
            ],
            [
                "titulo" => "Dry Needling",
                "descricao" => "Técnica que utiliza agulhas finas para auxiliar no alívio de dores e tensões musculares, contribuindo para uma melhor função e mobilidade."
            ],
            [
                "titulo" => "Fisioterapia Funcional",
                "descricao" => "Exercícios e técnicas direcionados para melhorar força, equilíbrio, mobilidade e desempenho nas atividades do dia a dia."
            ],
            [
                "titulo" => "Atendimento Domiciliar",
                "descricao" => "Fisioterapia no conforto da sua casa, com um atendimento individualizado de acordo com suas necessidades e objetivos."
            ],
            [
                "titulo" => "Fisioterapia Pré-Cirúrgica",
                "descricao" => "Preparação do corpo antes de procedimentos cirúrgicos, buscando melhorar a condição física e contribuir para uma recuperação mais tranquila e eficiente."
            ],
            [
                "titulo" => "Recovery",
                "descricao" => "Estratégias de recuperação física voltadas para reduzir desconfortos, aliviar a tensão muscular e preparar o corpo para retornar às atividades com mais segurança."
            ]
        ];

        $this->MostrarView("home", [
            "servicos" => $servicos
        ]);
    }
}
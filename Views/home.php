<?php
    $servicos = [
        [
            "titulo" => "Foo",
            "descricao" => "Bar."
        ],
        [
            "titulo" => "Lorem",
            "descricao" => "Ipsum."
        ],
        [
            "titulo" => "Hotel?",
            "descricao" => "Trivago."
        ],
        [
            "titulo" => "Sem",
            "descricao" => "Ideia."
        ]
    ];
?>

<section class="py-5">
    <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 450px;">

        <img src="<?= BASE_URL ?>/Images/Fisioterapia.png"
            class="position-absolute top-50 start-50 translate-middle opacity-75"
            style="max-width: 650px; z-index: 1;">

        <div class="text-center position-relative" style="z-index: 2; max-width: 700px;">
            <h1 class="display-4 fw-bold text-success">
                Recupere sua qualidade de vida
            </h1>

            <p class="lead">
                Atendimento fisioterapêutico especializado para prevenção,<br>
                tratamento e reabilitação.
            </p>

            <a href="<?= BASE_URL ?>/preConsulta" class="btn btn-success btn-lg">
                Agendar consulta
            </a>
        </div>

    </div>
</section>

<section class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold">O que é fisioterapia?</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <p class="text-center fs-5">
                A fisioterapia é a área da saúde responsável pela prevenção e tratamento de alterações do movimento,
                promovendo mais independência, mobilidade e qualidade de vida aos pacientes.
            </p>

        </div>
    </div>

</section>

<section class="container py-5">

    <h2 class="text-center fw-bold mb-5">
        Serviços oferecidos
    </h2>

    <div class="row g-4">

        <?php foreach ($servicos as $servico): ?>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5><?= $servico["titulo"] ?></h5>
                        <p><?= $servico["descricao"] ?></p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</section>

<?php require  "footer.php"; ?>
<?php

use DraAnaLuiza\Models\Database;
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
        ],
        [
            "titulo" => "Mais",
            "descricao" => "Serviços."
        ],
        [
            "titulo" => "E",
            "descricao" => "Depoimentos."
        ]

    ];

const MIDIA = [
    'mp4'  => 'video/mp4',
    'mkv'  => 'video/x-matroska',
    'avi'  => 'video/x-msvideo',
    'mov'  => 'video/quicktime',
    'webm' => 'video/webm',
    'png'  => 'image/png',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'gif'  => 'image/gif',
    'webp' => 'image/webp',
];
    
    $db = new Database();

    $db->getConnection();
    $depoimento = $db->getDepoimento();
?>

<section class="py-5">
    <div class="position-relative d-flex justify-content-center align-items-center" style="min-height: 40vh;">

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

            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($servico["titulo"]) ?></h5>
                        <p><?= htmlspecialchars($servico["descricao"]) ?></p>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>

</section>

<section class="container py-5"> <!-- Depoimentos -->
    <!--
        fazer algum jeito de traduzir automaticamente que tipo de conteudo será usado no depoimento,
        tipo um if ou switch que alterna entre <img> e <video>
            -rodrigo
    -->

    <h2 class="text-center fw-bold mb-5">
        Depoimentos de pacientes
    </h2>

    <div class="row g-4">
        <?php
        $carrossel = [];
        foreach ($depoimento as $d) {
            if (!empty($d['caminhoArquivo'])) {
                $carrossel[] = [
                    'src'  => rtrim(BASE_URL, '/') . '/arquivosDepoimentos/' . basename($d['caminhoArquivo']),
                    'desc' => trim($d['dsDepoimento'] ?? ''),
                ];
            }
        }
        ?>
        <?php if (!empty($carrossel)) { ?>
        <div class="col-12">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                <!-- Indicators/dots -->
                <div class="carousel-indicators">
                    <?php foreach ($carrossel as $index => $item) { ?>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $index ?>"
                            <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>></button>
                    <?php } ?>
                </div>

                <!-- The slideshow/carousel -->
                <div class="carousel-inner rounded shadow-sm" style="height: 380px; background-color: white;">
                    <?php foreach ($carrossel as $index => $item) {
                        $tipo = strtolower(pathinfo($item['src'], PATHINFO_EXTENSION));
                        $mime = MIDIA[$tipo] ?? null;
                        $isVideo = $mime && str_starts_with($mime, 'video/');
                    ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" style="height: 380px;">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 px-4 text-center">
                                <?php if ($isVideo) { ?>
                                    <video src="<?= $item['src'] ?>" controls class="mw-100" style="max-height: 220px; object-fit: contain;"></video>
                                <?php } else { ?>
                                    <img src="<?= $item['src'] ?>" alt="Depoimento de paciente" class="mw-100" style="max-height: 220px; object-fit: contain;">
                                <?php } ?>

                                <?php if ($item['desc'] !== '') { ?>
                                    <p class="dsDepoimento mt-3 mb-0 fst-italic">
                                        "<?= htmlspecialchars($item['desc']) ?>"
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
 
                <!-- Left and right controls/icons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                </button>
            </div>
        </div>
        <?php } ?>
 
    </div>
</section>

<?php require  "footer.php"; ?>
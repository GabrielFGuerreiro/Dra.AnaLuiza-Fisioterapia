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
        ]
    ];

    $video = ["mp4", "mkv", "avi", "mov", "webm"];
    $imagem = ["png", "jpg", "jpeg", "gif", "webp"];
    
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

<section class="container py-5"> <!-- Depoimentos -->
    <!--
        fazer algum jeito de traduzir automaticamente que tipo de conteudo será usado no depoimento,
        tipo um if ou switch que alterna entre <img> e <video>
            -rodrigo
    } -->

    <h2 class="text-center fw-bold mb-5">
        Depoimentos de pacientes
    </h2>

    <div class="row g-4">

        <?php foreach ($depoimento as $d) { ?>

        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <p>
                        <?= htmlspecialchars($d['dsDepoimento'] ?? '') ?>
                    </p>
                    <?php if (!empty($d['nome'])) { ?>
                        <h6 class="fw-bold mb-0"><?= htmlspecialchars($d['nome']) ?></h6><br>
                    <?php } ?>

                    <?php if (!empty($d['caminhoArquivo'])) {
                        $tipo = pathinfo($d['caminhoArquivo'], PATHINFO_EXTENSION);
                        $raw = str_replace('\\', '/', $d['caminhoArquivo']);

                        $publicFolders = ['Images', 'arquivosDepoimentos', 'uploads'];
                        $rel = $raw;
                        foreach ($publicFolders as $f) {
                            $p = stripos($raw, '/' . $f . '/');
                            if ($p !== false) { $rel = substr($raw, $p + 1); break; }
                            $p2 = stripos($raw, $f . '/');
                            if ($p2 !== false) { $rel = substr($raw, $p2); break; }
                        }

                        $url = rtrim(BASE_URL, '/') . '/' . ltrim($rel, '/');

                        if (in_array($tipo, $video)) { ?>

                            <video class="img-fluid mb-2 object-fit-scale border rounded" controls>
                                <source src="<?= $url ?>" type="video/<?= $tipo ?>">
                                <span style="color: crimson">Seu navegador não suporta o elemento de vídeo.</span>
                            </video>

                        <?php } elseif (in_array($tipo, $imagem)) { ?>

                            <img src="<?= $url ?>" class="img-fluid mb-2 object-fit-scale border rounded" alt="Depoimento de paciente">

                        <?php }
                    } ?>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>
</section>

<?php require  "footer.php"; ?>



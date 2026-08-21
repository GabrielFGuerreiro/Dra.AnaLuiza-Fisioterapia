<?php

use DraAnaLuiza\Models\Database;

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

<div class="home-page">
<section class="home-hero py-5">
    <div class="home-hero-inner position-relative d-flex justify-content-center align-items-center">

        <img src="<?= BASE_URL ?>/Images/Fisioterapia.png"
            class="home-hero-watermark position-absolute top-50 start-50 translate-middle opacity-75"
            alt="">

        <div class="home-hero-content text-center position-relative">
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

<section class="home-section container py-5">
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

<!-- [SERVIÇOS] -->
<section class="home-section services-section container py-5">
    <div class="services-heading text-center">
        <span class="section-kicker">Cuidado personalizado</span>
        <h2 class="fw-bold mb-2">
        Serviços oferecidos
        </h2>
        <p>Encontre o cuidado ideal para recuperar seu movimento e bem-estar.</p>
    </div>

    <div class="services-grid row g-4">
        <?php foreach ($servicos as $index => $servico): ?>
            <div class="col-md-6 col-lg-4">
                <article class="service-card h-100">
                    <div class="service-card-body">
                        <span class="service-number"><?= str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        <h5><?= htmlspecialchars($servico["titulo"]) ?></h5>
                        <p><?= htmlspecialchars($servico["descricao"]) ?></p>
                    </div>
                </article>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- [DEPOIMENTOS] -->
<section class="home-section testimonials-section container py-5"> 
    <div class="testimonials-heading text-center">
        <span class="section-kicker">Experiências reais</span>
        <h2 class="fw-bold mb-2">Depoimentos de pacientes</h2>
        <p>Veja como o cuidado personalizado pode transformar a rotina.</p>
    </div>

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
            <div id="demo" class="carousel slide testimonials-carousel" data-bs-interval="false" data-bs-touch="false">

                <!-- Botões embaixo -->
                <div class="carousel-indicators">
                    <?php foreach ($carrossel as $index => $item) { ?>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $index ?>"
                            <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>></button>
                    <?php } ?>
                </div>

                <!-- Carrossel -->
                <div class="carousel-inner rounded shadow-sm testimonials-inner" style="height: 380px; background-color: white;">
                    <?php foreach ($carrossel as $index => $item) {
                        $tipo = strtolower(pathinfo($item['src'], PATHINFO_EXTENSION));
                        $mime = MIDIA[$tipo] ?? null;
                        $isVideo = $mime && str_starts_with($mime, 'video/');
                    ?>
                        <div class="carousel-item testimonials-item <?= $index === 0 ? 'active' : '' ?>" style="height: 380px;">
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
 
                <!-- Botões de próximo/anterior -->
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const testimonialsCarousel = document.getElementById('demo');
        if (!testimonialsCarousel) return;

        testimonialsCarousel.addEventListener('slide.bs.carousel', function () {
            testimonialsCarousel.querySelectorAll('video').forEach(function (video) {
                video.pause();
            });
        });
    });
</script>

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
    <div class="home-hero-inner position-relative">
        <div class="home-hero-content">
            <span class="hero-kicker">Cuidado que transforma</span>
            <h1>Recupere o movimento.<br><strong>Viva melhor.</strong></h1>
            <p>Atendimento fisioterapêutico especializado para aliviar dores, recuperar sua autonomia e cuidar da sua qualidade de vida.</p>
            <div class="hero-actions">
                <a href="<?= BASE_URL ?>/preConsulta" class="btn btn-success btn-lg">Agendar consulta</a>
                <span class="hero-note">Cuidado individualizado para você</span>
            </div>
        </div>
        <div class="home-hero-visual" aria-hidden="true">
            <div class="hero-visual-ring"></div>
            <img src="<?= BASE_URL ?>/Images/Fisioterapia.png" class="home-hero-watermark" alt="">
        </div>

    </div>
</section>

<section class="home-section about-section container py-5">
    <div class="about-heading text-center">
        <span class="section-kicker">Movimento e bem-estar</span>
        <h2 class="fw-bold">O que é fisioterapia?</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <p class="about-copy text-center">
                A fisioterapia ajuda a prevenir e tratar alterações do movimento, contribuindo para aliviar dores,
                recuperar a funcionalidade e conquistar mais autonomia, mobilidade e qualidade de vida.
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
        <div class="col-12 service-card mx-auto" style="width: 70%;">
            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                <!-- contador de itens -->
                <div class="carousel-indicators">
                    <?php foreach ($carrossel as $index => $item) { ?>
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $index ?>"
                            <?= $index === 0 ? 'class="active" aria-current="true"' : '' ?>></button>
                    <?php } ?>
                </div>

                <!-- o carrosel em si -->
                <div class="carousel-inner rounded " style="height: 380px;">
                    <?php foreach ($carrossel as $index => $item) {
                        $tipo = strtolower(pathinfo($item['src'], PATHINFO_EXTENSION));
                        $mime = MIDIA[$tipo] ?? null;
                        $isVideo = $mime && str_starts_with($mime, 'video/');
                    ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?> " style="height: 380px;">
                            <div class="d-flex flex-column justify-content-center align-items-center h-100 px-4 text-center">
                                <?php if ($isVideo) { ?>
                                    <video src="<?= $item['src'] ?>" controls class="mw-100" style="max-height: 220px; object-fit: contain;"></video>
                                <?php } else { ?>
                                    <img src="<?= $item['src'] ?>" alt="Depoimento de paciente" class="mw-100" style="max-height: 220px; object-fit: contain;">
                                <?php } ?>

                                <?php if ($item['desc'] !== '') { ?>
                                    <p class="depoimento-legenda mt-3 mb-0 fst-italic">
                                        "<?= htmlspecialchars($item['desc']) ?>"
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Setinhas de avancar e voltar -->
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

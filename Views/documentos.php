<?php
$documentos = $documentos ?? [];
$tiposDocumento = [
    'pdf' => ['label' => 'PDF', 'icon' => 'fa-file-pdf', 'class' => 'is-pdf'],
    'doc' => ['label' => 'Word', 'icon' => 'fa-file-word', 'class' => 'is-doc'],
    'docx' => ['label' => 'Word', 'icon' => 'fa-file-word', 'class' => 'is-doc'],
    'jpg' => ['label' => 'Imagem', 'icon' => 'fa-file-image', 'class' => 'is-image'],
    'jpeg' => ['label' => 'Imagem', 'icon' => 'fa-file-image', 'class' => 'is-image'],
    'png' => ['label' => 'Imagem', 'icon' => 'fa-file-image', 'class' => 'is-image'],
];
?>

<div class="documents-page">
    <div class="documents-shell">
        <header class="documents-heading">
            <span class="section-kicker">Área do paciente</span>
            <h1>Meus documentos</h1>
            <p>Acesse com segurança os arquivos enviados pela Dra. Ana Luiza para acompanhar o seu tratamento.</p>
        </header>

        <div class="documents-note" role="status">
            <i class="fa-solid fa-shield-heart"></i>
            <p>Estes documentos são pessoais e ficam disponíveis somente para você.</p>
        </div>

        <?php if (empty($documentos)): ?>
            <section class="documents-empty">
                <i class="fa-regular fa-folder-open"></i>
                <h2 id="documents-empty-title">Nenhum documento disponível</h2>
                <p>Quando a doutora enviar um documento, ele aparecerá aqui para visualização e download.</p>
            </section>
        <?php else: ?>
            <section class="documents-grid">
                <?php foreach ($documentos as $documento):
                    $nome = $documento['nomeDocumento'];
                    $caminho = $documento['caminhoDocumento'];
                    $descricao = "TESTE";
                    $extensao = strtolower(ltrim((string) ($documento['extensao'] ?? pathinfo((string) parse_url($caminho, PHP_URL_PATH), PATHINFO_EXTENSION)), '.'));
                    $tipo = $tiposDocumento[$extensao] ?? ['label' => strtoupper($extensao ?: 'Arquivo'), 'icon' => 'fa-file-lines', 'class' => ''];
                    $dataDocumento = $documento['data'];
                    $dataFormatada = '';
                    if ($dataDocumento && ($timestamp = strtotime((string) $dataDocumento)) !== false) {
                        $dataFormatada = date('d/m/Y', $timestamp);
                    }
                    $nomeSeguro = htmlspecialchars($nome, ENT_QUOTES, 'UTF-8');
                    $caminhoSeguro = htmlspecialchars($caminho, ENT_QUOTES, 'UTF-8');
                ?>
                    <article class="document-card">
                        <div class="document-card-icon <?= htmlspecialchars($tipo['class'], ENT_QUOTES, 'UTF-8') ?>">
                            <i class="fa-regular <?= htmlspecialchars($tipo['icon'], ENT_QUOTES, 'UTF-8') ?>"></i>
                        </div>
                        <div class="document-card-content">
                            <span class="document-type"><?= htmlspecialchars($tipo['label'], ENT_QUOTES, 'UTF-8') ?></span>
                            <h2 title="<?= $nomeSeguro ?>"><?= $nomeSeguro ?></h2>
                            <?php if ($descricao !== ''): ?>
                                <p class="document-description"><?= htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>
                            <?php if ($dataFormatada !== ''): ?>
                                <p class="document-date">Enviado em <?= htmlspecialchars($dataFormatada, ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>
                            <div class="document-card-actions">
                                <a class="document-action document-action-primary" href="<?= $caminhoSeguro ?>" target="_blank" rel="noopener">
                                    <i class="fa-regular fa-eye"></i> Visualizar
                                </a>
                                <a class="document-action document-action-secondary" href="<?= $caminhoSeguro ?>" download>
                                    <i class="fa-solid fa-download"></i> Baixar
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>

        <p class="documents-privacy"><i class="fa-solid fa-lock"></i> Seus arquivos são protegidos e acessíveis apenas na sua conta.</p>
    </div>
</div>

<?php require "footer.php"; ?>

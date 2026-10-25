<?php
$documentos = $documentos ?? [];
$tiposDocumento = [
    'pdf' => ['label' => 'PDF', 'icon' => 'fa-file-pdf', 'class' => 'is-pdf'],
    'doc' => ['label' => 'Word', 'icon' => 'fa-file-word', 'class' => 'is-doc'],
    'docx' => ['label' => 'Word', 'icon' => 'fa-file-word', 'class' => 'is-doc'],
    'xls'  => ['label' => 'Excel', 'icon' => 'fa-file-excel', 'class' => 'is-excel'],
    'xlsx' => ['label' => 'Excel', 'icon' => 'fa-file-excel', 'class' => 'is-excel'],
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

        <?php if (empty($documentos)): ?>
            <section class="documents-empty">
                <i class="fa-regular fa-folder-open"></i>
                <h2 id="documents-empty-title">Nenhum documento disponível</h2>
                <p>Quando a doutora enviar um documento, ele aparecerá aqui para visualização e download.</p>
            </section>
        <?php else: ?>
            <section class="documents-grid">
                <?php foreach ($documentos as $documento):
                    $nome = $documento['nmDocumento'];
                    $caminho = BASE_URL . '/' . ltrim($documento['caminhoDocumento'], '/');
                    $extensao = strtolower(ltrim(pathinfo((string) parse_url($caminho, PHP_URL_PATH), PATHINFO_EXTENSION), '.'));
                    $tipo = $tiposDocumento[$extensao] ?? ['label' => strtoupper($extensao ?: 'Arquivo'), 'icon' => 'fa-file-lines', 'class' => ''];
                    $dataFormatada = date('d/m/Y H:m', strtotime($documento['dataEnvio']));
                ?>
                    <article class="document-card">
                        <div class="document-card-icon <?= $tipo['class'] ?>">
                            <i class="fa-regular <?= $tipo['icon'] ?>"></i>
                        </div>
                        <div class="document-card-content">
                            <span class="document-type"><?= htmlspecialchars($tipo['label'], ENT_QUOTES, 'UTF-8') ?></span>
                            <h2 title="<?= $nome ?>"><?= $nome ?></h2>
                            <p class="document-date">Recebido em <?= htmlspecialchars($dataFormatada, ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="document-card-actions">
                                <a class="document-action document-action-primary" href="<?= $caminho ?>" target="_blank" rel="noopener">
                                    <i class="fa-regular fa-eye"></i> Visualizar
                                </a>
                                <a class="document-action document-action-secondary" href="<?= $caminho ?>" download>
                                    <i class="fa-solid fa-download"></i> Baixar
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>

    </div>
</div>

<?php require "footer.php"; ?>

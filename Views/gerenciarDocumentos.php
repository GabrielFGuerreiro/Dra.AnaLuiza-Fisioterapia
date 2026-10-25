<?php
$documentos = $documentos ?? [];
$pacientes = $pacientes ?? [];
$tiposDocumento = $tiposDocumento ?? [];
?>

<div class="manage-documents-page">
    <section class="manage-documents-shell">
        <header class="manage-documents-heading">
            <span class="section-kicker">Painel administrativo</span>
            <h1>Gerenciar documentos</h1>
            <p>Envie arquivos para os pacientes e organize os documentos compartilhados pela clínica.</p>
        </header>

        <div class="manage-documents-layout">
            <section class="document-upload-card">
                <div class="manage-card-heading">
                    <span class="manage-card-icon"><i class="fa-solid fa-cloud-arrow-up"></i></span>
                    <div>
                        <h2>Enviar documento</h2>
                        <p>Disponibilize um novo arquivo para um paciente.</p>
                    </div>
                </div>
                
                <div id="msgAlerta" class="alerta-form form-alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span></span>
                </div>
                                <!-- [Fomulário Envio Documento -->
                <form action="<?= BASE_URL ?>/enviarDocumento" method="POST" enctype="multipart/form-data" class="document-upload-form" id="formEnvioDoc">
                    <div class="manage-field">
                        <label for="idPaciente">Paciente</label>
                        <select name="idPaciente" id="idPaciente">
                            <option value="">Selecione um paciente</option>
                            <?php foreach ($pacientes as $idPaciente => $nmPaciente):?>
                                <option value="<?= $idPaciente ?>"><?= $nmPaciente?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="manage-field">
                        <label for="tipoDocumento">Tipo do documento</label>
                        <select name="tipoDocumento" id="tipoDocumento">
                            <option value="">Selecione uma tag</option>
                            <?php foreach ($tiposDocumento as $idTipoDoc => $nmTipoDoc): ?>
                                <option value="<?= $idTipoDoc ?>"><?= $nmTipoDoc ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="manage-field">
                        <label for="arquivoDocumento">Arquivo</label>
                        <input type="file" name="arquivoDocumento" id="arquivoDocumento">
                        <small>PDF, Word ou imagem.</small>
                    </div>

                    <button type="submit" class="manage-primary-button"><i class="fa-solid fa-paper-plane"></i> Enviar documento</button>
                </form>     <!-- Fomulário Envio Documento] -->
            </section>

            <section class="document-list-card">
                <div class="document-list-heading">
                    <div>
                        <span class="section-kicker">Arquivos compartilhados</span>
                        <h2>Documentos enviados</h2>
                    </div>
                    <span class="document-count"><?= count($documentos) ?> <?= count($documentos) === 1 ? 'documento' : 'documentos' ?></span>
                </div>
                            <!-- [Fomulário Filtrar Documentos -->
                <form action="<?= BASE_URL ?>/gerenciarDocumentos" method="GET" class="document-filters">
                    <div class="filter-search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="busca" value="<?= htmlspecialchars((string) ($_GET['busca'] ?? ''), ENT_QUOTES, 'UTF-8') ?>" placeholder="Buscar por paciente ou documento">
                    </div>
                    <select name="tipoDoc">
                        <option value="">Todos os tipos</option>
                        <?php foreach ($tiposDocumento as $idTipoDoc => $nmTipoDoc): ?>
                            <option value="<?= $idTipoDoc ?>" <?= (($_GET['tipoDoc'] ?? '') === (string) $idTipoDoc) ? 'selected' : '' ?>> <?= $nmTipoDoc ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="filter-button"><i class="fa-solid fa-filter"></i> Filtrar</button>
                </form>     <!-- Fomulário Filtrar Documentos] -->

                <?php if (empty($documentos)): ?>
                    <div class="manage-documents-empty">
                        <i class="fa-regular fa-folder-open"></i>
                        <h3>Nenhum documento enviado</h3>
                        <p>Os arquivos compartilhados com os pacientes aparecerão nesta lista.</p>
                    </div>
                <?php else: ?>
                    <div class="managed-documents-list">
                        <?php foreach ($documentos as $documento):
                            $idDocumento = $documento['idDocumento'];
                            $nomeDocumento = $documento['nmDocumento'];
                            $idPacienteDoc = $documento['idUsuarioPaciente'];
                            $idTipoDocAtual = $documento['idTipoDocumento'];
                            $arquivo = BASE_URL . '/' . ltrim($documento['caminhoDocumento'], '/');
                            $dataFormatada = date('d/m/Y H:m', strtotime($documento['dataEnvio']));
                        ?>
                            <article class="managed-document-row">
                                <div class="managed-document-file-icon"><i class="fa-regular fa-file-lines"></i></div>
                                <div class="managed-document-info"> <!-- [Infos Documento -->
                                    <div class="managed-document-title-line">
                                        <h3><?= $nomeDocumento ?></h3>
                                        <span class="document-tag"><?= $tiposDocumento[$idTipoDocAtual] ?></span>
                                    </div>
                                    <p class="managed-document-patient"><i class="fa-regular fa-user"></i> <?= $pacientes[$idPacienteDoc] ?></p>
                                    <small>Enviado em <?= $dataFormatada ?></small>
                                </div>                               <!-- Infos Documento] -->
                                <div class="managed-document-actions">
                                    <a href="<?= $arquivo ?>" target="_blank" rel="noopener" class="document-icon-action" title="Visualizar documento"><i class="fa-regular fa-eye"></i></a>
                                    <a href="<?= $arquivo ?>" download class="document-icon-action" title="Baixar documento"><i class="fa-solid fa-download"></i></a>
                                    <details class="document-tag-menu">
                                        <summary class="document-icon-action" title="Alterar tipo"><i class="fa-solid fa-tag"></i></summary>
                                        <form action="<?= BASE_URL ?>/alterarTipoDocumento" method="POST">
                                            <input type="hidden" name="idDocumento" value="<?= (int) $idDocumento ?>">
                                            <select name="tipoDocumento" onchange="this.form.submit()">
                                                <?php foreach ($tiposDocumento as $idTipoDoc => $nmTipoDoc): ?>
                                                    <option value="<?= $idTipoDoc ?>" <?= $idTipoDocAtual === $idTipoDoc ? 'selected' : '' ?>><?= $nmTipoDoc ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>
                                    </details>
                                    <form action="<?= BASE_URL ?>/removerDocumento" method="POST" id="formRemoverDocumento">
                                        <input type="hidden" name="idDocumento" value="<?= (int) $idDocumento ?>">
                                        <button type="submit" class="document-icon-action is-danger" title="Remover documento"><i class="fa-regular fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </section>
</div>

<?php require "footer.php"; ?>


<script>

document.addEventListener("DOMContentLoaded", function () {
    const params = new URLSearchParams(window.location.search);
    const msg = params.get("msg");
    const sucesso = params.get("sucesso");
    if (msg)
    {
        Swal.fire({
            title: msg,
            icon: sucesso === "1" ? "success" : "error",
            confirmButtonText: 'Ok'
        });

        // O resultado já foi exibido; remove os dados do POST da URL.
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

document.getElementById("formEnvioDoc").addEventListener("submit", function(e)
{
    e.preventDefault();

    if(document.getElementById("idPaciente").value == "")
    {
        mostrarAlerta("Informe o Paciente.");
        return;
    }

    if(document.getElementById("tipoDocumento").value == "")
    {
        mostrarAlerta("Selecione o Tipo do Documento.");
        return;
    }
    
    if(document.getElementById("arquivoDocumento").value == "")
    {
        mostrarAlerta("É Necessário fazer o Upload do Arquivo.");
        return;
    }

    this.submit();
});

const formRemoverDocumento = document.getElementById("formRemoverDocumento");
if (formRemoverDocumento) {
    formRemoverDocumento.addEventListener("submit", function(e)
    {
        e.preventDefault();        
        Swal.fire({
            title: "Deseja Excluir o Documento?",
            icon: "warning",
            confirmButtonText: 'Sim',
            showCancelButton: true,
            cancelButtonText: 'Não'
        }).then((resultado) => {
            if(resultado.isConfirmed)
                this.submit();
        });
    });
}
</script>

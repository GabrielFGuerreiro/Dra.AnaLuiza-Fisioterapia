<header>
    <style>html {color-scheme: light;}</style>
    <link rel="stylesheet" href="styles/light.css">
    <div class="lateral">
        <div class="lateral-texto">
            <div>
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <h2>&nbsp;&nbsp;Dra. Ana &nbsp;&nbsp;Fisioterapia</h2>
                </div>
                <a class="msg" href="<?= BASE_URL ?>/">Início</a>
                <a class="msg" href="/preconsulta">Entre em Contato</a>
            </div>

            <?php if (isset($_SESSION['email'])): ?>

                <span class="user">Olá, <?= htmlspecialchars($_SESSION['nome']) ?></span>
                <?php if ($_SESSION['isAdmin']): ?>

                    <a class="msg" href="<?= BASE_URL ?>/agendamentos">Ver Agendamentos</a>
                    <a class="msg" href="/depoimentos">Gerenciar Depoimentos</a>

                <?php endif; ?>

                <a class="user out" href="<?= BASE_URL ?>/logout">Sair</a>

            <?php else: ?>

                <a class="msg" href="<?= BASE_URL ?>/login">Faça Login</a>
                <a class="msg" href="<?= BASE_URL ?>/cadastro">Cadastre-se</a>

            <?php endif; ?>
        </div>
    </div>
</header>
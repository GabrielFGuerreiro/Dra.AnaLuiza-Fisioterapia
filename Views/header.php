<header>
    <nav class="navbar navbar-expand-sm ">
      <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>/">Dra. Ana Luiza</a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="navbar-collapse collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['email'])): ?>
                
                <?php if ($_SESSION['isAdmin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/agendamentos">Ver Agendamentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/gerenciarDepoimentos">Gerenciar Depoimentos</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/preconsulta">Entre em Contato</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link user out" href="<?= BASE_URL ?>/logout">Sair</a>
                </li>

            <?php else: ?>
                <li class="nav-item">
                    <a id="login" class="nav-link active" href="<?= BASE_URL ?>/login">Entrar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>/cadastro">Cadastrar-se</a>
                </li>
            <?php endif; ?>
          </ul>
          </div>
      </div>
    </nav>
</header>
<header class="site-header">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <a class="navbar-brand" href="<?= BASE_URL ?>/">
          <span class="brand-mark"><img src="<?=  BASE_URL ?>/Images/Fisioterapia.png"></span>
          <span class="brand-copy">
            <strong>Dra. Ana Luiza</strong>
            <small>Fisioterapia</small>
          </span>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
          <span class="toggler-line"></span>
          <span class="toggler-line"></span>
          <span class="toggler-line"></span>
        </button>
        
        <div class="navbar-collapse collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <?php if (isset($_SESSION['email'])): ?>
                
                <?php if ($_SESSION['isAdmin']): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/agendamentos"><i class="fa-regular fa-calendar-check"></i><span>Agendamentos</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>/gerenciarDepoimentos"><i class="fa-regular fa-comments"></i><span>Depoimentos</span></a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link nav-principal" href="<?= BASE_URL ?>/preconsulta"><i class="fa-regular fa-calendar-plus"></i><span>Agendar consulta</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-exit" href="<?= BASE_URL ?>/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Sair</span></a>
                </li>

            <?php else: ?>
                <li class="nav-item">
                    <a id="login" class="nav-link nav-login" href="<?= BASE_URL ?>/login"><i class="fa-regular fa-user"></i><span>Entrar</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-principal" href="<?= BASE_URL ?>/cadastro"><span>Começar agora</span><i class="fa-solid fa-arrow-right"></i></a>
                </li>
            <?php endif; ?>
          </ul>
          </div>
      </div>
    </nav>
</header>
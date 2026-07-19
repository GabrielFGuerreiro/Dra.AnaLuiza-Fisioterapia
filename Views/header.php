<head>
    <style>html {color-scheme: light;}</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/light.css">
</head>
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
    <script>
    
    document.addEventListener("DOMContentLoaded", function()
    {
        var links = document.querySelectorAll(".nav-link");
        var uriAtual = "<?php echo $_SERVER['REQUEST_URI'];?>";
        console.log(uriAtual);
        links.forEach(link => {
            console.log(link.getAttribute("href"));
            if(link.getAttribute("href") == uriAtual)
            {
                link.classList.add("active");
                
            }
            else
                link.classList.remove("active");
        });
            
    });
</script>
</header>
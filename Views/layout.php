<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisio com a Ana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/base.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/login.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/cadastro.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>    
</head>

<body>
    <?php include RAIZ."/Views/header.php"; ?>
    <main>
        <?php include $view; ?>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function()
        {
            var links = document.querySelectorAll(".nav-link");
            links.forEach(link => {
                if (link.pathname === window.location.pathname) {
                    link.classList.add("active");
                }
            }); 
        });

        const alerta = document.getElementById("msgAlerta");
        function mostrarAlerta(msg) {
            alerta.querySelector("span").textContent = msg;

            alerta.classList.remove("alerta-form");
            void alerta.offsetWidth; // força o navegador a reiniciar a animação
            alerta.classList.add("alerta-form");

            alerta.style.display = "block";
        }

        const campos = document.querySelectorAll(".campo-form");
        campos.forEach(campo => {
            campo.addEventListener("input",  function()
            {
                alerta.style.display = "none";
            });
        });
       
    </script>
</body>
</html>

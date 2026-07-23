<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fisio com a Ana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.3.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/light.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/styles/login.css">
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
    </script>
</body>
</html>

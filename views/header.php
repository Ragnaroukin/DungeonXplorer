<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href=<?= url("img/Logo.png") ?> type="image/png">
    <title>DungeonXplorer</title>
    <!-- Font Awesome icons (free version)-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@400;700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />

    <!-- Core theme CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href=<?= url("css/styles.css") ?> rel="stylesheet" />
    <link href=<?= url("css/style.css") ?> rel="stylesheet" />
</head>

<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
        <div class="container">
            <a href=<?= url("") ?> id="lienHome"><img id="logo" src=<?= url("img/Logo.png") ?> alt="..." />
                <h1>DungeonXplorer</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <?php
                    if (isset($_SESSION["pseudo"])) {
                        ?>
                        <li class="nav-item"><a class="nav-link" href=<?= url("game/start") ?>>Jouer</a></li>
                        <li class="nav-item"><a class="nav-link" href=<?= url("game/create/class") ?>>Nouvelle Aventure</a></li>
                        <li class="nav-item"><a class="nav-link" href=<?= url("admin") ?>>Administration</a></li>
                        <li class="nav-item"><a class="nav-link" href=<?= url("profile") ?>><?= $_SESSION["pseudo"] ?></a></li>
                    <?php
                    } else {
                        ?>
                        <li class="nav-item"><a class="nav-link" href=<?= url("login") ?>>Se connecter</a></li>
                        <li class="nav-item"><a class="nav-link" href=<?= url("signup") ?>>S'inscrire</a></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
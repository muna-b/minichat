<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DM ME - <?php echo $title ?></title>

    <!-- bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <!-- font awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">

    <!-- google-font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Tamma+2:wght@500&display=swap" rel="stylesheet">

    <!-- notre feuille de style -->
    <link rel="stylesheet" href="<?php URLSITE ?>css/style.css">

</head>
<body class="bg-dark">
    <header>

        <!-- logo -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <a class="navbar-brand title" href="<?php URLSITE ?>">DM|ME <i class="fas fa-angle-double-right"></i></a>
            <!-- burger -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Menu -->
            <div class="collapse navbar-collapse " id="menu">
                <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php if($title == 'Accueil') echo 'active' ?> ">
                    <a class="nav-link" href="<?php URLSITE ?>">Accueil <span class="sr-only">(current)</span></a>
                </li>

                <?php if(!isConnected()) : ?>
                    <li class="nav-item <?php if($title == 'Inscription') echo 'active' ?>">
                        <a class="nav-link" href="<?php URLSITE ?>inscription.php">Inscription</a>
                    </li>
                    <li class="nav-item <?php if($title == 'Connexion') echo 'active' ?>">
                        <a class="nav-link" href="<?php URLSITE ?>connexion.php">Connexion</a>
                    </li>
                <?php else : ?>
                <li class="nav-item <?php if($title == 'Accueil') echo 'Profil' ?>">
                    <a class="nav-link" href="<?php URLSITE ?>profil.php">Profil [<?php echo $_SESSION['user']['login'] ?>] </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php URLSITE ?>connexion.php?action=deco">Déconnexion</a>
                </li>
                <?php endif; ?>
            </div>
        </nav>
</header>

    <main class="container">
   
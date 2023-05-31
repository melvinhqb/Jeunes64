<?php
    session_start();

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
    } else {
        // Si aucune session n'est active, affiche les liens de connexion et d'inscription
        $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4 - Accueil</title>
    <link rel="icon" href="assets/logo4.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9b3084e9e8.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="large-container">
            <div class="header-status">
                <?php echo $message; ?>
            </div>
            <div class="header-body">
                <div class="header-logo">
                    <a href="home.php"><img src="assets/logo1.png" alt="Logo Jeunes 6.4"></a>
                </div>
                <div class="header-text">
                    <div class="header-slogan">
                        <h2 class="slogan">Pour faire de l'engagement une valeur</h2>
                    </div>
                </div>
            </div>
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="search_user.php">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="medium-container">
            <h1 class="main-title">Bienvenue sur la platforme JEUNES 6.4, une initiative de la région Pyrénées-Atlantiques</h1>
            <h2 class="subtitle">De quoi s'agit-il ?</h2>
            <p class="text">
                <b>D'une opportunité :</b> celle qu'un engagement quel qu'il soit puisse être considéré à sa juste valeur !
                Toute expérience est source d'enrichissement et se doit d'être reconnu largement.
                Elle révèle un potentiel, l'expression d'un savoir-être à concrétiser.
            </p>
            <h2 class="subtitle">À qui s'adresse-t'il ?</h2>
            <p class="text">
                <b>À vous, jeunes entre 16 et 30 ans,</b> qui vous êtes investis spontanément dans une association ou dans tout type 
                d'action formelle ou informelle, et qui avez partagé de votre temps, de votre énergie, pour apporter un 
                soutien, une aide, une compétence.
            </p>
            <p class="text">
                <b>À vous, responsables de strutures ou référents d'un jour,</b> qui avez croisé la route de ces jeunes et avez 
                bénéficié même ponctuellement de cette implication citoyenne !
            </p>
            <p class="text">
                <b>À vous, employeurs, recruteurs en ressources humaines, représentants d'organismes de formation,</b>
                qui recevez ces jeunes, pour un emploi, un stage, un cursus de qualification, pour qui le savoir être
                constitue le premier fondement de toute capacité humaine.
            </p>
        </div>
    </main>
    <section id="cards">
        <div class="medium-container">
            <h2 class="subtitle">Cet engagement est une ressource à valoriser au fil d'un parcours en 3 étapes</h2>
            <div class="row-cards">
                <div class="card">
                    <span class="card__step-number card__step-number-1">étape 1</span>
                    <h2 class="card__unit-name">Valorisation</h2>
                    <p class="card__unit-description">Décrivez votre expérience et mettez en avant ce que vous en avez retiré.</p>
                </div>
                <div class="card">
                    <span class="card__step-number card__step-number-2">étape 2</span>
                    <h2 class="card__unit-name">Confirmation</h2>
                    <p class="card__unit-description">Confirmez cette expérience et ce que vous avez pu constater au contact de ce jeune.</p>
                </div>
                <div class="card">
                    <span class="card__step-number card__step-number-3">étape 3</span>
                    <h2 class="card__unit-name">Consultation</h2>
                    <p class="card__unit-description">Validez cet engagement en prenant en compte sa valeur.</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
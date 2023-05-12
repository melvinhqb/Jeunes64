<?php
session_start();

if (isset($_SESSION['email'])) {
    $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
} else {
    $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4 - Partenaires</title>
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
                    <h1 class="xl-title partner">Partenaires</h1>
                </div>
            </div>
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner active"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="partners">
        <div class="medium-container">
            <h1 class="main-title">
                Nos partenaires
            </h1>
            <ul class="partners__list">
                <li class="partner__logo"><a href=""><img src="assets/logo-rep-fr.png" alt="Logo République française"></a></li>
                <li class="partner__logo"><a href=""><img src="assets/logo-region-aquitaine.png" alt="Logo aquitaine"></a></li>
                <li class="partner__logo"><a href=""><img src="assets/logo-conseil-general.png" alt="Logo Pyrénées-Atlantiques"></a></li>
                <li class="partner__logo"><a href=""><img src="assets/logo-msa.png" alt="Logo MSA"></a></li>
                <li class="partner__logo"><a href=""><img src="assets/logo-assurance-maladie.png" alt="Logo "></a></li>
                <li class="partner__logo"><a href=""><img src="assets/logo-universite-pau.png" alt=""></a></li>
            </ul>
            <p class="text">
                JEUNES 6.4 est un dispositif issu de la charte de l'engagement pour la jeunesse signée en 2013 par des partenaires institutionnels
                qui ont décidé de mettre en commun leurs actions pour les jeunes des Pyrénées-Atlantiques.
            </p>
            <p class="text"><a class="link" href="assets/charte-engagement.pdf" download><i class="fa-solid fa-download"></i> Télécharger la charte de l'engagement</a></p>
        </div>
    </section>
</body>
</html>

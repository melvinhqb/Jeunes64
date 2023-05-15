<?php
session_start();

if (isset($_SESSION['email'])) {
    $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
} else {
    $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4</title>
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
                            <h1 class="xl-title referent">Référent</h1>
                            <h2 class="slogan">Je confirme la valeur de ton engagement</h2>
                    </div>
                </div>
                <nav class="header-nav">
                    <ul class="nav-list">
                        <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                        <li class="nav-item referent active"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                        <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                        <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                    </ul>
                </nav>
            </div>
    </header>

        <div class="medium-container">
            <h2 class="subtitle text-center">Les données saisies ont bien été prises en compte. Merci pour votre constribution !</h2>
            <p class="text text-center"><a href="verif_hash.php" class="link">Retour au module «Référent»</a></p>
        </div>
</body>
</html>
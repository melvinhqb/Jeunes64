<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        exit();
    }

    $email = $_SESSION['email']; // Récupérer les informations de l'utilisateur courant
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);

    $userData = json_decode(file_get_contents($users[$email]), true);

?>


<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4 - Mon profil</title>
    <link rel="icon" href="assets/logo4.ico">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9b3084e9e8.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <div class="large-container">
            <div class="header-status">
                <a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>
            </div>
            <div class="header-body">
                <div class="header-logo">
                    <a href="home.php"><img src="assets/logo-jeunes.png" alt="Logo Jeunes 6.4"></a>
                </div>
                <div class="header-text">
                        <h1 class="xl-title young">Jeune</h1>
                        <h2 class="slogan">Je donne de la valeur à mon engagement</h2>
                </div>
            </div>
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item young active"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="young">
        <div class="subnav">
            <div class="medium-container">
                <ul class="subnav-list">
                    <li class="subnav-item active"><a class="subnav-link" href="profil.php">Mon profil</a></li>
                    <li class="subnav-item"><a class="subnav-link" href="new_ref.php">Demande de référence</a></li>
                    <li class="subnav-item"><a class="subnav-link" href="edit_profil.php">Modifier mon profil</a></li>
                    <li class="subnav-item"><a class="subnav-link" href="my_cv.php">Mon CV</a></li>
                </ul>
            </div>
        </div>
        <div class="medium-container">
            <h1 class="main-title">Bienvenue <?php echo $userData['firstname']; ?> <?php echo $userData['lastname']; ?> !</h1>
            <p class="text">Email: <?php echo $userData['email']; ?></p>
            <p class="text">Date de naissance: <?php echo $userData['birth']; ?></p>
        </div>
    </section>
</body>
</html>
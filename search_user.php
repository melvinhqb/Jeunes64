<?php
    session_start();

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
    } else {
        $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
    }

    $err_msg = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $file = 'users.json';
        $data = file_get_contents($file);
        $users = json_decode($data, true);

        $user_email = $_POST['email'];

        $err_msg = "<div class='alert alert-danger alert-white rounded'>
                        <div class='icon'><i class='fa fa-times-circle'></i></div>
                        <strong>Erreur</strong> Cet utilisateur n'existe pas.
                    </div>";

        foreach ($users as $email => $path) {
            // Parcours tous les utilisateurs pour vérifier si l'email correspond
            if ($email == $user_email) {
                header("Location: consult.php?email=". $email);
                exit; // Redirige vers la page consult.php avec l'email en paramètre
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="fr">
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
                            <h1 class="xl-title consultant">Consultant</h1>
                            <h2 class="slogan">Je donne de la valeur à ton engagement</h2>
                    </div>
                </div>
                <nav class="header-nav">
                    <ul class="nav-list">
                        <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                        <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                        <li class="nav-item consultant active"><a class="nav-link" href="search_user.php">Consultant</a></li>
                        <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <section class="consultant">
            <div class="small-container">
                <h1 class="main-title">Entrer l'adresse mail d'un jeune</h1>
                <?php echo $err_msg; ?>
                <h3 class="h3-description">Validez cet engagement en preant en compte sa valeur.</h3>
                <form action="search_user.php" method="post">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="center">
                        <button type="submit" class="btn">Entrer</button>
                    </div>
                </form> 
            </div>   
        </section>
    </body>
</html>
<?php
    session_start();

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

        $hash = $_POST['hash'];

        $err_msg = "Ce code n'est pas valide";

        foreach ($users as $email => $path) {

            $userData = json_decode(file_get_contents($users[$email]), true);
        
            if (isset($userData['references'])) { // Vérification de la clé "references"
                foreach ($userData['references'] as $stockedHash => $reference) {
                    if ($stockedHash == $hash) {
                        if ($userData['references'][$hash]['verif'] == 1) {
                            $err_msg = "Ce code n'est plus valide";
                        }
                        else {
                            //echo password_hash($hash, PASSWORD_DEFAULT);
                            header("Location: valid_ref.php?hash=" . password_hash($hash, PASSWORD_DEFAULT));
                        }
                    }
                }
            }
        }
        
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
    <section class="referent">
        <div class="small-container">
        <h1 class="main-title">Entrer votre code à 12 caractères</h1>
        <?php echo $err_msg; ?>
        <h3 class="h3-description">Confirmez cette expérience et ce que vous avez pu constater au contact de ce jeune.</h3>
        <form id="hashform" action="verif_hash.php" method="post">
            <div class="input-group">
                <label for="register-lastname">Code</label>
                <input type="password" id="hash" name="hash" required>
            </div>
            <div class="center">
                <button type="submit" class="btn">Entrer</button>
            </div>
        </form> 
        </div>   
    </section>
</body>
</html>
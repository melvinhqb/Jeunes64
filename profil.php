<?php
    session_start();

    // Vérifier si l'email de l'utilisateur est défini dans la session
    if (!isset($_SESSION['email'])) {
        // Rediriger vers la page de connexion s'il n'est pas connecté
        header("Location: login.php");
        exit();
    }

    $email = $_SESSION['email'];
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);

    $send_msg = "";

    if (isset($_SESSION['changes_confirmed'])) {
        $confirmation_message = "<div class='alert alert-success alert-white rounded'>
                                    <div class='icon'><i class='fa fa-check'></i></div>
                                    <strong>Confirmation</strong> Les changements ont été effectués avec succès !
                                </div>";
        unset($_SESSION['changes_confirmed']);
    } else {
        $confirmation_message = "";
    }

    // Obtenir les données de l'utilisateur à partir du fichier JSON
    $userData = json_decode(file_get_contents($users[$email]), true);

    // Construire l'URL de la page de consultation
    $consultPageURL = 'http';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $consultPageURL .= 's';
    }
    $consultPageURL .= '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/consult.php?email=' . $email;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupère l'email du consultant
        $consultEmail = $_POST["consult-email"];

        // Envoi de l'email de validation à l'adresse du référent
        $receiver = $consultEmail;
        $subject = "Consultez le profil de " . $userData['firstname'] . " " . $userData['lastname'];
        $body = $consultPageURL;
        $sender = "From: Jeunes 6.4";

        // Envoi de l'email
        if (mail($receiver, $subject, $body, $sender) && strpos(strtolower(ini_get('sendmail_path')), 'smtp') !== false) {
            $send_msg = "<div class='alert alert-success alert-white rounded'>
                            <div class='icon'><i class='fa fa-check'></i></div>
                            <strong>Confirmation</strong> Votre lien a été envoyé à $receiver
                        </div>";
        } else {
            $send_msg = "<div class='alert alert-danger alert-white rounded'>
                            <div class='icon'><i class='fa fa-times-circle'></i></div>
                            <strong>Erreur</strong> L'email n'a pas pu être envoyé à $receiver
                        </div>";
        }
    }
?>


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
                        <a href="home.php"><img src="assets/logo1.png" alt="Logo Jeunes 6.4"></a>
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
                        <li class="nav-item consultant"><a class="nav-link" href="search_user.php">Consultant</a></li>
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
                        <li class="subnav-item"><a class="subnav-link" href="references.php">Demande de référence</a></li>
                        <li class="subnav-item"><a class="subnav-link" href="create_cv.php">Mon CV</a></li>
                    </ul>
                </div>
            </div>
            <div class="medium-container">
                <h1 class="main-title">Bienvenue <?php echo $userData['firstname']; ?> <?php echo $userData['lastname']; ?> !</h1>
                <div class="title-btn">
                    <h2 class="subtitle">Mes informations personnelles</h2>
                    <p class="text"><a href="edit_profil.php" class="link-btn"><i class="fa-solid fa-pen-to-square"></i> Modifier profil</a></p>
                </div>
                <?php echo $confirmation_message;?></p>
                <div class="ref-info">
                    <p><i class="fa-solid fa-cake-candles color-icn"></i> <?php echo date("d M Y", strtotime($userData['birth'])); ?></p>
                    <p><i class="fa-solid fa-at color-icn"></i> <?php echo $userData['email']; ?></p>
                    <p><i class="fa-solid fa-phone color-icn"></i> <?php echo $userData['tel']; ?></p>
                </div>
                <h2 class="subtitle">Partager mon profil</h2>
                <div class="copy-link-bar">
                    <input type="text" id="text-link" class="text-link" value="<?php echo $consultPageURL; ?>" readonly>
                    <button class="copy-button" id="copy-button">Copier</button>
                </div>
                <h2 class="subtitle">Envoyer le lien à un consultant</h2>
                <form action="profil.php" method="post">
                    <?php echo $send_msg;?>
                    <div class="copy-link-bar">
                        <input type="email" id="text-link" name="consult-email" class="text-link" require>
                        <button type="submit" class="copy-button">Envoyer</button>
                    </div>
                </form>
            </div>
        </section>
        
        <script>
            document.getElementById("copy-button").addEventListener("click", function() {
                var textInput = document.getElementById("text-link");
                textInput.select();
                document.execCommand("copy");
                alert("Le texte a été copié dans le presse-papiers !");
            });
        </script>
    </body>
</html>
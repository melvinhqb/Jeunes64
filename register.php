<?php
    session_start();

    if (isset($_SESSION['email'])) {
        // Si l'utilisateur est déjà connecté, redirige vers la page de profil
        header("Location: profil.php");
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!file_exists('data')) {
            // Crée le répertoire 'data' s'il n'existe pas
            mkdir('data', 0777, true);
        }

        $usersFile = 'users.json';
        if (file_exists($usersFile)) {
            // Si le fichier users.json existe, charge son contenu
            $usersData = file_get_contents($usersFile);
            $users = json_decode($usersData, true);
        } else {
            $users = array(); // Crée un tableau vide si le fichier n'existe pas
        }

        $email = $_POST['email'];

        if (isset($users[$email])) {
            // Si l'email est déjà utilisé, affiche un message d'erreur
            $message = "<div class='alert alert-warning alert-white rounded'>
                            <div class='icon'><i class='fa fa-warning'></i></div>
                            <strong>Attention !</strong> Cet email est déjà utilisé. Veuillez en choisir un autre.
                        </div>";
        } else {
            $lastname = $_POST['lastname'];
            $firstname = $_POST['firstname'];
            $birth = $_POST['birth'];
            $tel = $_POST['tel'];
            $password = $_POST['password'];
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
            $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

            $userData = array(
                'email' => $email,
                'password' => $passwordHash,
                'lastname' => $lastname,
                'firstname' => $firstname,
                'birth' => $birth,
                'tel' => $tel
            );

            $users[$email] = $userJsonPath; // Ajoute l'association email / chemin d'accès au fichier JSON dans le tableau des utilisateurs

            file_put_contents($usersFile, json_encode($users)); // Enregistre le tableau des utilisateurs dans le fichier users.json
            file_put_contents($userJsonPath, json_encode($userData)); // Enregistre les données de l'utilisateur dans le fichier JSON correspondant

            $_SESSION['email'] = $email;
            header("Location: profil.php");
        }
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jeunes 6.4 - Inscription</title>
        <link rel="icon" href="assets/logo4.ico">
        <link rel="stylesheet" href="style.css">
        <script src="https://kit.fontawesome.com/9b3084e9e8.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <div class="large-container">
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
                        <li class="nav-item young active"><a class="nav-link" href="register.php">Jeune</a></li>
                        <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                        <li class="nav-item consultant"><a class="nav-link" href="search_user.php">Consultant</a></li>
                        <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        
        <section class="form register young">
            <div class="small-container">
                <h1 class="main-title">S'inscrire</h1>
                <?php if (isset($message)) { echo "<p class='text'>$message</p>"; } ?>
                <form id="register-form" action="register.php" method="post">
                    <div class="input-group">
                        <label for="register-lastname">Nom</label>
                        <input type="text" id="register-lastname" name="lastname" required>
                    </div>
                    <div class="input-group">
                        <label for="register-firstname">Prénom</label>
                        <input type="text" id="register-firstname" name="firstname" required>
                    </div>
                    <div class="input-group">
                        <label for="register-birth">Date de naissance</label>
                        <input type="date" id="register-birth" name="birth" required>
                    </div>
                    <div class="input-group">
                        <label for="register-email">Email</label>
                        <input type="email" id="register-email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="register-tel">Numéro de téléphone</label>
                        <input type="tel" id="register-tel" name="tel" pattern="0[1-9](\d{2}){4}" required>
                    </div>
                    <div class="input-group">
                        <label for="register-password">Mot de passe</label>
                        <input type="password" id="register-password" name="password" required>
                    </div>
                    <div class="center">
                        <button type="submit">S'inscrire</button>
                    </div>
                </form>
                <p class="text">Déjà inscrit ? <a href="login.php" class="link">Se connecter</a></p>
            </div>
        </section>
    </body>
</html>

<?php

session_start();

if (isset($_SESSION['email'])) {
    header("Location: profil.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!file_exists('data')) {
        mkdir('data', 0777, true);
    }
    $usersFile = 'users.json';
    $usersData = file_get_contents($usersFile);
    $users = json_decode($usersData, true);
    $email = $_POST['email'];
    if (isset($users[$email])) {
        // Si l'email est déjà utilisé, affiche un message d'erreur
        $message = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
    } else {
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $birth = $_POST['birth'];
        $password = $_POST['password'];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userJsonFile = $email . '.json'; // Nom du fichier JSON pour l'utilisateur
        $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur
        $userData = array(
            'email' => $email,
            'password' => $passwordHash,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'birth' => $birth
        );
        $users[$email] = $userJsonPath; // Ajoute l'association e-mail / chemin d'accès au fichier JSON dans le tableau des utilisateurs
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
                    <a href="home.php"><img src="assets/logo-jeunes.png" alt="Logo Jeunes 6.4"></a>
                </div>
                <div class="header-text">
                        <h1 class="xl-title young">Jeune</h1>
                        <h2 class="slogan">Je donne de la valeur à mon engagement</h2>
                </div>
            </div>
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item young"><a class="nav-link" href="register.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
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

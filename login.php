<?php
session_start();

if (isset($_SESSION['email'])) {
    header("Location: profil.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!file_exists('users.json')) {
        $message = "L'email ou le mot de passe est incorrect.";
    }
    else if (array_key_exists($email, $users)) {
        $userData = json_decode(file_get_contents($users[$email]), true);
        $passwordHash = $userData['password'];
        if (password_verify($password, $passwordHash)) {
            $_SESSION['email'] = $email;
            header("Location: profil.php");
        } else {
            $message = "L'email ou le mot de passe est incorrect.";
        }
    } else {
        $message = "L'email ou le mot de passe est incorrect.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4 - Connexion</title>
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
                    <li class="nav-item young"><a class="nav-link" href="login.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="form login">
        <div class="small-container">
            <h1 class="main-title">Se connecter</h1>
            <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
            <form id="login-form" action="login.php" method="post">
                    <div class="input-group">
                        <label for="login-email">Email</label>
                        <input type="email" id="login-email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="login-password">Mot de passe</label>
                        <input type="password" id="login-password" name="password" required>
                    </div>
                    <div class="center">
                        <button type="submit" class="btn">Se connecter</button>
                    </div>
                </form>
            <p class="text">Pas encore inscrit ? <a href="register.php" class="link">S'inscrire</a></p>
        </div>
    </section>
</body>
</html>

<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php");
    }

    $email = $_SESSION['email'];

    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);

    $userData = json_decode(file_get_contents($users[$email]), true);

    $firstname = $userData["firstname"];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4 - Créer Référence</title>
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
                    <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
	<section class="young">
        <div class="small-container">
            <h1 class="main-title">Demande de référence</h1>
            <h3 class="h3-description">Décrivez votre expérience et mettez en avant ce que vous en avez retiré.</h3>
            <form action="new_ref.php" method="post">
                <h2 class="subtitle">Coordonnées du référent</h2>
                <div class="input-group">
                    <label for="referent-lastname">Nom</label>
                    <input type="text" id="referent-lastname" name="referent-lastname" require>
                </div>
                <div class="input-group">
                    <label for="referent-firstname">Prénom</label>
                    <input type="text" id="referent-firstname" name="referent-firstname" require>
                </div>
                <div class="input-group">
                    <label for="referent-birth">Date de naissance</label>
                    <input type="date" id="referent-birth" name="referent-birth" require>
                </div>
                <div class="input-group">
                    <label for="referent-email">Email</label>
                    <input type="email" id="referent-email" name="referent-email" require>
                </div>
                <h2 class="subtitle">Mon engagement</h2>
                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="10"></textarea>
                </div>
                <div class="input-group">
                    <label for="time">Durée (en jours)</label>
                    <input type="number" id="time" name="time" min=0 require>
                </div>
                <h2 class="subtitle">Mes savoirs être</h2>
                <div class="checkbox-list">
                    <div class="checkbox-group">
                        <input type="checkbox" id="Autonome" name="Autonome">
                        <label for="Autonome">Autonome</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Capable d'anlyse et de sinthèse" name="Capable d'anlyse et de sinthèse">
                        <label for="Capable d'anlyse et de sinthèse">Capable d'anlyse et de sinthèse</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="A l'écoute" name="A l'écoute">
                        <label for="A l'écoute">A l'écoute</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Organisé" name="Organisé">
                        <label for="Organisé">Organisé</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Passionné" name="Passionné">
                        <label for="Passionné">Passionné</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Fiable" name="Fiable">
                        <label for="Fiable">Fiable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Patient" name="Patient">
                        <label for="Patient">Patient</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Réfléchi" name="Réfléchi">
                        <label for="Réfléchi">Réfléchi</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Responsable" name="Responsable">
                        <label for="Responsable">Responsable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Sociable" name="Sociable">
                        <label for="Sociable">Sociable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="Optimiste" name="Optimiste">
                        <label for="Optimiste">Optimiste</label>
                    </div>
                </div>
                <div class="center">
                        <button type="submit" class="btn">Envoyer</button>
                    </div>
            </form>
        </div>
        <div class="large-container">
            <button onclick="location.href='new_ref.php'">creer une ref</button>
            <button onclick="location.href='profil.php'">consulter mon profil</button>
            <button onclick="location.href='edit_profil.php'">modifier mon profil</button>
        </div>
	</section>
</body>
</html>

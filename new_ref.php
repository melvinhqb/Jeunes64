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
<body class="young">
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
                    <li class="nav-item young"><a class="nav-link" href="welcome.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
	<section>
		<div class="medium-container">
			<h1 class="main-title">Bienvenue <?php echo $firstname; ?></h1>
			<p class="text">Vous êtes connecté en tant que <?php echo $email; ?>.</p>
		</div>
        <div class="medium-container">
            <nav class="vertical-nav">
                <ul>
                    <li><a href="">Demande de référence</a></li>
                    <li><a href="">Mes informations personelles</a></li>
                </ul>
            </nav>
            <div class="small-container">
            <form action="">
                <h2>Coordonnées du référent</h2>
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
                <h2>Mon engagement</h2>
                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="10"></textarea>
                </div>
                <div class="input-group">
                    <label for="time">Durée (en jours)</label>
                    <input type="number" id="time" name="time" min=0 require>
                </div>
            </form>
            </div>
   
        <h2>Décrivez votre expérience et mettez en avant ce que vous en avez retiré.</h2>

    <h2>MES SAVOIR ETRE</h2>

    <fieldset>
        <legend>JE SUIS*</legend>
    
        <div>
          <input type="checkbox" id="Autonome" name="Autonome" checked>
          <label for="Autonome">Autonome</label>
        </div>
        <div>
          <input type="checkbox" id="Capable d'anlyse et de sinthèse" name="Capable d'anlyse et de sinthèse">
          <label for="Capable d'anlyse et de sinthèse">Capable d'anlyse et de sinthèse</label>
        </div>
        <div>
            <input type="checkbox" id="A l'écoute" name="A l'écoute" checked>
            <label for="A l'écoute">A l'écoute</label>
        </div>
        <div>
            <input type="checkbox" id="Organisé" name="Organisé" checked>
            <label for="Organisé">Organisé</label>
        </div>
        <div>
            <input type="checkbox" id="Passionné" name="Passionné" checked>
            <label for="Passionné">Passionné</label>
        </div>
        <div>
            <input type="checkbox" id="Fiable" name="Fiable" checked>
            <label for="Fiable">Fiable</label>
        </div>
        <div>
            <input type="checkbox" id="Patient" name="Patient" checked>
            <label for="Patient">Patient</label>
        </div>
        <div>
            <input type="checkbox" id="Réfléchi" name="Réfléchi" checked>
            <label for="Réfléchi">Réfléchi</label>
        </div>
        <div>
            <input type="checkbox" id="Responsable" name="Responsable" checked>
            <label for="Responsable">Responsable</label>
        </div>
        <div>
            <input type="checkbox" id="Sociable" name="Sociable" checked>
            <label for="Sociable">Sociable</label>
        </div>
        <div>
            <input type="checkbox" id="Optimiste" name="Optimiste" checked>
            <label for="Optimiste">Optimiste</label>
        </div>
    </fieldset>
    <h5>*Faire 4 choix maximum</h5>
        </div>
	</section>
</body>
</html>

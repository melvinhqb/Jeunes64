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
    <title>Jeunes 6.4</title>
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
        <h4>Décrivez votre expérience et mettez en avant ce que vous en avez retiré.</h4>
    <form action="submit_form.php" enctype="multipart/form-data" method="post">
        <table border="1">
            
            <tr>
                <th colspan="2">JEUNE</th>
            </tr>

            <tr>
                <td>NOM :</td>
                <td><input type="text" name="name"></td>
            </tr>

            <tr>
                <td>PRENOM :</td>
                <td><input type="text" name="forname"></td>
            </tr>

            <tr>
                <td>DATE DE NAISSANCE :</td>
                <td><input type="text" name="number"></td>
            </tr>

            <tr>
                <td>Mail du Referent </td>
                <td><input type="text" name="mail_ref"></td>
            </tr>

            <tr>
                <td>Réseau social :</td>
                <td><input type="text" name="social"></td>
            </tr>

            <tr>
                <td>MON ENGAGEMENT :</td>
                <td><input type="text" name="engagement"></td>
            </tr>

            <tr>
                <td>DUREE :</td>
                <td><input type="text" name="duree"></td>
            </tr>

        

        </table>
    

    <h2>MES SAVOIR ETRE</h2>

    <fieldset>
        <legend>JE SUIS*</legend>
    
        <div>
          <input type="checkbox" id="Autonome" name="Autonome" >
          <label for="Autonome">Autonome</label>
        </div>
        <div>
          <input type="checkbox" id="Capable d'anlyse et de sinthèse" name="CapableAnalyse">
          <label for="Capable d'anlyse et de sinthèse">Capable d'anlyse et de sinthèse</label>
        </div>
        <div>
            <input type="checkbox" id="A l'écoute" name="ALEcoute" >
            <label for="A l'écoute">A l'écoute</label>
        </div>
        <div>
            <input type="checkbox" id="Organisé" name="Organisé" >
            <label for="Organisé">Organisé</label>
        </div>
        <div>
            <input type="checkbox" id="Passionné" name="Passionné" >
            <label for="Passionné">Passionné</label>
        </div>
        <div>
            <input type="checkbox" id="Fiable" name="Fiable" >
            <label for="Fiable">Fiable</label>
        </div>
        <div>
            <input type="checkbox" id="Patient" name="Patient" >
            <label for="Patient">Patient</label>
        </div>
        <div>
            <input type="checkbox" id="Réfléchi" name="Réfléchi" >
            <label for="Réfléchi">Réfléchi</label>
        </div>
        <div>
            <input type="checkbox" id="Responsable" name="Responsable" >
            <label for="Responsable">Responsable</label>
        </div>
        <div>
            <input type="checkbox" id="Sociable" name="Sociable" >
            <label for="Sociable">Sociable</label>
        </div>
        <div>
            <input type="checkbox" id="Optimiste" name="Optimiste" >
            <label for="Optimiste">Optimiste</label>
        </div>
    </fieldset>
    <button type="submit" name="submit" >Envoyer<img src="validation.png"></button>
    </form>
    <h5>*Faire 4 choix maximum</h5>
        </div>
	</section>
</body>
</html>

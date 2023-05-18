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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collecte des informations du formulaire
        $refLastname = $_POST['referent-lastname'];
        $refFirstname = $_POST['referent-firstname'];
        $refBirth = $_POST['referent-birth'];
        $refEmail = $_POST['referent-email'];
        $refTel = $_POST['referent-tel'];
        $commitmentType = $_POST['commitment-type'];
        $description = $_POST['description'];
        $period = $_POST['period'];

        $autonome['value'] = (isset($_POST['autonome'])) ? $_POST['autonome'] : "off";
        $analyse['value'] = (isset($_POST['analyse'])) ? $_POST['analyse'] : "off";
        $ecoute['value'] = (isset($_POST['ecoute'])) ? $_POST['ecoute'] : "off";
        $organise['value'] = (isset($_POST['organise'])) ? $_POST['organise'] : "off";
        $passionne['value'] = (isset($_POST['passionne'])) ? $_POST['passionne'] : "off";
        $fiable['value'] = (isset($_POST['fiable'])) ? $_POST['fiable'] : "off";
        $patient['value'] = (isset($_POST['patient'])) ? $_POST['patient'] : "off";
        $reflechi['value'] = (isset($_POST['reflechi'])) ? $_POST['reflechi'] : "off";
        $responsable['value'] = (isset($_POST['responsable'])) ? $_POST['responsable'] : "off";
        $sociable['value'] = (isset($_POST['sociable'])) ? $_POST['sociable'] : "off";
        $optimiste['value'] = (isset($_POST['optimiste'])) ? $_POST['optimiste'] : "off";

        $autonome['name'] = "Autonome";
        $analyse['name'] = "Capable d'analyse et de synthèse";
        $ecoute['name'] = "À l'écoute";
        $organise['name'] = "Organisé";
        $passionne['name'] = "Passionné";
        $fiable['name'] = "Fiable";
        $patient['name'] = "Patient";
        $reflechi['name'] = "Réfléchi";
        $responsable['name'] = "Responsable";
        $sociable['name'] = "Sociable";
        $optimiste['name'] = "Optimiste";

        $userSkills = [
            'autonome' => $autonome,
            'analyse' => $analyse,
            'ecoute' => $ecoute,
            'organise' => $organise,
            'passionne' => $passionne,
            'fiable' => $fiable,
            'patient' => $patient,
            'reflechi' => $reflechi,
            'responsable' => $responsable,
            'sociable' => $sociable,
            'optimiste' => $optimiste,
        ];  

        // Préparation des données à stocker
        $newReference = [
            'lastname' => $refLastname,
            'firstname' => $refFirstname,
            'birth' => $refBirth,
            'email' => $refEmail,
            'tel' => $refTel,
            'commitment-type' => $commitmentType,
            'description' => $description,
            'period' => $period,
            'skills' => $userSkills,
            'verif' => '0',
        ];

        $newRefHash = substr(hash('sha256', json_encode($newReference)), 0, 12);

        // Remplacement du caractère @ dans l'adresse e-mail par un tiret bas (_)
        $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
        $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

        // Ajouter les nouvelles données à la suite des données existantes
        $userData['references'][$newRefHash] = $newReference;

        // Réécrire le fichier avec les données mises à jour
        file_put_contents($userJsonPath, json_encode($userData));

        // Redirection vers une autre page (par exemple, le tableau de bord) après l'enregistrement des données
        header("Location: references.php");
        exit();
    }

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
                    <li class="subnav-item"><a class="subnav-link" href="profil.php">Mon profil</a></li>
		            <li class="subnav-item active"><a class="subnav-link" href="references.php">Demande de référence</a></li>
                    <li class="subnav-item"><a class="subnav-link" href="create_cv.php">Mon CV</a></li>
                </ul>
            </div>
        </div>
        <div class="small-container">
            <h1 class="main-title">Nouvelle demande de référence</h1>
            <h3 class="h3-description">Décrivez votre expérience et mettez en avant ce que vous en avez retiré.</h3>
            <form action="new_ref.php" method="post">
                <h2 class="subtitle">Coordonnées du référent</h2>
                <div class="input-group">
                    <label for="referent-lastname">Nom</label>
                    <input type="text" id="referent-lastname" name="referent-lastname" required>
                </div>
                <div class="input-group">
                    <label for="referent-firstname">Prénom</label>
                    <input type="text" id="referent-firstname" name="referent-firstname" required>
                </div>
                <div class="input-group">
                    <label for="referent-birth">Date de naissance</label>
                    <input type="date" id="referent-birth" name="referent-birth" required>
                </div>
                <div class="input-group">
                    <label for="referent-email">Email</label>
                    <input type="email" id="referent-email" name="referent-email" required>
                </div>
                <div class="input-group">
                    <label for="referent-email">Téléphone</label>
                    <input type="tel" id="referent-tel" name="referent-tel" pattern="0[1-9](\d{2}){4}" required>
                </div>
                <h2 class="subtitle">Mon engagement</h2>
                <div class="input-group">
                    <label for="commitment-type">Milieu de l'engagement</label>
                    <input type="text" id="commitment-type" name="commitment-type" required>
                </div>
                <div class="input-group">
                    <label for="period">Durée (en mois)</label>
                    <input type="number" id="period" name="period" min=1 required>
                </div>
                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="10" require></textarea>
                </div>
                <h2 class="subtitle">Mes savoirs être</h2>
                <div class="checkbox-list">
                    <div class="checkbox-group">
                        <input type="checkbox" id="autonome" name="autonome">
                        <label for="autonome">Autonome</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="analyse" name="analyse">
                        <label for="analyse">Capable d'anlyse et de sinthèse</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="ecoute" name="ecoute">
                        <label for="ecoute">A l'écoute</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="organise" name="organise">
                        <label for="organise">Organisé</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="passionne" name="passionne">
                        <label for="passionne">Passionné</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="fiable" name="fiable">
                        <label for="fiable">Fiable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="patient" name="patient">
                        <label for="patient">Patient</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="reflechi" name="reflechi">
                        <label for="reflechi">Réfléchi</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="responsable" name="responsable">
                        <label for="responsable">Responsable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="sociable" name="sociable">
                        <label for="sociable">Sociable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="optimiste" name="optimiste">
                        <label for="optimiste">Optimiste</label>
                    </div>
                </div>
                <div class="center">
                        <button type="submit" class="btn">Envoyer</button>
                </div>
            </form>
        </div>
	</section>
</body>
</html>

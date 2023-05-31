<?php
    session_start();

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
    } else {
        $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $file = 'users.json';
        $data = file_get_contents($file);
        $users = json_decode($data, true);

        $email = $_POST['email'];
        $hash = $_POST['hash'];
        $refComment = $_POST['refComment'];
        $refLastname = $_POST['referent-lastname'];
        $refFirstname = $_POST['referent-firstname'];
        $refBirth = $_POST['referent-birth'];
        $refTel = $_POST['referent-tel'];

        $userData = json_decode(file_get_contents($users[$email]), true);

        foreach ($userData['references'] as $stockedHash => $reference) {
            if ($stockedHash == $hash) {
                // Mise à jour des compétences de la référence
                $skills = $reference['skills'];
                $skills['autonome']['refValue'] = (isset($_POST['autonome'])) ? $_POST['autonome'] : "off";
                $skills['analyse']['refValue'] = (isset($_POST['analyse'])) ? $_POST['analyse'] : "off";
                $skills['ecoute']['refValue'] = (isset($_POST['ecoute'])) ? $_POST['ecoute'] : "off";
                $skills['organise']['refValue'] = (isset($_POST['organise'])) ? $_POST['organise'] : "off";
                $skills['passionne']['refValue'] = (isset($_POST['passionne'])) ? $_POST['passionne'] : "off";
                $skills['fiable']['refValue'] = (isset($_POST['fiable'])) ? $_POST['fiable'] : "off";
                $skills['patient']['refValue'] = (isset($_POST['patient'])) ? $_POST['patient'] : "off";
                $skills['reflechi']['refValue'] = (isset($_POST['reflechi'])) ? $_POST['reflechi'] : "off";
                $skills['responsable']['refValue'] = (isset($_POST['responsable'])) ? $_POST['responsable'] : "off";
                $skills['sociable']['refValue'] = (isset($_POST['sociable'])) ? $_POST['sociable'] : "off";
                $skills['optimiste']['refValue'] = (isset($_POST['optimiste'])) ? $_POST['optimiste'] : "off";

                // Mise à jour des noms des compétences
                $skills['autonome']['name'] = "Autonome";
                $skills['analyse']['name'] = "Capable d'analyse et de synthèse";
                $skills['ecoute']['name'] = "À l'écoute";
                $skills['organise']['name'] = "Organisé";
                $skills['passionne']['name'] = "Passionné";
                $skills['fiable']['name'] = "Fiable";
                $skills['patient']['name'] = "Patient";
                $skills['reflechi']['name'] = "Réfléchi";
                $skills['responsable']['name'] = "Responsable";
                $skills['sociable']['name'] = "Sociable";
                $skills['optimiste']['name'] = "Optimiste";

                // Création d'un tableau des compétences mises à jour
                $userSkills = [
                    'autonome' => $skills['autonome'],
                    'analyse' => $skills['analyse'],
                    'ecoute' => $skills['ecoute'],
                    'organise' => $skills['organise'],
                    'passionne' => $skills['passionne'],
                    'fiable' => $skills['fiable'],
                    'patient' => $skills['patient'],
                    'reflechi' => $skills['reflechi'],
                    'responsable' => $skills['responsable'],
                    'sociable' => $skills['sociable'],
                    'optimiste' => $skills['optimiste'],
                ];

                // Mise à jour des données de la référence
                $reference['skills'] = $userSkills;
                $reference['verif'] = '1';
                $reference['refComment'] = $refComment;
                $reference['lastname'] = $refLastname;
                $reference['firstname'] = $refFirstname;
                $reference['birth'] = $refBirth;
                $reference['tel'] = $refTel;

                // Mise à jour des données utilisateur
                $userData['references'][$stockedHash] = $reference;

                // Remplacement du caractère @ dans l'adresse e-mail par un tiret bas (_)
                $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
                $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

                // Réécrire le fichier avec les données mises à jour
                file_put_contents($userJsonPath, json_encode($userData));

                // Envoyer un mail de confirmation à la référence
                $receiver = $reference["email"];
                $subject = "Confirmation référence traitée";
                $body = "Cher " . $reference["firstname"] . ",\n\n";
                $body .= "Vous venez de valider la demande de référence de " . $userData['firstname'] . " " . $userData['lastname'] . ", et nous vous remercions.\n\n";
                $body .= "Cordialement,\nL'équipe Jeunes 64";
                $sender = "From: Jeunes 6.4";

                mail($receiver, $subject, $body, $sender);
                break;
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
                                <h1 class="xl-title referent">Référent</h1>
                                <h2 class="slogan">Je confirme la valeur de ton engagement</h2>
                        </div>
                    </div>
                    <nav class="header-nav">
                        <ul class="nav-list">
                            <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                            <li class="nav-item referent active"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                            <li class="nav-item consultant"><a class="nav-link" href="search_user.php">Consultant</a></li>
                            <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                        </ul>
                    </nav>
                </div>
        </header>

            <div class="medium-container">
                <div class='alert alert-success alert-white rounded text-center'>
                    <div class='icon'><i class='fa fa-check'></i></div>
                    Les données saisies ont bien été prises en compte. Merci pour votre constribution !
                </div>
                <p class="text text-center"><a href="verif_hash.php" class="link">Retour au module «Référent»</a></p>
            </div>
    </body>
</html>
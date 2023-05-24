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

    $message = "";

    // Obtenir les données de l'utilisateur à partir du fichier JSON
    $userData = json_decode(file_get_contents($users[$email]), true);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Définir le nombre maximum de cases cochées permises
        $maxChecked = 4;

        // Vérifier le nombre de cases cochées
        $checkedCount = 0;
        $savoirsEtre = array("autonome", "analyse", "ecoute", "organise", "passionne", "fiable", "patient", "reflechi", "responsable", "sociable", "optimiste");
        foreach ($savoirsEtre as $savoir) {
            if (isset($_POST[$savoir]) && $_POST[$savoir] == "on") {
                $checkedCount++;
            }
        }

        // Vérifier si le nombre de cases cochées dépasse la limite
        if ($checkedCount > $maxChecked) {
            $message = "Vous ne pouvez sélectionner que 4 options au maximum.";
        } else {

            // Le nombre de cases cochées est valide, continuer le traitement du formulaire...

            // Récupérer les autres valeurs du formulaire
            $referentLastname = $_POST["referent-lastname"];
            $referentFirstname = $_POST["referent-firstname"];

            // Récupération des données du formulaire
            $refLastname = $_POST['referent-lastname'];
            $refFirstname = $_POST['referent-firstname'];
            $refBirth = $_POST['referent-birth'];
            $refEmail = $_POST['referent-email'];
            $refTel = $_POST['referent-tel'];
            $commitmentType = $_POST['commitment-type'];
            $description = $_POST['description'];
            $period = $_POST['period'];

            // Définition des compétences et de leurs noms
            $skills = ['autonome', 'analyse', 'ecoute', 'organise', 'passionne', 'fiable', 'patient', 'reflechi', 'responsable', 'sociable', 'optimiste'];
            $nameSkills = ['Autonome', 'Capable d\'analyse et de synthèse', 'À l\'écoute', 'Organisé', 'Passionné', 'Fiable', 'Patient', 'Réfléchi', 'Responsable', 'Sociable', 'Optimiste'];

            // Parcours des compétences pour récupérer les valeurs du formulaire
            foreach ($skills as $index => $skill) {
                $value = isset($_POST[$skill]) ? $_POST[$skill] : "off";
                $name = $nameSkills[$index];
                $userSkills[$skill] = ['value' => $value, 'name' => $name];
            }

            // Création de la nouvelle référence
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

            // Génération du hash pour la référence
            $newRefHash = substr(hash('sha256', json_encode($newReference)), 0, 12);
            $userJsonFile = str_replace("@", "_", $email) . '.json';
            $userJsonPath = 'data/' . $userJsonFile;

            // Ajout de la nouvelle référence aux données de l'utilisateur
            $userData['references'][$newRefHash] = $newReference;

            // Enregistrement des données de l'utilisateur mises à jour dans le fichier JSON
            file_put_contents($userJsonPath, json_encode($userData));

            // Construction de l'URL de la page de consultation de la référence
            $consultPageURL = 'http';
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $consultPageURL .= 's';
            }
            $consultPageURL .= '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/valid_ref.php?hash=' . password_hash($newRefHash, PASSWORD_DEFAULT);

            // Envoi de l'email de validation à l'adresse du référent
            $receiver = $refEmail;
            $subject = "Demande de référence de " . $userData['firstname'] . " " . $userData['lastname'];
            $body = "Cher " . $newReference["firstname"] . ",\n\n";
            $body .= "Le jeune " . $userData['firstname'] . " " . $userData['lastname'] . " a utilisé notre site et vous a désigné comme référent. ";
            $body .= "Pour valider sa référence, il vous suffit de cliquer sur le lien suivant ou de saisir le code de validation :\n\n";
            $body .= "Lien de validation : " . $consultPageURL . "\n";
            $body .= "Code de validation : " . $newRefHash . "\n\n";
            $body .= "Cordialement,\nL'équipe Jeunes 64";
            $sender = "From: melvinhqb@gmail.com";

            // Envoi de l'email
            if (mail($receiver, $subject, $body, $sender)) {
                echo "Email sent successfully to $receiver";
            } else {
                echo "Sorry, failed while sending mail!";
            }

            // Redirection vers la page des références
            header("Location: references.php");
            exit();
        }
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
            <p class="text"><?php echo $message;?></p>
            <form action="new_ref.php" method="post">
                <h2 class="subtitle">Coordonnées du référent</h2>
                <div class="input-group">
                    <label for="referent-lastname">Nom</label>
                    <input type="text" id="referent-lastname" name="referent-lastname" required value="<?php echo isset($_POST['referent-lastname']) ? $_POST['referent-lastname'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="referent-firstname">Prénom</label>
                    <input type="text" id="referent-firstname" name="referent-firstname" required value="<?php echo isset($_POST['referent-firstname']) ? $_POST['referent-firstname'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="referent-birth">Date de naissance</label>
                    <input type="date" id="referent-birth" name="referent-birth" required value="<?php echo isset($_POST['referent-birth']) ? $_POST['referent-birth'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="referent-email">Email</label>
                    <input type="email" id="referent-email" name="referent-email" required value="<?php echo isset($_POST['referent-email']) ? $_POST['referent-email'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="referent-email">Téléphone</label>
                    <input type="tel" id="referent-tel" name="referent-tel" pattern="0[1-9](\d{2}){4}" required value="<?php echo isset($_POST['referent-tel']) ? $_POST['referent-tel'] : ''; ?>">
                </div>
                <h2 class="subtitle">Mon engagement</h2>
                <div class="input-group">
                    <label for="commitment-type">Milieu de l'engagement</label>
                    <input type="text" id="commitment-type" name="commitment-type" required value="<?php echo isset($_POST['commitment-type']) ? $_POST['commitment-type'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="period">Durée (en mois)</label>
                    <input type="number" id="period" name="period" min=1 required value="<?php echo isset($_POST['period']) ? $_POST['period'] : ''; ?>">
                </div>
                <div class="input-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="10" require><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
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

<script>
    // Sélectionner toutes les cases à cocher
    const checkboxes = document.querySelectorAll('.checkbox-group input[type="checkbox"]');
    let checkedCount = 0;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                checkedCount++;
                if (checkedCount > 6) {
                    checkbox.checked = false; // Désélectionner la case cochée supplémentaire
                    checkedCount--; // Décrémenter le compteur
                }
            } else {
                checkedCount--;
            }
        });
    });
</script>
</html>
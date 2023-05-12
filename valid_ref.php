<?php

    session_start();

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

        $userData = json_decode(file_get_contents($users[$email]), true);

        foreach ($userData['references'] as $stockedHash => $reference) {
            if ($stockedHash == $hash) {
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

                $reference['skills'] = $userSkills;
                $reference['verif'] = '1';
                $reference['refComment'] = $refComment;


                $userData['references'][$stockedHash] = $reference;

                  // Remplacement du caractère @ dans l'adresse e-mail par un tiret bas (_)
                  $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
                  $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

                // Réécrire le fichier avec les données mises à jour
                file_put_contents($userJsonPath, json_encode($userData));
                header("Location: verif_hash.php");

            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
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
                    <div class="header-slogan">
                        <h2 class="slogan">Pour faire de l'engagement une valeur</h2>
                    </div>
                </div>
            </div>
            <nav class="header-nav">
                <ul class="nav-list">
                    <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent active"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="referent">
        <div class="small-container">
            <form action="valid_ref.php" method="post">
                <?php
                    if (!isset($_GET['hash'])) {
                        header("Location: verif_hash.php");
                        exit();
                    }
                    
                    $hash = $_GET['hash'];

                    $file = 'users.json';
                    $data = file_get_contents($file);
                    $users = json_decode($data, true);

                    foreach ($users as $email => $path) {

                        $userData = json_decode(file_get_contents($users[$email]), true);

                        foreach ($userData['references'] as $stockedHash => $reference) {
                            if (password_verify($stockedHash, $hash)) {
                                if ($reference['verif'] == 1) {
                                    header("Location: verif_hash.php");
                                    exit();
                                }
                                echo "<h1 class='main-title'>Bonjour ". $reference['firstname'] . " " . $reference['lastname'] ." !</h1>";
                                echo "<h2 class='subtitle'>Informations Jeune</h2>";
                                echo "<div class='input-group' style='display: none'><label>ID formulaire</label><input type='text' name='hash' value='" . $stockedHash . "' id='hash' readonly></div>";
                                echo "<div class='input-group'><label>Nom</label><input type='text' value='" . $userData['lastname'] . "' readonly></div>";
                                echo "<div class='input-group'><label>Prénom</label><input type='text' value='" . $userData['firstname'] . "' readonly></div>";
                                echo "<div class='input-group'><label>Date de naissance</label><input type='date' value='" . $userData['birth'] . "' readonly></div>";
                                echo "<div class='input-group'><label>Email</label><input type='email' name='email' value='" . $userData['email'] . "' readonly></div>";
                                echo "<div class='input-group'><label>Durée</label><input type='number' value='" . $reference['period'] . "' readonly></div>";
                                echo "<div class='input-group'><label for='description'>Description</label><textarea name='description' id='description' rows='10' readonly>" . $reference['description'] . "</textarea></div>";
                                echo "<h2 class='subtitle'>Votre avis sur ce jeune</h2>";
                                echo "<div class='checkbox-list'>";
                                foreach ($reference['skills'] as $key => $skill) {
                                    if ($skill['value'] == "on") {
                                        echo "<div class='checkbox-group'><input type='checkbox' name='".$key."' checked><label for='".$key."'>".$skill['name']."</label></div>";
                                    }
                                    else {
                                        echo "<div class='checkbox-group'><input type='checkbox' name='".$key."'><label for='".$key."'>".$skill['name']."</label></div>";
                                    }
                                }
                                echo "</div>";
                                echo "<div class='input-group'><label for='refComment'>Commentaire</label><textarea name='refComment' id='comment' rows='10'></textarea></div>";
                                echo "<div class='center'><button type='submit' class='btn'>Envoyer</button></div>";
                                exit();
                            }
                        }
                    }
                    header("Location: verif_hash.php");
                    exit();
                ?>
            </form>
        </div>
    </section>
</body>
</html>
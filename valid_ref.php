<?php
    session_start();

    if (isset($_SESSION['email'])) {
        $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
    } else {
        $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
    }

    $hash = "";
    if (isset($_GET['hash'])) {
        $hash = $_GET['hash'];
        $file = 'users.json';
        $data = file_get_contents($file);
        $users = json_decode($data, true);
    } else {
        header("Location: verif_hash.php");
        exit();
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

        <section class="referent">
            <div class="small-container">
                <form action="thank.php" method="post">
                    <?php

                        foreach ($users as $email => $path) {

                            $userData = json_decode(file_get_contents($users[$email]), true);
                            
                            if (isset($userData['references']) && !empty($userData['references'])) {
                                foreach ($userData['references'] as $stockedHash => $reference) {
                                    if (password_verify($stockedHash, $hash)) {
                                        if ($reference['verif'] == 1) {
                                            header("Location: verif_hash.php");
                                            exit();
                                        }
                                        echo "<h1 class='main-title'>Bonjour ". htmlspecialchars($reference['firstname'], ENT_QUOTES) . " " . htmlspecialchars($reference['lastname'], ENT_QUOTES) ." !</h1>";
                                        echo "<h2 class='subtitle'>Informations Jeune</h2>";
                                        echo "<div class='input-group' style='display: none'><label>ID formulaire</label><input type='text' name='hash' value='" . $stockedHash . "' id='hash' readonly></div>";
                                        echo "<div class='input-group'><label>Nom</label><input type='text' value='" . htmlspecialchars($userData['lastname'], ENT_QUOTES) . "' readonly></div>";
                                        echo "<div class='input-group'><label>Prénom</label><input type='text' value='" . htmlspecialchars($userData['firstname'], ENT_QUOTES) . "' readonly></div>";
                                        echo "<div class='input-group'><label>Date de naissance</label><input type='date' value='" . $userData['birth'] . "' readonly></div>";
                                        echo "<div class='input-group'><label>Email</label><input type='email' name='email' value='" . $userData['email'] . "' readonly></div>";
                                        echo "<div class='input-group'><label>Milieu de l'engagement</label><input type='text' value='" . htmlspecialchars($reference['commitment-type'], ENT_QUOTES) . "' readonly></div>";
                                        echo "<div class='input-group'><label>Durée</label><input type='number' value='" . $reference['period'] . "' readonly></div>";
                                        echo "<div class='input-group'><label for='description'>Description</label><textarea name='description' id='description' rows='10' readonly>" . htmlspecialchars($reference['description'], ENT_QUOTES) . "</textarea></div>";
                                        echo "<h2 class='subtitle'>Vos informations personelles</h2>";
                                        echo '<div class="input-group"><label for="referent-lastname">Nom</label><input type="text" id="referent-lastname" name="referent-lastname" value="' . htmlspecialchars($reference["lastname"], ENT_QUOTES) . '" required></div>';
                                        echo '<div class="input-group"><label for="referent-firstname">Prénom</label><input type="text" id="referent-firstname" name="referent-firstname" value="' . htmlspecialchars($reference["firstname"], ENT_QUOTES) . '" required></div>';
                                        echo '<div class="input-group"><label for="referent-birth">Date de naissance</label><input type="date" id="referent-birth" name="referent-birth" value="' . $reference["birth"] . '" required></div>';
                                        echo '<div class="input-group"><label for="referent-tel">Téléphone</label><input type="tel" id="register-tel" name="referent-tel" pattern="0[1-9](\d{2}){4}" value="' . $reference["tel"] . '" required></div>';
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
                        }
                        header("Location: thank.php");
                        exit();
                    ?>
                </form>
            </div>
        </section>
    </body>
</html>
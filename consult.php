<?php
    session_start();

    // Vérifie si une session avec l'email est déjà active
    if (isset($_SESSION['email'])) {
        // Si une session est active, affiche le lien de déconnexion
        $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
    } else {
        // Si aucune session n'est active, affiche les liens de connexion et d'inscription
        $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
    }

    $email = "";
    if (isset($_GET['email'])) {
        // Récupère l'email à partir des paramètres GET de l'URL
        $email = $_GET['email'];

        $file = 'users.json';
        $data = file_get_contents($file);
        $users = json_decode($data, true);

        if(isset($users[$email])) {
            // Si l'email existe dans le fichier JSON, récupère les données utilisateur
            $userData = json_decode(file_get_contents($users[$email]), true);
        } else {
            // Si l'email n'existe pas dans le fichier JSON, redirige vers la page de recherche d'utilisateur
            header("Location: search_user.php");
            exit();
        }
    } else {
        // Si aucun email n'est spécifié dans les paramètres GET de l'URL, redirige vers la page de recherche d'utilisateur
        header("Location: search_user.php");
        exit();
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
                <!-- Affichage du message de connexion ou de déconnexion -->
                <?php echo $message; ?>
            </div>
            <div class="header-body">
                <div class="header-logo">
                    <!-- Logo du site -->
                    <a href="home.php"><img src="assets/logo1.png" alt="Logo Jeunes 6.4"></a>
                </div>
                <div class="header-text">
                    <!-- Titre principal de la page pour les consultants -->
                    <h1 class="xl-title consultant">Consultant</h1>
                    <!-- Slogan pour les consultants -->
                    <h2 class="slogan">Je donne de la valeur à ton engagement</h2>
                </div>
            </div>
            <nav class="header-nav">
                <!-- Liste des liens de navigation -->
                <ul class="nav-list">
                    <li class="nav-item young"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                    <!-- Lien actif pour les consultants -->
                    <li class="nav-item consultant active"><a class="nav-link" href="search_user.php">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section class="consultant">
    <div class="medium-container">
        <h1 class="main-title">Profil de <?php echo $userData["firstname"]." ".$userData["lastname"];?></h1>
        <h2 class="subtitle">Informations personnelles</h2>
        <div class="ref-info young">
            <p><i class="fa-solid fa-cake-candles color-icn"></i> <?php echo date("d M Y", strtotime($userData['birth'])); ?></p>
            <p><i class="fa-solid fa-at color-icn"></i> <?php echo $userData['email']; ?></p>
            <p><i class="fa-solid fa-phone color-icn"></i> <?php echo $userData['tel']; ?></p>
        </div>
        <h2 class="subtitle">Références validées</h2>

        <?php
            // Vérifier si des références existent et ne sont pas vides
            if(isset($userData['references']) && !empty($userData['references'])) {
                $references = array_reverse($userData['references']);

                $count = 0;
                foreach ($references as $ref) {
                    if ($ref['verif'] == 1) {
                        $count = 1;
                        break;
                    }
                }

                // Afficher un message si aucune référence validée n'est disponible
                if ($count == 0) {
                    ?>
                        <div class='alert alert-info alert-white rounded'>
                            <div class='icon'><i class='fa fa-info-circle'></i></div>
                            Pas de références validées
                        </div>
                    <?php
                }

                foreach ($references as $key => $reference) {
                    // Récupérer la valeur de 'verif'
                    $verif = $reference['verif'];
                    $refBirth = $reference['birth'];
                    $refBirth_formattee = date("d M Y", strtotime($refBirth));

                    if($verif == 1) {
                        ?>
                        <div class="box green">
                            <div class="reference-status">
                                <div class="reference-header">
                                    <h3>Demande de référence à <?php echo $reference['firstname'].' '.$reference['lastname']; ?></h3>
                                    <div class="reference-info">
                                        <p class="legend">Engagement : <?php echo $reference['commitment-type']; ?></p>
                                        <p class="legend">Durée : <?php echo $reference["period"]; ?> mois</p>
                                    </div>
                                </div>
                                <span><i class="fa-solid fa-circle-check color-icn green"></i></span>
                            </div>
                            <div class="two-columns">
                                <div class="young-col column">
                                    <p><?php echo $reference["description"]; ?></p>
                                </div>
                                <div class="column referent">
                                    <h4>Informations référent</h4>
                                    <div class="ref-info">
                                        <span><i class="fa-solid fa-cake-candles color-icn"></i> <?php echo $refBirth_formattee; ?></span>
                                        <span><i class="fa-solid fa-at color-icn"></i> <?php echo $reference["email"]; ?></span>
                                        <span><i class="fa-solid fa-phone color-icn"></i> <?php echo $reference["tel"]; ?></span>
                                    </div>
                                    <span></span>
                                </div>
                            </div>
                            <div class="two-columns">
                                <div class="column young">
                                    <h4>Je suis...</h4>
                                    <div class="inline-skills">
                                        <?php
                                        foreach ($reference['skills'] as $skill) {
                                            if($skill["value"] == "on") {
                                                ?>
                                                <div class="pill"><span><?php echo $skill["name"]; ?></span></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="column referent">
                                    <h4>Je confirme qu'il (elle) est...</h4>
                                    <div class="inline-skills">
                                        <?php
                                        foreach ($reference['skills'] as $skill) {
                                            if($skill["refValue"] == "on") {
                                                ?>
                                                <div class="pill"><span><?php echo $skill["name"]; ?></span></div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h4>Commentaire du référent</h4>
                                <p class="box-text"><?php echo $reference['refComment']; ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                ?>
                    <div class='alert alert-info alert-white rounded'>
                            <div class='icon'><i class='fa fa-info-circle'></i></div>
                            Pas de références validées
                    </div>
                <?php
            }
        ?>
    </div>   
</section>
</body>
</html>
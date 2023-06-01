<?php
    session_start();

    // Vérifie si une session avec l'email est déjà active
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
                                ?>
                                <h1 class="main-title">Bonjour <?php echo $reference['firstname'] . " " . $reference['lastname']; ?> !</h1>
                                <h2 class="subtitle">Informations Jeune</h2>
                                <div class="input-group" style="display: none;">
                                    <label for="lastname">Nom</label>
                                    <input type="text" name="hash" value="<?php echo $stockedHash; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="lastname">Nom</label>
                                    <input type="text" value="<?php echo $userData['lastname']; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="firstname">Prénom</label>
                                    <input type="text" value="<?php echo $userData['firstname']; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="birth">Date de naissance</label>
                                    <input type="date" value="<?php echo $userData['birth']; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" value="<?php echo $userData['email']; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="commitment-type">Milieu de l'engagement</label>
                                    <input type="text" value="<?php echo $reference['commitment-type']; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="period">Durée</label>
                                    <input type="number" value="<?php echo $reference['period']; ?>" readonly>
                                </div>
                                <div class="input-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" rows="10" readonly><?php echo $reference['description']; ?></textarea>
                                </div>
                                <h2 class="subtitle">Vos informations personnelles</h2>
                                <div class="input-group">
                                    <label for="referent-lastname">Nom</label>
                                    <input type="text" id="referent-lastname" name="referent-lastname" value="<?php echo $reference['lastname']; ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="referent-firstname">Prénom</label>
                                    <input type="text" id="referent-firstname" name="referent-firstname" value="<?php echo $reference['firstname']; ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="referent-birth">Date de naissance</label>
                                    <input type="date" id="referent-birth" name="referent-birth" value="<?php echo $reference['birth']; ?>" required>
                                </div>
                                <div class="input-group">
                                    <label for="referent-tel">Téléphone</label>
                                    <input type="tel" id="referent-tel" name="referent-tel" pattern="0[1-9](\d{2}){4}" value="<?php echo $reference['tel']; ?>" required>
                                </div>
                                <h2 class="subtitle">Votre avis sur ce jeune</h2>
                                <div class="checkbox-list">
                                    <?php
                                    foreach ($reference['skills'] as $key => $skill) {
                                        if ($skill['value'] == "on") {
                                            ?>
                                            <div class="checkbox-group">
                                                <input type="checkbox" name="<?php echo $key; ?>" checked>
                                                <label for="<?php echo $key; ?>"><?php echo $skill['name']; ?></label>
                                            </div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="checkbox-group">
                                                <input type="checkbox" name="<?php echo $key; ?>">
                                                <label for="<?php echo $key; ?>"><?php echo $skill['name']; ?></label>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="input-group">
                                    <label for="refComment">Commentaire</label>
                                    <textarea name="refComment" id="comment" rows="10"></textarea>
                                </div>
                                <div class="center">
                                    <button type="submit" class="btn">Envoyer</button>
                                </div>
                                <?php
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
    <script>
        // Sélectionner toutes les cases à cocher
        const checkboxes = document.querySelectorAll('.checkbox-group input[type="checkbox"]');
        let checkedCount = 0;

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => {
                if (checkbox.checked) {
                    checkedCount++;
                    if (checkedCount > 4) {
                        checkbox.checked = false; // Désélectionner la case cochée supplémentaire
                        checkedCount--; // Décrémenter le compteur
                    }
                } else {
                    checkedCount--;
                }
            });
        });
    </script>
</body>
</html>
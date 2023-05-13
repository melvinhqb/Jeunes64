<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        exit();
    }

    $email = $_SESSION['email']; // Récupérer les informations de l'utilisateur courant
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    $userData = json_decode(file_get_contents($users[$email]), true);

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mise à jour des informations de l'utilisateur
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $birth = $_POST['birth'];
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];
        if (!empty($current_password) && !empty($new_password)) {
            if (password_verify($current_password, $userData["password"])) {
                $userData["password"] = password_hash($new_password, PASSWORD_DEFAULT);
                $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
                $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

                $userData["lastname"] = $lastname;
                $userData["firstname"] = $firstname;
                $userData["birth"] = $birth;
                
                file_put_contents($userJsonPath, json_encode($userData)); // Enregistre les données de l'utilisateur dans le fichier JSON correspondant
                $_SESSION['email'] = $email;
                header("Location: profil.php");
                //$message = "Vos informations ont été mis à jour.";
            } else {
                $message = "Le mot de passe actuel est incorrect.";
            }
        } else {
            $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
            $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur
    
            $userData["lastname"] = $lastname;
            $userData["firstname"] = $firstname;
            $userData["birth"] = $birth;
            
            file_put_contents($userJsonPath, json_encode($userData)); // Enregistre les données de l'utilisateur dans le fichier JSON correspondant
            $_SESSION['email'] = $email;
            header("Location: profil.php");
            //$message = "Vos informations ont été mis à jour.";
        }
    }

?>

<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jeunes 6.4 - Modifier mon profil</title>
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
                    <li class="nav-item young active"><a class="nav-link" href="profil.php">Jeune</a></li>
                    <li class="nav-item referent"><a class="nav-link" href="verif_hash.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
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
                    <li class="subnav-item"><a class="subnav-link" href="new_ref.php">Demande de référence</a></li>
                    <li class="subnav-item active"><a class="subnav-link" href="edit_profil.php">Modifier mon profil</a></li>
                    <li class="subnav-item"><a class="subnav-link" href="my_cv.php">Mon CV</a></li>
                </ul>
            </div>
        </div>
        <div class="small-container">
            <h1 class="main-title">
                Modifier mes informations personelles
            </h1>
            <p class="text"><?php echo $message;?></p>
            <form action="edit_profil.php" method="post">
                <div class="input-group">
                    <label for="lastname">Nom</label>
                    <input type="text" name="lastname" value="<?php echo $userData['lastname']; ?>" required><br>
                </div>
                <div class="input-group">
                    <label for="firstname">Prénom</label>
                    <input type="text" name="firstname" value="<?php echo $userData['firstname']; ?>" required><br>
                </div>
                <div class="input-group">
                    <label for="birth">Date de naissance</label>
                    <input type="date" name="birth" value="<?php echo $userData['birth']; ?>" required><br>
                </div>
                <div class="input-group">
                    <label for="current-password">Mot de passe actuel</label>
                    <input type="password", name="current-password">
                </div>
                <div class="input-group">
                    <label for="new-password">Nouveau mot de passe</label>
                    <input type="password", name="new-password">
                </div>
                <div class="center">
                        <button type="submit" class="btn">Mettre à jour</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
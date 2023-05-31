<?php
    session_start();

    // Vérifier si l'email de l'utilisateur est défini dans la session
    if (!isset($_SESSION['email'])) {
        // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        header("Location: login.php");
        exit();
    }

    // Récupérer les informations de l'utilisateur courant
    $email_session = $_SESSION['email'];
    $file = 'users.json';
    $data = file_get_contents($file);
    $users = json_decode($data, true);
    $userData = json_decode(file_get_contents($users[$email_session]), true);

    $message = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Mise à jour des informations de l'utilisateur
        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $birth = $_POST['birth'];
        $email = $_POST['email'];
        $tel = $_POST['tel'];
        $current_password = $_POST['current-password'];
        $new_password = $_POST['new-password'];

        // Vérifie si le nouveau mail n'est pas déjà associé à un compte
        if (($email != $email_session) && (array_key_exists($email, $users))) {
            $message = "<div class='alert alert-warning alert-white rounded'>
                            <div class='icon'><i class='fa fa-warning'></i></div>
                            <strong>Attention !</strong> Cet e-mail est déjà associé à un compte.
                        </div>";

        } else if ((empty($current_password) && !empty($new_password)) || (!empty($current_password) && empty($new_password))) {
            $message = "<div class='alert alert-warning alert-white rounded'>
                            <div class='icon'><i class='fa fa-warning'></i></div>
                            <strong>Attention !</strong> Le changement de mot de passe requiert le mot de passe actuel ainsi que le nouveau.
                        </div>";

        } else if (!empty($current_password) && !empty($new_password)) {
            // Vérification du mot de passe actuel
            if($current_password != $new_password) {
                if (password_verify($current_password, $userData["password"])) {
                    $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
                    $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

                    // Mise à jour des autres informations de l'utilisateur
                    $userData["lastname"] = $lastname;
                    $userData["firstname"] = $firstname;
                    $userData["birth"] = $birth;
                    $userData["email"] = $email;
                    $userData["password"] = password_hash($new_password, PASSWORD_DEFAULT);
                    $userData["tel"] = $tel;

                    // Supprime le fichier utilisateur associé à l'ancien e-mail
                    unlink('data/' . str_replace("@", "_", $email_session) . '.json');

                    file_put_contents($userJsonPath, json_encode($userData)); // Enregistre les données de l'utilisateur dans le fichier JSON 

                    // Mise à jour des informations de session
                    $_SESSION["lastname"] = $lastname;
                    $_SESSION["firstname"] = $firstname;
                    $_SESSION["birth"] = $birth;
                    $_SESSION["email"] = $email;
                    $_SESSION["password"] = $new_password;
                    $_SESSION["tel"] = $tel;

                    // Supprime la paire clé-valeur de l'ancien e-mail dans le fichier 'users.json'
                    unset($users[$email_session]);

                    $users[$email] = 'data/' . str_replace("@", "_", $email) . '.json';

                    file_put_contents('users.json', json_encode($users));

                    $_SESSION['changes_confirmed'] = true;

                    header("Location: profil.php");
                } else {
                    $message = "<div class='alert alert-warning alert-white rounded'>
                                    <div class='icon'><i class='fa fa-warning'></i></div>
                                    <strong>Attention !</strong> Le mot de passe actuel est incorrect.
                                </div>";
                }
            } else {
                $message = "<div class='alert alert-warning alert-white rounded'>
                                <div class='icon'><i class='fa fa-warning'></i></div>
                                <strong>Attention !</strong> Le nouveau mot de passe doit être différent de l'ancien.
                            </div>";
            }
        } else {          
            $userJsonFile = str_replace("@", "_", $email) . '.json'; // Nom du fichier JSON pour l'utilisateur
            $userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur

            // Mise à jour des informations de l'utilisateur
            $userData["lastname"] = $lastname;
            $userData["firstname"] = $firstname;
            $userData["birth"] = $birth;
            $userData["email"] = $email;
            $userData["tel"] = $tel;

            // Supprime le fichier utilisateur associé à l'ancien e-mail
            unlink('data/' . str_replace("@", "_", $email_session) . '.json');                

            file_put_contents($userJsonPath, json_encode($userData)); // Enregistre les données de l'utilisateur dans le fichier JSON correspondant

            // Mise à jour des informations de session
            $_SESSION["lastname"] = $lastname;
            $_SESSION["firstname"] = $firstname;
            $_SESSION["birth"] = $birth;
            $_SESSION["email"] = $email;
            $_SESSION["tel"] = $tel;

            // Supprime la paire clé-valeur de l'ancien e-mail dans le fichier 'users.json'
            unset($users[$email_session]);

            $users[$email] = 'data/' . str_replace("@", "_", $email) . '.json';

            // Écrire le JSON dans le fichier
            file_put_contents('users.json', json_encode($users));

            $_SESSION['changes_confirmed'] = true;

            header("Location: profil.php");
        }
    }
?>

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
            <div class="background-img">
                <img src="assets/bg-jeunes.png" alt="">
            </div>
            <div class="subnav">
                <div class="medium-container">
                    <ul class="subnav-list">
                        <li class="subnav-item active"><a class="subnav-link" href="profil.php">Mon profil</a></li>
                        <li class="subnav-item"><a class="subnav-link" href="references.php">Demande de référence</a></li>
                        <li class="subnav-item"><a class="subnav-link" href="create_cv.php">Mon CV</a></li>
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
                        <input type="text" name="lastname" value="<?php echo $userData['lastname']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="firstname">Prénom</label>
                        <input type="text" name="firstname" value="<?php echo $userData['firstname']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="birth">Date de naissance</label>
                        <input type="date" name="birth" value="<?php echo $userData['birth']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" value="<?php echo $userData['email']; ?>" required>
                    </div>
                    <div class="input-group">
                        <label for="tel">Téléphone</label>
                        <input type="tel" id="register-tel" name="tel" pattern="0[1-9](\d{2}){4}" value="<?php echo $userData['tel']; ?>" required>
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
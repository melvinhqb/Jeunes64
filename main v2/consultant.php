<?php
session_start();

if (isset($_SESSION['email'])) {
    $message = '<a href="logout.php" class="link" id="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a>';
} else {
    $message = '<a href="login.php" class="link" id="login-btn">Se connecter</a><a href="register.php" class="link" id="register-btn">S\'inscrire</a>';
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
                    <li class="nav-item referent"><a class="nav-link" href="referants.php">Référent</a></li>
                    <li class="nav-item consultant"><a class="nav-link" href="consultant.php">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
    <?php

// Ouvrir le répertoire
$dir = opendir('data/');

// Parcourir tous les fichiers dans le répertoire
while (false !== ($file = readdir($dir))) {
    // Vérifier si le fichier est un fichier .json
    if (strpos($file, '.json') !== false) {
        // Construire le chemin complet du fichier
        $file_path = 'data/' . $file;

        // Lire le contenu du fichier
        $json_data = file_get_contents($file_path);

        // Décoder le contenu du fichier JSON en un tableau associatif
        $user_data = json_decode($json_data, true);

        // Parcourir chaque élément dans le tableau
        foreach ($user_data as $key => $response) {
            // Vérifier si la clé est un nombre (pour ignorer les éléments qui ne sont pas des réponses)
            if (is_numeric($key)) {
                // Vérifier si la propriété 'verif' de la réponse est égale à 1
                if (isset($response['verif']) && $response['verif'] == 1) {
                    // Afficher la réponse
                    echo "Response from " . $file . ":<br>\n";
                    foreach ($response as $field => $value) {
                        echo $field . ": " . $value . "<br>\n";
                    }
                    echo "<br>\n";
                }
            }
        }
    }
}

// Fermer le répertoire
closedir($dir);
?>



       
    </main>
    
</body>
</html>
<?php
$directory = "./data";
$hash = (isset($_POST['hash'])) ? $_POST['hash'] : 0;
$response = findResponseByHash($directory, $hash);
if ($response == null) { 
    header("Location: referants.php"); 
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
                    <li class="nav-item consultant"><a class="nav-link" href="">Consultant</a></li>
                    <li class="nav-item partner"><a class="nav-link" href="partners.php">Partenaires</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <?php

function findResponseByHash($directory, $targetHash) {
    // Ouvrez le répertoire
    if ($handle = opendir($directory)) {
        // Parcourez tous les fichiers du répertoire
        while (false !== ($entry = readdir($handle))) {
            // Si le fichier est un fichier JSON
            if (strpos($entry, '.json') !== false) {
                // Lire le contenu du fichier JSON
                $jsonData = file_get_contents($directory . '/' . $entry);
                $user = json_decode($jsonData, true);

                // Parcourez chaque réponse dans le fichier JSON
                foreach ($user as $key => $response) {
                    // Vérifier si la clé est numérique, ce qui signifie que c'est une réponse
                    if (is_numeric($key)) {
                        // Si le hash de la réponse correspond au hash cible
                        if ($response['hash'] === $targetHash) {
                            // Fermez le répertoire
                            closedir($handle);
                            // Retournez la réponse correspondante
                            return $response;
                        }
                    }
                }
            }
        }
        // Fermez le répertoire
        closedir($handle);
    }

    // Si aucune réponse correspondante n'a été trouvée, retournez null
    return null;
}

function findResponseByHashPrintable($directory,$hash) {

    if ($handle = opendir($directory)) {
        while (false !== ($entry = readdir($handle))) {
            if (strpos($entry, '.json') !== false) {
                $jsonData = file_get_contents($directory . '/' . $entry);
                $user = json_decode($jsonData, true);

                foreach ($user as $key => $response) {
                    if (is_numeric($key)) {
                        if ($response['hash'] === $hash) { 
                            echo 'Name: ' . $response['name'] . "<br>\n";
                            echo 'Forname: ' . $response['forname'] . "<br>\n";
                            echo 'Mail Reference: ' . $response['mail_ref'] . "<br>\n";
                            echo 'Social: ' . $response['social'] . "<br>\n";
                            echo 'Engagement: ' . $response['engagement'] . "<br>\n";
                            echo 'Duration: ' . $response['duree'] . "<br>\n";
                            echo "<br>\n";
                            echo 'Autonome: ' . $response['Autonome'] . "<br>\n";
                            echo "Capable d'anlyse et de sinthèse: " . $response['CapableAnalyse'] . "<br>\n";
                            echo "A l'écoute: " . $response['ALEcoute'] . "<br>\n";
                            echo 'Organisé: ' . $response['Organisé'] . "<br>\n";
                            echo 'Passionné: ' . $response['Passionné'] . "<br>\n";
                            echo 'Fiable: ' . $response['Fiable'] . "<br>\n";
                            echo 'Patient: ' . $response['Patient'] . "<br>\n";
                            echo 'Réfléchi: ' . $response['Réfléchi'] . "<br>\n";
                            echo 'Responsable: ' . $response['Responsable'] . "<br>\n";
                            echo 'Sociable: ' . $response['Sociable'] . "<br>\n";
                            echo 'Optimiste: ' . $response['Optimiste'] . "<br>\n";
                            
                            return;
                        }
                    }
                }
            }
        }
        closedir($handle);
    }
}


$directory = "./data";
$hash = (isset($_POST['hash'])) ? $_POST['hash'] : 0;
;
findResponseByHashPrintable($directory, $hash);  
?>

<form method="POST" action="validation_ref.php">
    <input type="hidden" name="hash" value="<?echo $hash;?>" />
    <input type="submit" value="Modifier Verif" />
</form>

        
</body>
</html>
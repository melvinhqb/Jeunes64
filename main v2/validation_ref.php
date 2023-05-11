<?php
// Définir le chemin du répertoire qui contient les fichiers JSON
$directory = "./data"; 

// Vérifier si la requête est de type POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer la valeur du hash envoyée par le formulaire
    $targetHash = $_POST["hash"];

    // Ouvrir le répertoire spécifié
    if ($handle = opendir($directory)) {
        // Lire chaque entrée dans le répertoire
        while (false !== ($entry = readdir($handle))) {
            // Vérifier si l'entrée est un fichier JSON
            if (strpos($entry, '.json') !== false) {
                // Lire le contenu du fichier JSON
                $jsonData = file_get_contents($directory . '/' . $entry);
                // Décoder le contenu du fichier JSON en un tableau associatif
                $user = json_decode($jsonData, true);

                // Parcourir chaque élément dans le tableau
                foreach ($user as $key => $response) {
                    // Vérifier si la clé est un nombre (pour ignorer les éléments qui ne sont pas des réponses)
                    if (is_numeric($key)) {
                        // Vérifier si le hash de la réponse correspond au hash cible
                        if ($response['hash'] === $targetHash) {
                            // Modifier la valeur de la clé 'verif' pour la réponse correspondante
                            $user[$key]['verif'] = '1';

                            // Réencoder le tableau en JSON et écrire les modifications dans le fichier
                            file_put_contents($directory . '/' . $entry, json_encode($user));
                            // Arrêter la boucle foreach et la boucle while
                            break 2;
                        }
                    }
                }
            }
        }
        // Fermer le répertoire
        closedir($handle);
    }
}

echo"le demande de ref a etait modifier";
?>

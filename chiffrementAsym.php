<?php
// Définition du mot de passe
$password = 'mypassword';

// Récupération du hash, on laisse le salt se générer automatiquement ; non recommandé
$hash = crypt($password);
echo $hash;
?>

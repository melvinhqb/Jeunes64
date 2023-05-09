<?php
if (isset($_COOKIE['user_cookie'])) {
    $cookieValue = $_COOKIE['user_cookie'];
    // Effectuez ici des vérifications supplémentaires si nécessaire
    // Par exemple, vous pouvez décomposer la valeur du cookie et vérifier si le nom d'utilisateur est valide
} else {
    header('Location: page1.html'); // Redirige les utilisateurs non connectés vers la page de connexion
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page protégée</title>
</head>
<body>
    <h1>Bienvenue sur la page protégée !</h1>
    <p>Vous êtes connecté avec succès.</p>
</body>
</html>

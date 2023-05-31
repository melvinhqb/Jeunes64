<?php
    session_start();

    if(!isset($_SESSION['user'])){
        // Rediriger vers la page d'accueil si l'utilisateur n'est pas connecté
        header("Location: home.php");
    }

    // Déconnecte la session de l'utilisateur
    unset($_SESSION['user']);
    session_destroy();

    // Rediriger vers la page d'accueil après avoir déconnecté l'utilisateur
    header("Location: home.php");
    exit();
?>

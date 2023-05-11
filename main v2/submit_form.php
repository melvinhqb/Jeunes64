<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
        exit();
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecte des informations du formulaire
    $name = $_POST['name'];
    $forname = $_POST['forname'];
    $number = $_POST['number'];
    $mail_ref = $_POST['mail_ref'];
    $social = $_POST['social'];
    $engagement = $_POST['engagement'];
    $duree = $_POST['duree'];

    $Autonome = (isset($_POST['Autonome'])) ? $_POST['Autonome'] : null;
    $CapableAnalyse = (isset($_POST['CapableAnalyse'])) ? $_POST['CapableAnalyse'] : null;
    $ALEcoute = (isset($_POST['ALEcoute'])) ? $_POST['ALEcoute'] : null;
    $Organisé = (isset($_POST['Organisé'])) ? $_POST['Organisé'] : null;
    $Passionné = (isset($_POST['Passionné'])) ? $_POST['Passionné'] : null;
    $Fiable = (isset($_POST['Fiable'])) ? $_POST['Fiable'] : null;
    $Patient = (isset($_POST['Patient'])) ? $_POST['Patient'] : null;
    $Réfléchi = (isset($_POST['Réfléchi'])) ? $_POST['Réfléchi'] : null;
    $Responsable = (isset($_POST['Responsable'])) ? $_POST['Responsable'] : null;
    $Sociable = (isset($_POST['Sociable'])) ? $_POST['Sociable'] : null;
    $Optimiste = (isset($_POST['Optimiste'])) ? $_POST['Optimiste'] : null;
    


    // Récupération de l'adresse e-mail de l'utilisateur à partir de la session
    $email = $_SESSION['email'];
    

    // Préparation des données à stocker
    $data = [
        'name' => $name,
        'forname' => $forname,
        'mail_ref' => $mail_ref,
        'social' => $social,
        'engagement' => $engagement,
        'duree' => $duree,
        'Autonome' => $Autonome,
        'CapableAnalyse' => $CapableAnalyse,
        'ALEcoute' => $ALEcoute,
        'Organisé' => $Organisé,
        'Passionné' => $Passionné,
        'Fiable' => $Fiable,
        'Patient' => $Patient,
        'Réfléchi' => $Réfléchi,
        'Responsable' => $Responsable,
        'Sociable' => $Sociable,
        'Optimiste' => $Optimiste,
        'verif' => '0',
    ];
    $dataHash = substr(hash('sha256', implode("", $data)), 0, 12);
    $data['hash'] = $dataHash;

    // Remplacement du caractère @ dans l'adresse e-mail par un tiret bas (_)
    $filename = 'data/' .$email . '.json';

    $existingData = [];

    // Vérifier si le fichier existe déjà
    if (file_exists($filename)) {
        // Charger les données existantes
        $existingData = json_decode(file_get_contents($filename), true);
    }

    // Ajouter les nouvelles données à la suite des données existantes
    $existingData[] = $data;

    // Réécrire le fichier avec les données mises à jour
    file_put_contents($filename, json_encode($existingData));

    // Redirection vers une autre page (par exemple, le tableau de bord) après l'enregistrement des données
    header("Location: profil.php");
    exit();
}
?>

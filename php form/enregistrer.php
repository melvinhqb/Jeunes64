<?php
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = isset($_POST["nom"]) ? $_POST["nom"] : "";
    $prenom = isset($_POST["prenom"]) ? $_POST["prenom"] : "";

    $donnees = array("nom" => $nom, "prenom" => $prenom);

    $json_data = json_encode($donnees, JSON_PRETTY_PRINT);
    file_put_contents("donnees.json", $json_data);

    http_response_code(200);
    echo json_encode(array("message" => "Données enregistrées avec succès."));
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>

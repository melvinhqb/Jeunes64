<?php

    header("Content-Type: application/json");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Récupérer les données du formulaire
        $name = isset($_POST["name"]) ? $_POST["name"] : "";
        $forname = isset($_POST["forname"]) ? $_POST["forname"] : "";
        $mail = isset($_POST["mail"]) ? $_POST["mail"] : "";
        $social = isset($_POST["social"]) ? $_POST["social"] : "";
        $engagement = isset($_POST["engagement"]) ? $_POST["engagement"] : "";
        $duree = isset($_POST["duree"]) ? $_POST["duree"] : "";

        // Créer un tableau associatif avec les données du formulaire
        $data = array(
            'name' => $name,
            'forname' => $forname,
            'mail' => $mail,
            'social' => $social,
            'engagement' => $engagement,
            'duree' => $duree,
            'verif' => '0'
        );

        $json_data = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents("donnees.json", $json_data);

        http_response_code(200);
        echo json_encode(array("message" => "Données enregistrées avec succès."));

    } else {
        http_response_code(405);
        echo json_encode(array("message" => "Méthode non autorisée."));

    }

?>
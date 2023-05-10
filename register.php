<?php
function caesar_cipher($string, $key) {
    $result = '';

    for ($i = 0, $len = strlen($string); $i < $len; $i++) {
        $char = $string[$i];
        $offset = ctype_upper($char) ? 65 : 97;
        if (ctype_alpha($char)) {
            $result .= chr((ord($char) - $offset + $key) % 26 + $offset);
        } else {
            $result .= $char;
        }
    }

    return $result;
}

$data = json_decode(file_get_contents('php://input'), true);
$lastname = $data['lastname'];
$firstname = $data['firstname'];
$email = $data['email'];
$password = $data['password'];

// Stocker les informations de l'utilisateur dans un fichier JSON
$usersFile = 'users.json';
$userJsonFile = $email . '.json'; // Nom du fichier JSON pour l'utilisateur
$userJsonPath = 'data/' . $userJsonFile; // Chemin d'accès au fichier JSON pour l'utilisateur
$userData = array(
    'lastname' => $lastname,
    'firstname' => $firstname,
    'email' => $email,
    'password' => $password,
    'json_path' => $userJsonPath
);

if (!file_exists('data')) {
    mkdir('data', 0777, true);
}

// Ajouter les informations de l'utilisateur au fichier 'users.json'
$jsonData = file_get_contents($usersFile);
$usersArray = json_decode($jsonData, true);
if (isset($usersArray[$email])) {
    http_response_code(409); // Conflict (l'utilisateur existe déjà)
} else {
    $usersArray[$email] = array(
        'json_path' => $userJsonPath
    );
    $jsonData = json_encode($usersArray);
    file_put_contents($usersFile, $jsonData);

    // Créer le fichier JSON pour l'utilisateur
    $jsonData = json_encode($userData);
    file_put_contents($userJsonPath, $jsonData);

    http_response_code(201); // Created (inscription réussie)
}

?>
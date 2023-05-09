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
$username = $data['username'];
$password = $data['password'];

$stored_passwords = json_decode(file_get_contents('users.txt'), true);
$key = 3; // Clé de chiffrement César
$encryptedPassword = caesar_cipher($password, $key);

if (isset($stored_passwords[$username])) {
    http_response_code(409); // Conflict (l'utilisateur existe déjà)
} else {
    $stored_passwords[$username] = $encryptedPassword;
    file_put_contents('users.txt', json_encode($stored_passwords));
    http_response_code(201); // Created (inscription réussie)
}

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

$validLogin = false;
if (isset($stored_passwords[$username]) && $stored_passwords[$username] === $encryptedPassword) {
    $validLogin = true;
}

if ($validLogin) {
    $cookieValue = base64_encode($username . '|' . time());
    setcookie('user_cookie', $cookieValue, time() + (86400 * 30), '/');
    http_response_code(200);
} else {
    http_response_code(401);
}


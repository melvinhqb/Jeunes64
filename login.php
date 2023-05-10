<?php

$data = json_decode(file_get_contents('php://input'), true);
$email = $data['email'];
$password = $data['password'];

$stored_users = json_decode(file_get_contents('users.json'), true);

$validLogin = false;
if (isset($stored_users[$email])) {
    $user_data = json_decode(file_get_contents($stored_users[$email]['json_path']), true);
    $stockedPassword = $user_data['password'];
    if ($stockedPassword === $password) {
        $validLogin = true;
    }
}

if ($validLogin) {
    $cookieValue = base64_encode($email . '|' . time());
    setcookie('user_cookie', $cookieValue, time() + (86400 * 30), '/');
    http_response_code(200);
} else {
    http_response_code(401);
}

?>
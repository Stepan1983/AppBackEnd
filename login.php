<?php
require 'vendor/autoload.php'; // Подключаем библиотеку JWT

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];
    $password = $data['password'];

    // Чтение данных из файла
    $userData = json_decode(file_get_contents('users.json'), true);
    $users = $userData['users'];

    // Проверяем, существует ли пользователь и пароль верный
    $isValidUser = false;
    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            $isValidUser = true;
            break;
        }
    }

    if ($isValidUser) {
        $tokenPayload = [
            'username' => $username,
            'exp' => time() + 3600 // Токен действителен 1 час (3600 секунд)
        ];

        $secretKey = 'GVrmmhegUpeihqu'; // Замените это на ваш секретный ключ
        $algorithm = 'HS256'; // Выберите подходящий алгоритм подписи

        $token = JWT::encode($tokenPayload, $secretKey, $algorithm);

        echo json_encode(['success' => true, 'token' => $token, 'username' => $username]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Неправильное имя пользователя или пароль.']);
    }
}
?>

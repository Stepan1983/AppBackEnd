<?php
require 'vendor/autoload.php'; // Подключаем библиотеку JWT

use Firebase\JWT\JWT;

// Разрешаем доступ для всех источников
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Симулируем базу данных
$users = [
    'user1' => 'password1',
    'user2' => 'password2',
];

header('Content-Type: application/json');

// Обработка запроса на авторизацию
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $username = $data['username'];
    $password = $data['password'];

    // Проверяем, существует ли пользователь и пароль верный
    if (isset($users[$username]) && $users[$username] === $password) {
        $tokenPayload = [
            'username' => $username,
            'exp' => time() + 3600 // Токен действителен 1 час (3600 секунд)
        ];

        $secretKey = 'your-secret-key'; // Замените это на ваш секретный ключ
        $algorithm = 'HS256'; // Выберите подходящий алгоритм подписи

        $token = JWT::encode($tokenPayload, $secretKey, $algorithm);

        echo json_encode(['success' => true, 'token' => $token, 'username' => $username]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Неправильное имя пользователя или пароль.']);
    }
}
?>

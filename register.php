<?php
require 'vendor/autoload.php'; // Подключаем библиотеку JWT

use Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

function getUserData($username, $password)
{
    // Чтение данных из файла
    $userData = json_decode(file_get_contents('users.json'), true);
    $users = $userData['users'];

    foreach ($users as $user) {
        if ($user['username'] === $username && $user['password'] === $password) {
            return $user;
        }
    }

    return null;
}

function userExists($username)
{
    // Чтение данных из файла
    $userData = json_decode(file_get_contents('users.json'), true);
    $users = $userData['users'];

    foreach ($users as $user) {
        if ($user['username'] === $username) {
            return true;
        }
    }

    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];
    $password = $data['password'];

    if (userExists($username)) {
        echo json_encode(['success' => false, 'message' => 'Пользователь с таким логином уже существует.']);
    } else {
        $userData = json_decode(file_get_contents('users.json'), true);
        $users = $userData['users'];
        $users[] = ['username' => $username, 'password' => $password];
        $userData['users'] = $users;

        file_put_contents('users.json', json_encode($userData));

        echo json_encode(['success' => true, 'message' => 'Пользователь успешно зарегистрирован.', 'token' => null, 'username' => $username]);
    }
}
?>

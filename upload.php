<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    exit();
}

// Путь куда будут сохраняться загруженные аудиофайлы
$uploadDirectory = 'uploads/';

// Проверяем, был ли отправлен файл
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audio'])) {
    // Получаем информацию о файле
    $file = $_FILES['audio'];
    $originalFileName = $file['name'];
    $tmpName = $file['tmp_name'];

    // Получаем имя пользователя из заголовка Authorization
    $token = $_SERVER['HTTP_AUTHORIZATION'];
    $token = str_replace('Bearer ', '', $token);
    $storedUsername = $token;

    // Создаем папку для пользователя, если она не существует
    $userDirectory = $uploadDirectory . $storedUsername . '/';
    if (!file_exists($userDirectory)) {
        mkdir($userDirectory, 0755, true);
    }

    // Генерируем уникальное имя файла
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $fileName = uniqid() . '.' . $extension;
    $destination = $userDirectory . $fileName;

    // Перемещаем загруженный файл в папку uploads
    if (move_uploaded_file($tmpName, $destination)) {
        // Возвращаем JSON-ответ об успешной загрузке
        echo json_encode(['success' => true, 'message' => 'Ваш трек успешно загружен!']);
    } else {
        // Возвращаем JSON-ответ о неудачной загрузке
        echo json_encode(['success' => false, 'message' => 'Произошла ошибка при загрузке файла.']);
    }
} else {
    // Возвращаем JSON-ответ об ошибке, если не был отправлен файл
    echo json_encode(['success' => false, 'message' => 'Неверный запрос или отсутствует файл для загрузки.']);
}
?>

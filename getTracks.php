<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

// Получаем имя пользователя из заголовка Authorization
$token = $_SERVER['HTTP_AUTHORIZATION'];
$token = str_replace('Bearer ', '', $token);
$storedUsername = $token;

// Путь к папке с треками
$uploadsDirectory = 'uploads/' . $storedUsername . '/';
$files = scandir($uploadsDirectory);

// Фильтруем только файлы
$files = array_filter($files, function($file) use ($uploadsDirectory) {
    return is_file($uploadsDirectory . $file);
});

// Создаем плееры для каждого трека
$players = [];
foreach ($files as $file) {
    $players[] = '<audio controls><source src="https://primarycheerfulpostgres.stiepanbastanzh.repl.co/' . $uploadsDirectory . $file . '" type="audio/mpeg">Your browser does not support the audio element.</audio>';
}

// Преобразуем массив плееров в формат JSON и отправляем клиенту
if (!empty($players)) {
    echo json_encode($players);
} else {
    // Обработка ошибки и запись в лог
    error_log("Error reading files from directory: " . $uploadsDirectory);
    echo json_encode(array("error" => "Error reading files from directory"));
}
?>

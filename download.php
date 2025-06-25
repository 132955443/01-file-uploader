<?php
// Получаем массив файлов из базы данных (database.json)
$array = json_decode(file_get_contents("database.json"), true);

// Ищем индекс файла по имени, переданному в параметре 'filename'
$index = array_search($_REQUEST['filename'], array_column($array, 'filename'));

// Если файл не найден, возвращаем 404
if ($index === false) {
    http_response_code(404);
    echo "Файл не найден!";
    exit;
}

// Формируем полный путь к файлу
$filename = __DIR__ . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $array[$index]['filename'];

/**
 * Функция для скачивания файла
 * @param string $filename - полный путь к файлу
 */
function download($filename)
{
    // Открываем файл для чтения в бинарном режиме
    $fp = fopen($filename, 'rb');

    // Отправляем заголовки для скачивания файла
    header("Content-Type: " . mime_content_type($filename));
    header("Content-Length: " . filesize($filename));
    header('Content-Disposition: attachment; filename="' . basename($filename) . '"');

    // Выводим содержимое файла и завершаем скрипт
    fpassthru($fp);
    exit;
}

// Проверяем, защищён ли файл паролем
if (isset($array[$index]['password']) && !empty($array[$index]['password'])) {
    // Получаем пароль из запроса
    $password = $_REQUEST['password'] ?? '';
    // Сравниваем пароли
    if ($array[$index]['password'] === $password) {
        download($filename);
    } else {
        // Если пароль неверный, возвращаем 403
        http_response_code(403);
        echo "Доступ запрещён!";
        exit;
    }
} else {
    // Если пароль не требуется, скачиваем файл
    download($filename);
}
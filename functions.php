<?php
/**
 * Функция для скачивания файла
 * @param string $filename - полный путь к файлу
 */
function download($filename, $name=null)
{
    // Открываем файл для чтения в бинарном режиме
    $fp = fopen($filename, 'rb');

    // Отправляем заголовки для скачивания файла
    header("Content-Type: " . mime_content_type($filename));
    header("Content-Length: " . filesize($filename));

    header('Content-Disposition: attachment; filename="' . (!empty($name) ? $name : basename($filename)) . '"');


    // Выводим содержимое файла и завершаем скрипт
    fpassthru($fp);
    exit;
}

function Return_Error($msg){
    http_response_code(404);
    echo $msg;
    exit;
}
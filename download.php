<?php
$request = $_REQUEST['filename'];
require_once('config.php');
require_once('functions.php');
function get_ip()
{
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

$ip = get_ip();



$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}
$find = "SELECT * from files where filename = '$request'";
$res = $conn->query($find);
if ($res) {
    $row = $res->fetch_assoc();
    if (!$row) {
        Return_Error("Файл не найден");
    }
} else {
    Return_Error("Файл не найден");
}

$filename = __DIR__ . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . $row['filename'];

$id = $row["id"];

$upload_date = date('Y-m-d H:i:s');

$stat_upload = "INSERT INTO `statistic_of_downloads` (`id`, `download_date`, `IP_address`) VALUES ($id, '$upload_date', '$ip')";

// Проверяем, защищён ли файл паролем
if ($row['password'] === null) {
    // Если пароль не требуется, скачиваем файл
    if ($conn->query($stat_upload)) {
        echo "stat is send";
    } else {
        echo "Ошибка: " . $conn->error;
    }
    download($filename);
} else {
    // Получаем пароль из запроса
    $password = $_REQUEST['password'] ?? '';
    // Сравниваем пароли
    if ($row['password'] === $password) {
        if ($conn->query($stat_upload)) {
            echo "stat is send";
        } else {
            echo "Ошибка: " . $conn->error;
        }
        download($filename);
    } else {
        // Если пароль неверный, возвращаем 403
        http_response_code(403);
        echo "Доступ запрещён!";
        exit;
    }
}

$conn->close();
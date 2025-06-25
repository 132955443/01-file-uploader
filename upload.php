<!DOCTYPE html>
<html lang="en">
<head>
   <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
<?php
$full_massive = [];
$database = __DIR__ . DIRECTORY_SEPARATOR . 'database.json';
if (!file_exists($database)){
     file_put_contents('database.json', json_encode($full_massive, JSON_UNESCAPED_UNICODE));
}
if(file_exists($database) && filesize($database) > 0 ){
    $full_massive = json_decode(file_get_contents($database), true);
}

$massive = array(
    'name' => "Отсутствует",
    'description' => "Отсутствует",
    'password' => "Отсутствует",
    'filename' => "Отсутствует",
    'upload_date' => '',
    'size' => 'Отсутствует'
);

if (isset($_POST["name"]) && !empty($_POST["name"])){
    if (strlen($_POST["name"]) <= 50) {    
        $massive['name'] = $_POST["name"];
        
    }}


if (isset($_POST["description"]) && !empty($_POST["description"])){
    if (strlen($_POST["description"]) <= 85) {
        $massive['description'] = $_POST["description"];
        
    }}

if (isset($_POST["password"]) && !empty($_POST["password"])){
    if (strlen($_POST["password"]) <= 20) {
        $massive['password'] = $_POST["password"];
        
    }}

if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    echo'<br><div class="max-w-2x1 mx-auto text-center">' . '<h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">Your file <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-emerald-400">is uploaded</span></h1>' . '<br><div class="button-link">' . '<a href="index.php" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-lg px-5 py-2.5 text-center me-2 mb-2">Return Back</a>' . '</div></div>';    
    
    if (filesize($_FILES['file']['tmp_name']) < 52418314) {
        if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'upload')) {
            mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'upload');
        }
        $massive['filename'] = basename($_FILES['file']['name']);
        if(filesize($_FILES['file']['tmp_name']) < 1024 ){
            $massive['size'] = filesize($_FILES['file']['tmp_name']) . "Byte";
        }
        if(filesize($_FILES['file']['tmp_name']) > 1024 && filesize($_FILES['file']['tmp_name']) < 1048576 ){
            $size = filesize($_FILES['file']['tmp_name'])/1024;
            $size = round($size, 1);
            $massive['size'] = $size . "KB";
        }
        if(filesize($_FILES['file']['tmp_name']) > 1048576 ){
            $size = filesize($_FILES['file']['tmp_name'])/1048576;
            $size = round($size, 1);
            $massive['size'] = $size . "MB";
        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'upload' . DIRECTORY_SEPARATOR . $_FILES['file']['name']);
    }
}else{ 
    echo'<br><br><div class="max-w-2x1 mx-auto text-center">' . '<h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">Failed to save the file, <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-emerald-400">please try again.</span></h1></div>';
    
    
    echo'<br><div class="max-w-2x1 mx-auto text-center"><div class="button-link">' . '<a href="index.php" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-lg px-5 py-2.5 text-center me-2 mb-2">Return Back</a>' . '</div></div>'; 
}

$massive['upload_date'] = time();
$full_massive[] = $massive;
file_put_contents($database, json_encode($full_massive, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
?>

</body>
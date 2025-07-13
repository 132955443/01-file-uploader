<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body>
    <?php
    require_once('config.php');

    if (isset($_POST["name"]) && !empty($_POST["name"])) {
        if (strlen($_POST["name"]) <= 255) {
            $name = $_POST['name'];
        }
    }

    if (isset($_POST["description"]) && !empty($_POST["description"])) {
        if (strlen($_POST["description"]) <= 2500) {
            $description = $_POST['description'];
        }
    }

    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        if (strlen($_POST["password"]) <= 32) {
            $user_password = $_POST['password'];
        }
    } else {
        $user_password = null;
    }


    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
        if (filesize($_FILES['file']['tmp_name']) < 52418314) {
            if (!is_dir(__DIR__ . DIRECTORY_SEPARATOR . 'upload')) {
                mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'upload');
            }
            $filename = basename($_FILES['file']['name']);
            $size = filesize($_FILES['file']['tmp_name']);

        }

        move_uploaded_file($_FILES['file']['tmp_name'], 'upload' . DIRECTORY_SEPARATOR . $_FILES['file']['name']);
    } else {
        //Failed to save the file
        echo '<br><br><div class="max-w-2x1 mx-auto text-center">' . '<h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">Failed to save the file, <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-emerald-400">please try again.</span></h1></div>';


        echo '<br><div class="max-w-2x1 mx-auto text-center"><div class="button-link">' . '<a href="index.php" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-lg px-5 py-2.5 text-center me-2 mb-2">Return Back</a>' . '</div></div>';
    }

    $upload_date = date('Y-m-d H:i:s');

    if (isset($name) && isset($description) && isset($filename) && isset($upload_date) && isset($size)) {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO `files` (`name`, `description`, `filename`, `upload_date`, `size`, `password`) VALUES
    ('$name', '$description', '$filename', '$upload_date', '$size', '$user_password')";
        if ($conn->query($sql)) {
            //Your file is uploaded
            echo '<br><div class="max-w-2x1 mx-auto text-center">' . '<h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">Your file <span class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-emerald-400">is uploaded</span></h1>' . '<br><div class="button-link">' . '<a href="index.php" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 shadow-lg shadow-cyan-500/50 dark:shadow-lg dark:shadow-cyan-800/80 font-medium rounded-lg text-lg px-5 py-2.5 text-center me-2 mb-2">Return Back</a>' . '</div></div>';
        } else {
            echo "Ошибка: " . $conn->error;
        }
        $conn->close();
    } else {
        echo "something is not isset";
    }



    ?>

</body>
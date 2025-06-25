<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload files</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

</head>

<body>
    <br>
    <div style="text-align: center">
        <h1 class="button-link mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
            <a href="/01-file-uploader/index.php"
                class="text-transparent bg-clip-text bg-gradient-to-r to-blue-600 from-emerald-400">Upload Files</a>
        </h1>
        <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Here you can share your file to all
            world</p>
    </div>
    <br>

    <form class="max-w-md mx-auto" method="GET">
        <label for="default-search"
            class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="search" name="search" id="default-search"
                class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Find any files in our site" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" autocomplete="off" />
            <button type="submit"
                class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
        </div>
    </form>

    <?php
    $database = __DIR__ . DIRECTORY_SEPARATOR . 'database.json';

    ?>

    <br>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-w-lg mx-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Description</th>
                    <th scope="col" class="px-6 py-3">Size</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $content = file_get_contents('database.json');
                $array = json_decode($content, true);

                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = mb_strtolower($_GET['search']);

                    $array = array_filter($array, function ($item) use ($search) {
                        return (strpos(mb_strtolower($item['name']), $search) !== false || strpos(mb_strtolower($item['description']), $search) !== false) || strpos(mb_strtolower($item['filename']), $search) !== false;
                    });
                }
                foreach ($array as $item) {
                    echo '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"><td class="px-6 py-4">';
                    if (!empty($item['password'])) {
                        echo ("🔒 ");
                    }
                    echo '<a href="download.php?file=' . $item['filename'] . '" onclick="onFilenameClick(event,\'' . $item['filename'] . '\',' . (!empty($item['password']) ? 'true' : 'false') . ')" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">';
                    echo $item['name'] . '</a>';
                    echo '</td><td class="px-6 py-4">';
                    echo $item['description'];
                    echo '</td><td class="px-6 py-4">';
                    echo $item['size'];
                    echo '</td></tr>';
                }
                ?>
            </tbody>
        </table>

        <div id="info-popup" tabindex="-1"
            class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="relative p-4 w-full max-w-lg h-full md:h-auto  m-auto">
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 md:p-8">
                    <form action="download.php" method="POST" target="_blank">
                        <div class="mb-4 text-sm font-light text-gray-500 dark:text-gray-400">
                            <h3 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white">Password protection</h3>

                            <div class="mb-5">
                                <input type="hidden" name="filename" value="">
                                <input type="password" id="password" name="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="" />
                            </div>

                        </div>
                        <div class="justify-between items-center pt-0 space-y-4 sm:flex sm:space-y-0">
                            <div class="flex justify-between items-center space-y-4 sm:space-x-4 sm:flex sm:space-y-0 w-full">
                                <button id="close-modal" type="button"
                                    class="py-2 px-4 w-full text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 sm:w-auto hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"
                                    onclick="document.querySelector('#info-popup').classList.add('hidden')">Cancel</button>
                                <button id="confirm-button" type="submit"
                                    class="py-2 px-4 w-full text-sm font-medium text-center text-white rounded-lg bg-slate-700 sm:w-auto hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Confirm</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="flex max-w-60 mx-auto">
        <!-- Previous Button -->
        <a href="/index.php/previous_page"
            class="flex items-center justify-center px-4 h-10 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            Previous
        </a>

        <!-- Next Button -->
        <a href="/index.php/previous_page"
            class="flex items-center justify-center px-4 h-10 ms-3 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            Next
        </a>
    </div>
    <br>
    <form class="max-w-lg mx-auto" method="POST" action="upload.php" enctype='multipart/form-data'>
        <div class="mb-5">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" id="name" name="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="" value="" required />
        </div>
        <div class="mb-5">
            <label for="description"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <textarea type="text" id="description" name="description"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="" rows="5" required></textarea>
        </div>
        <div class="mb-5">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pasword</label>
            <input type="password" id="password" name="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="" />
        </div>
        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="user_avatar">Upload
                file</label>
            <label for="dropzone-file"
                class="flex flex-col items-center justify-center w-full h-43 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                    </svg>
                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                            upload</span> or drag and drop</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">MAX. SIZE 50MB</p>
                </div>
                <input id="dropzone-file" type="file" name="file" class="hidden" required />
            </label>
        </div>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
            Отправить
        </button>
    </form>
    <br>

    <script>
        function onFilenameClick(event, filename, hasPassword) {
            console.log(filename);
            if (hasPassword) {
                event.preventDefault();
                document.querySelector('form input[name=filename]').setAttribute('value', filename);
                document.querySelector('#info-popup').classList.remove('hidden')
            }
        }
    </script>

</body>

</html>
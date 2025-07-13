<?php
require_once('vendor/autoload.php');
require_once('functions.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Spreadsheet object
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

require_once('config.php');
$sql = "SELECT * FROM files";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка: " . $conn->connect_error);
}
if ($result = $conn->query($sql)) {
    $sheet->setCellValue('A' . 1, 'id');
    $sheet->setCellValue('B' . 1, 'name');
    $sheet->setCellValue('C' . 1, 'description');
    $sheet->setCellValue('D' . 1, 'filename');
    $sheet->setCellValue('E' . 1, 'upload date');
    $sheet->setCellValue('F' . 1, 'size');
    $sheet->setCellValue('G' . 1, 'password');
    $counter = 2;
    foreach ($result as $row) {
        $sheet->setCellValue('A' . $counter, $row['id']);
        $sheet->setCellValue('B' . $counter, $row['name']);
        $sheet->setCellValue('C' . $counter, $row['description']);
        $sheet->setCellValue('D' . $counter, $row['filename']);
        $sheet->setCellValue('E' . $counter, $row['upload_date']);
        $sheet->setCellValue('F' . $counter, $row['size']);
        $sheet->setCellValue('G' . $counter, $row['password']);
        $counter += 1;
    }
}
$conn->close();

// You can also set the title of the sheet
$sheet->setTitle('Export All Files');

// Create a writer to save the spreadsheet
$writer = new Xlsx($spreadsheet);

// Save the spreadsheet to a file
$filename = 'temp/simple_example.xlsx';
$writer->save($filename);

download($filename, "export.xlsx");


// echo "Spreadsheet created successfully as $filename";
<?php

// Serves a sample Excel template file for student import.
// If a static file exists, it will be served. Otherwise, a template is generated on-the-fly.

$templatePath = realpath(__DIR__ . '/../../uploads/templates/student_import_template.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="student_import_template.xlsx"');

if ($templatePath && is_file($templatePath)) {
    header('Content-Length: ' . filesize($templatePath));
    readfile($templatePath);
    exit;
}

require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('students');

// Only columns B-E are used by import.
$sheet->setCellValue('B1', 'ปีการศึกษา (B)');
$sheet->setCellValue('C1', 'เทอม (C)');
$sheet->setCellValue('D1', 'ชื่อ - นามสกุล (D)');
$sheet->setCellValue('E1', 'รหัสนิสิต (E)');

$sheet->setCellValueExplicit('B2', '2567', DataType::TYPE_STRING);
$sheet->setCellValueExplicit('C2', '1', DataType::TYPE_STRING);
$sheet->setCellValue('D2', 'ตัวอย่าง นิสิต');
$sheet->setCellValueExplicit('E2', '6501234567', DataType::TYPE_STRING);

$sheet->getColumnDimension('A')->setWidth(2);
$sheet->getColumnDimension('B')->setWidth(18);
$sheet->getColumnDimension('C')->setWidth(12);
$sheet->getColumnDimension('D')->setWidth(28);
$sheet->getColumnDimension('E')->setWidth(18);

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');

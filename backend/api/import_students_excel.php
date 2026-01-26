<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/StudentImport.php';
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$response = [
    'success' => false,
    'message' => '',
    'inserted' => 0,
    'duplicates' => 0,
    'errors' => 0,
    'error_rows' => [],
    'duplicate_rows' => [],
];



function cellToString($cell): string
{
    if ($cell === null) return '';
    $value = $cell->getValue();

    if ($value === null) return '';
    if (is_string($value)) return trim($value);

    if (is_int($value)) return trim((string)$value);

    if (is_float($value)) {
        // Avoid scientific notation for common numeric student codes.
        return trim(sprintf('%.0f', $value));
    }

    $formatted = $cell->getFormattedValue();
    return trim((string)$formatted);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    exit;
}

$file = $_FILES['excel_file'] ?? $_FILES['file'] ?? null;
if (!$file || !isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
    $response['message'] = 'กรุณาอัปโหลดไฟล์ Excel';
    echo json_encode($response);
    exit;
}

$ext = strtolower(pathinfo((string)($file['name'] ?? ''), PATHINFO_EXTENSION));
if (!in_array($ext, ['xlsx', 'xls'], true)) {
    $response['message'] = 'รองรับเฉพาะไฟล์ .xlsx หรือ .xls';
    echo json_encode($response);
    exit;
}

try {
    $database = new Database();
    $db = $database->getConnection();


    $importer = new StudentImport($db);

    $spreadsheet = IOFactory::load($file['tmp_name']);
    $sheet = $spreadsheet->getActiveSheet();

    $highestRow = (int) $sheet->getHighestDataRow('E');

    for ($row = 2; $row <= $highestRow; $row++) {
        $academicYear = cellToString($sheet->getCell("B{$row}"));
        $academicTerm = cellToString($sheet->getCell("C{$row}"));
        $userName = cellToString($sheet->getCell("D{$row}"));
        $userCode = cellToString($sheet->getCell("E{$row}"));

        // Skip completely empty rows.
        if ($academicYear === '' && $academicTerm === '' && $userName === '' && $userCode === '') {
            continue;
        }

        if ($userCode === '') {
            $response['errors']++;
            $response['error_rows'][] = [
                'row' => $row,
                'message' => 'ไม่มีรหัสนิสิต (คอลัมน์ E)',
            ];
            continue;
        }

        $result = $importer->insertStudent([
            'user_code' => $userCode,
            'user_name' => $userName,
            'academic_year' => $academicYear,
            'academic_term' => $academicTerm,
        ]);

        if (($result['status'] ?? '') === 'inserted') {
            $response['inserted']++;
        } elseif (($result['status'] ?? '') === 'duplicate') {
            $response['duplicates']++;
            if (count($response['duplicate_rows']) < 50) {
                $response['duplicate_rows'][] = [
                    'row' => $row,
                    'user_code' => $userCode,
                ];
            }
        } else {
            $response['errors']++;
            if (count($response['error_rows']) < 50) {
                $response['error_rows'][] = [
                    'row' => $row,
                    'user_code' => $userCode,
                    'message' => (string)($result['message'] ?? 'ไม่สามารถนำเข้าได้'),
                ];
            }
        }
    }

    $response['success'] = true;
    $response['message'] = 'นำเข้าเสร็จสิ้น';
    echo json_encode($response);
} catch (Throwable $e) {
    $response['message'] = $e->getMessage();
    echo json_encode($response);
}

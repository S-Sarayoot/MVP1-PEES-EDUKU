<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Major.php';

function jsonFail(string $message, int $status = 400): void {
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    jsonFail('Invalid request method', 405);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) $input = [];
$name = $input['name'] ?? ($_POST['name'] ?? null);

try {
    $db = (new Database())->getConnection();
    $model = new Major($db);
    $model->name = $name;

    if (!$model->create()) {
        if ($model->last_error === 'DUPLICATE_NAME') {
            jsonFail('ชื่อสาขาวิชาซ้ำบนระบบ', 409);
        }
        jsonFail('ไม่สามารถเพิ่มสาขาวิชาได้', 500);
    }

    echo json_encode([
        'success' => true,
        'id' => (int)$model->id,
        'name' => (string)$model->name,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error', 500);
}

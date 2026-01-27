<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/credential.php';

function jsonFail($message, $status = 400)
{
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonFail('Invalid request method', 405);
}

if (!isset($credential_user_type) || $credential_user_type !== 'admin') {
    jsonFail('Forbidden', 403);
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) $payload = [];

$userId = $payload['user_id'] ?? ($_POST['user_id'] ?? null);
$userId = intval($userId);

if ($userId <= 0) {
    jsonFail('Missing user_id');
}

if (isset($credential_user_id) && intval($credential_user_id) === $userId) {
    jsonFail('ไม่อนุญาตให้ลบตัวเอง', 400);
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Soft delete: set status=0 (excluded by counts and listing)
    $stmt = $db->prepare('UPDATE elk_user SET status = 0 WHERE user_id = :id AND status <> 0');
    $stmt->execute([':id' => $userId]);

    if ($stmt->rowCount() <= 0) {
        echo json_encode(['success' => false, 'message' => 'ไม่พบผู้ใช้งานหรือถูกลบแล้ว'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error: ' . $e->getMessage(), 500);
}

<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/credential.php';

function jsonFail($message, $status = 400)
{
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    jsonFail('Invalid request method', 405);
}

$userId = isset($credential_user_id) ? intval($credential_user_id) : 0;
if ($userId <= 0) {
    jsonFail('Unauthorized', 401);
}

try {
    $db = (new Database())->getConnection();

    $stmt = $db->prepare(
        'SELECT u.*, m.name AS major_name, f.name AS faculty_name ' .
        'FROM elk_user u ' .
        'LEFT JOIN elk_major m ON u.major_id = m.id ' .
        'LEFT JOIN elk_faculty f ON u.faculty_id = f.id ' .
        'WHERE u.user_id = :user_id ' .
        'LIMIT 1'
    );
    $stmt->execute([':user_id' => $userId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        jsonFail('User not found', 404);
    }

    // Normalize types a bit
    $row['user_id'] = intval($row['user_id'] ?? 0);
    $row['faculty_id'] = isset($row['faculty_id']) ? intval($row['faculty_id']) : null;
    $row['major_id'] = isset($row['major_id']) ? intval($row['major_id']) : null;

    echo json_encode([
        'success' => true,
        'user' => $row,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error', 500);
}

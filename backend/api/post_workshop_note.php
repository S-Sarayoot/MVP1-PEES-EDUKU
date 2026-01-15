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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonFail('Invalid request method', 405);
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'application/json') === false) {
    jsonFail('Content-Type must be application/json');
}

if (!isset($credential_user_id) || intval($credential_user_id) <= 0) {
    jsonFail('Unauthorized', 401);
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) {
    jsonFail('Invalid JSON payload');
}

$workshopId = isset($payload['workshop_id']) ? intval($payload['workshop_id']) : 0;
$parentId = isset($payload['parent_id']) ? intval($payload['parent_id']) : 0;
$content = trim((string)($payload['content'] ?? ''));

if ($workshopId <= 0) jsonFail('Missing workshop_id');
if ($content === '') jsonFail('Missing content');

$userId = intval($credential_user_id);
$userType = isset($credential_user_type) ? (string)$credential_user_type : '';
$authorName = isset($credential_user_name) ? (string)$credential_user_name : null;

$allowedTypes = ['student', 'teacher', 'admin'];
if (!in_array($userType, $allowedTypes, true)) {
    jsonFail('Forbidden', 403);
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Ensure notes table
    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_workshop_notes (\n" .
            "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
            "  workshop_id INT NOT NULL,\n" .
            "  user_id INT NOT NULL,\n" .
            "  user_type VARCHAR(20) NOT NULL,\n" .
            "  author_name VARCHAR(255) NULL,\n" .
            "  parent_id BIGINT NULL,\n" .
            "  content TEXT NOT NULL,\n" .
            "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
            "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
            "  PRIMARY KEY (id),\n" .
            "  INDEX idx_notes_workshop (workshop_id),\n" .
            "  INDEX idx_notes_parent (parent_id),\n" .
            "  INDEX idx_notes_user (user_id)\n" .
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    // Student gating: must have submitted at least once for this workshop
    if ($userType === 'student') {
        $check = $db->prepare('SELECT id FROM elk_workshop_attempts WHERE workshop_id = :workshop_id AND user_id = :user_id LIMIT 1');
        $check->execute([':workshop_id' => $workshopId, ':user_id' => $userId]);
        $hasAttempt = $check->fetch(PDO::FETCH_ASSOC);
        if (!$hasAttempt) {
            jsonFail('กรุณาทำกิจกรรมและส่งคำตอบก่อน จึงจะสะท้อนคิดได้', 403);
        }
    }

    if ($parentId > 0) {
        $checkParent = $db->prepare('SELECT id FROM elk_workshop_notes WHERE id = :id AND workshop_id = :workshop_id LIMIT 1');
        $checkParent->execute([':id' => $parentId, ':workshop_id' => $workshopId]);
        $parent = $checkParent->fetch(PDO::FETCH_ASSOC);
        if (!$parent) {
            jsonFail('Parent note not found', 404);
        }
    } else {
        $parentId = null;
    }

    $stmt = $db->prepare(
        'INSERT INTO elk_workshop_notes (workshop_id, user_id, user_type, author_name, parent_id, content) ' .
            'VALUES (:workshop_id, :user_id, :user_type, :author_name, :parent_id, :content)'
    );

    $stmt->execute([
        ':workshop_id' => $workshopId,
        ':user_id' => $userId,
        ':user_type' => $userType,
        ':author_name' => $authorName,
        ':parent_id' => $parentId,
        ':content' => $content,
    ]);

    $noteId = intval($db->lastInsertId());

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'created',
        'note' => [
            'id' => $noteId,
            'workshop_id' => $workshopId,
            'user_id' => $userId,
            'user_type' => $userType,
            'author_name' => $authorName,
            'parent_id' => $parentId,
            'content' => $content,
        ],
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

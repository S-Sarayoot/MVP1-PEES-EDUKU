<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/credential.php';

function jsonFail($message, $status = 400) {
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonFail('Invalid request method', 405);
}

// Optional: restrict to admin
if (!isset($credential_user_type) || $credential_user_type !== 'admin') {
    jsonFail('Forbidden', 403);
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
$payload = null;
if (stripos($contentType, 'application/json') !== false) {
    $raw = file_get_contents('php://input');
    $payload = json_decode($raw, true);
    if (!is_array($payload)) {
        jsonFail('Invalid JSON payload');
    }
} else {
    $payload = $_POST;
}

$workshop_id = isset($payload['workshop_id']) ? intval($payload['workshop_id']) : 0;
$post_ids = $payload['post_ids'] ?? [];

if ($workshop_id <= 0) {
    jsonFail('Missing workshop_id');
}
if (!is_array($post_ids)) {
    jsonFail('post_ids must be an array');
}

$normalized = [];
foreach ($post_ids as $id) {
    $pid = intval($id);
    if ($pid > 0) $normalized[$pid] = true;
}
$post_ids = array_values(array_map('intval', array_keys($normalized)));

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Create mapping table if missing
    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_workshop_posts (\n" .
        "  workshop_id INT NOT NULL,\n" .
        "  post_id INT NOT NULL,\n" .
        "  created_by INT NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (workshop_id, post_id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $db->beginTransaction();

    $del = $db->prepare('DELETE FROM elk_workshop_posts WHERE workshop_id = :wid');
    $del->execute([':wid' => $workshop_id]);

    if (count($post_ids) > 0) {
        $ins = $db->prepare('INSERT INTO elk_workshop_posts (workshop_id, post_id, created_by) VALUES (:wid, :pid, :uid)');
        foreach ($post_ids as $pid) {
            $ins->execute([
                ':wid' => $workshop_id,
                ':pid' => $pid,
                ':uid' => isset($credential_user_id) ? intval($credential_user_id) : null,
            ]);
        }
    }

    $db->commit();

    echo json_encode([
        'success' => true,
        'message' => 'บันทึกโพสต์ที่เกี่ยวข้องเรียบร้อย',
        'workshop_id' => $workshop_id,
        'count' => count($post_ids),
        'post_ids' => $post_ids,
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    if (isset($db) && $db && $db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonFail('Invalid request method', 405);
}

if (!isset($credential_user_id) || intval($credential_user_id) <= 0) {
    jsonFail('Unauthorized', 401);
}

$workshopId = isset($_GET['workshop_id']) ? intval($_GET['workshop_id']) : 0;
if ($workshopId <= 0) {
    jsonFail('Missing workshop_id');
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Notes schema
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

    $stmt = $db->prepare(
        'SELECT id, workshop_id, user_id, user_type, author_name, parent_id, content, created_at ' .
            'FROM elk_workshop_notes ' .
            'WHERE workshop_id = :workshop_id ' .
            'ORDER BY created_at ASC, id ASC'
    );
    $stmt->execute([':workshop_id' => $workshopId]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $notes = [];
    foreach ($rows as $row) {
        $notes[] = [
            'id' => intval($row['id'] ?? 0),
            'workshop_id' => intval($row['workshop_id'] ?? 0),
            'user_id' => intval($row['user_id'] ?? 0),
            'user_type' => $row['user_type'] ?? null,
            'author_name' => $row['author_name'] ?? null,
            'parent_id' => isset($row['parent_id']) ? (intval($row['parent_id']) ?: null) : null,
            'content' => $row['content'] ?? '',
            'created_at' => $row['created_at'] ?? null,
        ];
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'ok',
        'workshop_id' => $workshopId,
        'notes' => $notes,
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

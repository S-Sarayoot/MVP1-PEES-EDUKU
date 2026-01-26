<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/credential.php';

function jsonFail($message, $status = 400) {
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonFail('Invalid request method', 405);
}

$workshop_id = 0;
if (isset($_GET['workshop_id'])) {
    $workshop_id = intval($_GET['workshop_id']);
} elseif (isset($_GET['id'])) {
    $workshop_id = intval($_GET['id']);
}

if ($workshop_id <= 0) {
    jsonFail('Missing workshop_id');
}

// Read-only endpoint: allow any authenticated user to view workshop resources.
// (Write access is still restricted in set_workshop_posts.php)
if (!isset($credential_user_id) || $credential_user_id === '0' || !isset($credential_user_type) || $credential_user_type === '') {
    jsonFail('Unauthorized', 401);
}

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

    $stmt = $db->prepare(
        'SELECT wp.post_id, p.title, p.category, p.created_at ' .
        'FROM elk_workshop_posts wp ' .
        'LEFT JOIN elk_post p ON p.id = wp.post_id ' .
        'WHERE wp.workshop_id = :wid ' .
        'ORDER BY wp.post_id DESC'
    );
    $stmt->execute([':wid' => $workshop_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $posts = [];
    foreach ($rows as $r) {
        $posts[] = [
            'id' => intval($r['post_id']),
            'title' => $r['title'] ?? null,
            'category' => $r['category'] ?? null,
            'created_at' => $r['created_at'] ?? null,
        ];
    }

    echo json_encode([
        'success' => true,
        'workshop_id' => $workshop_id,
        'post_ids' => array_values(array_map(fn($p) => $p['id'], $posts)),
        'posts' => $posts,
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

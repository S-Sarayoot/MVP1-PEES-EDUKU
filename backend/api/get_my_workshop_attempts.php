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

$userId = intval($credential_user_id);
$workshopId = isset($_GET['workshop_id']) ? intval($_GET['workshop_id']) : 0;

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    $sql = 'SELECT id, workshop_id, status, submitted_at, needs_manual FROM elk_workshop_attempts WHERE user_id = :user_id';
    $params = [':user_id' => $userId];

    if ($workshopId > 0) {
        $sql .= ' AND workshop_id = :workshop_id';
        $params[':workshop_id'] = $workshopId;
    }

    $sql .= ' ORDER BY id DESC';

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Keep only latest attempt per workshop_id
    $byWorkshopId = [];
    foreach ($rows as $row) {
        $wId = intval($row['workshop_id'] ?? 0);
        if ($wId <= 0) continue;
        if (isset($byWorkshopId[$wId])) continue;

        $byWorkshopId[$wId] = [
            'attempt_id' => intval($row['id'] ?? 0),
            'workshop_id' => $wId,
            'status' => $row['status'] ?? null,
            'submitted_at' => $row['submitted_at'] ?? null,
            'needs_manual' => intval($row['needs_manual'] ?? 0) === 1,
        ];
    }

    $attempts = array_values($byWorkshopId);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'ok',
        'user_id' => $userId,
        'attempts' => $attempts,
        'by_workshop_id' => $byWorkshopId,
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

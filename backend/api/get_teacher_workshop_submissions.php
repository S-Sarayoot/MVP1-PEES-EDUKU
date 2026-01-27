<?php
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/credential.php';

function jsonFail(string $message, int $status = 400): void
{
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'GET') {
    jsonFail('Invalid request method', 405);
}

$userId = isset($credential_user_id) ? (int)$credential_user_id : 0;
$userType = isset($credential_user_type) ? (string)$credential_user_type : '';

if ($userId <= 0) {
    jsonFail('Unauthorized', 401);
}

if (!in_array($userType, ['teacher', 'admin'], true)) {
    jsonFail('Forbidden', 403);
}

$workshopId = isset($_GET['workshop_id']) ? (int)$_GET['workshop_id'] : 0;

try {
    $db = (new Database())->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Ensure notes table exists (used as "reflection" timeline)
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

    $params = [];

    // Latest attempt row per (workshop_id, user_id)
    // (avoid GROUP BY losing score/status information)
    $where = 'a.workshop_id IN (1,2,3)';
    if ($workshopId > 0) {
        $where = 'a.workshop_id = :workshop_id';
        $params[':workshop_id'] = $workshopId;
    }

    $sql =
        'SELECT a.id AS attempt_id, a.workshop_id, a.user_id, ' .
        'COALESCE(a.submitted_at, a.created_at) AS last_submitted_at, ' .
        'a.status, a.score_total, a.max_score_total, ' .
        'u.username, u.user_name, m.name AS major_name, ' .
        'EXISTS(SELECT 1 FROM elk_workshop_notes n ' .
        '       WHERE n.workshop_id = a.workshop_id AND n.user_id = a.user_id AND n.user_type = \'student\' LIMIT 1) AS has_reflection ' .
        'FROM elk_workshop_attempts a ' .
        'JOIN elk_user u ON u.user_id = a.user_id ' .
        'LEFT JOIN elk_major m ON u.major_id = m.id ' .
        "WHERE u.user_type = 'student' AND {$where} " .
        'AND NOT EXISTS (' .
        '  SELECT 1 FROM elk_workshop_attempts a2 ' .
        '  WHERE a2.workshop_id = a.workshop_id AND a2.user_id = a.user_id ' .
        '    AND (' .
        '      COALESCE(a2.submitted_at, a2.created_at) > COALESCE(a.submitted_at, a.created_at) ' .
        '      OR (' .
        '        COALESCE(a2.submitted_at, a2.created_at) = COALESCE(a.submitted_at, a.created_at) ' .
        '        AND a2.id > a.id' .
        '      )' .
        '    )' .
        ') ' .
        'ORDER BY a.workshop_id ASC, last_submitted_at DESC, u.user_name ASC';

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    $items = [];
    $counts = [
        'workshop 1' => 0,
        'workshop 2' => 0,
        'workshop 3' => 0,
    ];

    foreach ($rows as $r) {
        $wId = (int)($r['workshop_id'] ?? 0);
        $cat = $wId > 0 ? ('workshop ' . $wId) : '';
        if (isset($counts[$cat])) {
            $counts[$cat]++;
        }

        $items[] = [
            'workshop_id' => $wId,
            'cat' => $cat,
            'submitted_at' => $r['last_submitted_at'] ?? null,
            'attempt_id' => (int)($r['attempt_id'] ?? 0),
            'status' => $r['status'] ?? '',
            'score_total' => isset($r['score_total']) ? (int)$r['score_total'] : 0,
            'max_score_total' => isset($r['max_score_total']) ? (int)$r['max_score_total'] : 0,
            'user_id' => (int)($r['user_id'] ?? 0),
            'student_id' => $r['username'] ?? '',
            'name' => $r['user_name'] ?? '',
            'major' => $r['major_name'] ?? '',
            'reflection' => ((int)($r['has_reflection'] ?? 0)) === 1,
        ];
    }

    echo json_encode([
        'success' => true,
        'message' => 'ok',
        'items' => $items,
        'counts' => $counts,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error', 500);
}

<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';

// credential (enforces login via cookie JWT like other endpoints)
require_once __DIR__ . '/../config/credential.php';

function jsonFail($message, $status = 400)
{
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

function toDatetimeLocal($value)
{
    // Converts "YYYY-MM-DD HH:MM:SS" -> "YYYY-MM-DDTHH:MM"
    $value = trim((string)$value);
    if ($value === '') return '';

    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}(:\d{2})?$/', $value)) {
        $value = substr($value, 0, 16); // keep YYYY-MM-DD HH:MM
        return str_replace(' ', 'T', $value);
    }

    // Already datetime-local
    if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $value)) {
        return $value;
    }

    return $value;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    jsonFail('Invalid request method', 405);
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Ensure table exists (same minimal schema as create_workshop.php)
    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_workshops (\n" .
        "  id INT NOT NULL AUTO_INCREMENT,\n" .
        "  open_time DATETIME NOT NULL,\n" .
        "  close_time DATETIME NOT NULL,\n" .
        "  objective TEXT NOT NULL,\n" .
        "  instruction TEXT NOT NULL,\n" .
        "  questions_json JSON NOT NULL,\n" .
        "  created_by INT NULL,\n" .
        "  updated_by INT NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $stmt = $db->prepare('SELECT id, open_time, close_time, objective, instruction, questions_json, created_by, updated_by, created_at, updated_at FROM elk_workshops ORDER BY id ASC');
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $workshops = [];
    foreach ($rows as $row) {
        $questions = [];
        if (isset($row['questions_json'])) {
            $decoded = json_decode($row['questions_json'], true);
            if (is_array($decoded)) {
                $questions = $decoded;
            }
        }

        $workshops[] = [
            'id' => intval($row['id'] ?? 0),
            'open_time' => $row['open_time'] ?? null,
            'close_time' => $row['close_time'] ?? null,
            'open_time_local' => toDatetimeLocal($row['open_time'] ?? ''),
            'close_time_local' => toDatetimeLocal($row['close_time'] ?? ''),
            'objective' => $row['objective'] ?? '',
            'instruction' => $row['instruction'] ?? '',
            'questions' => $questions,
            'created_by' => isset($row['created_by']) ? intval($row['created_by']) : null,
            'updated_by' => isset($row['updated_by']) ? intval($row['updated_by']) : null,
            'created_at' => $row['created_at'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
        ];
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'ok',
        'workshops' => $workshops,
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

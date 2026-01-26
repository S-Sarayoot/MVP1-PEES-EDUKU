<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';

// credential (enforces login via cookie JWT like other endpoints)
require_once __DIR__ . '/../config/credential.php';

function jsonFail($message, $status = 400) {
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

function toDatetimeLocal($value) {
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

$id = 0;
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_GET['workshop_id'])) {
    $id = intval($_GET['workshop_id']);
}

if ($id <= 0) {
    jsonFail('Missing id');
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
        "  main_concept TEXT NULL,\n" .
        "  instruction TEXT NOT NULL,\n" .
        "  questions_json JSON NOT NULL,\n" .
        "  rubric_json JSON NULL,\n" .
        "  created_by INT NULL,\n" .
        "  updated_by INT NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    // Ensure column exists for older DBs
    try {
        $col = $db->query("SHOW COLUMNS FROM elk_workshops LIKE 'main_concept'");
        if ($col && $col->rowCount() === 0) {
            $db->exec("ALTER TABLE elk_workshops ADD COLUMN main_concept TEXT NULL AFTER objective");
        }
    } catch (Exception $e) {
        // ignore; best-effort migration
    }

    // Ensure rubric_json exists for older DBs
    try {
        $col = $db->query("SHOW COLUMNS FROM elk_workshops LIKE 'rubric_json'");
        if ($col && $col->rowCount() === 0) {
            $db->exec("ALTER TABLE elk_workshops ADD COLUMN rubric_json JSON NULL AFTER questions_json");
        }
    } catch (Exception $e) {
        // ignore; best-effort migration
    }

    $row = null;
    try {
        $stmt = $db->prepare('SELECT id, open_time, close_time, objective, main_concept, instruction, questions_json, rubric_json, created_by, updated_by, created_at, updated_at FROM elk_workshops WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        // Fallback for DBs missing rubric_json
        $stmt = $db->prepare('SELECT id, open_time, close_time, objective, main_concept, instruction, questions_json, created_by, updated_by, created_at, updated_at FROM elk_workshops WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if (!$row) {
        jsonFail('Workshop not found', 404);
    }

    $questions = [];
    if (isset($row['questions_json'])) {
        $decoded = json_decode($row['questions_json'], true);
        if (is_array($decoded)) {
            $questions = $decoded;
        }
    }

    $rubric = [];
    if (isset($row['rubric_json'])) {
        $decoded = json_decode($row['rubric_json'], true);
        if (is_array($decoded)) {
            $rubric = $decoded;
        }
    }

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'ok',
        'workshop' => [
            'id' => intval($row['id']),
            'open_time' => $row['open_time'],
            'close_time' => $row['close_time'],
            'open_time_local' => toDatetimeLocal($row['open_time']),
            'close_time_local' => toDatetimeLocal($row['close_time']),
            'objective' => $row['objective'],
            'main_concept' => $row['main_concept'] ?? '',
            'instruction' => $row['instruction'],
            'questions' => $questions,
            'rubric' => $rubric,
            'created_by' => isset($row['created_by']) ? intval($row['created_by']) : null,
            'updated_by' => isset($row['updated_by']) ? intval($row['updated_by']) : null,
            'created_at' => $row['created_at'] ?? null,
            'updated_at' => $row['updated_at'] ?? null,
        ],
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

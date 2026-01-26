<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';

// credential (enforces login via cookie JWT like other endpoints)
require_once __DIR__ . '/../config/credential.php';

$response = [
    'success' => false,
    'message' => '',
];

function normalizeDatetimeLocal($value) {
    $value = trim((string)$value);
    if ($value === '') return '';

    // Accept: YYYY-MM-DDTHH:MM
    if (preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $value)) {
        return str_replace('T', ' ', $value) . ':00';
    }

    // Already in SQL-ish format
    return $value;
}

function jsonFail($message, $status = 400) {
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonFail('Invalid request method', 405);
}

// Support JSON body (preferred) and fallback to classic POST
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
    if (isset($_POST['questions_json'])) {
        $decoded = json_decode($_POST['questions_json'], true);
        if (is_array($decoded)) {
            $payload['questions'] = $decoded;
        }
    }
}

$workshop_id = isset($payload['workshop_id']) ? intval($payload['workshop_id']) : 0;
$open_time = normalizeDatetimeLocal($payload['open_time'] ?? '');
$close_time = normalizeDatetimeLocal($payload['close_time'] ?? '');
$objective = trim((string)($payload['objective'] ?? ''));
$main_concept = trim((string)($payload['main_concept'] ?? ''));
$instruction = trim((string)($payload['instruction'] ?? ''));
$questions = $payload['questions'] ?? [];
$rubric = $payload['rubric'] ?? [];

if ($workshop_id <= 0) jsonFail('Missing workshop_id');
if ($open_time === '') jsonFail('Missing open_time');
if ($close_time === '') jsonFail('Missing close_time');
if ($objective === '') jsonFail('Missing objective');
if ($main_concept === '') jsonFail('Missing main_concept');
if ($instruction === '') jsonFail('Missing instruction');
if (!is_array($questions) || count($questions) === 0) jsonFail('Missing questions');
if (count($questions) > 10) jsonFail('Too many questions (max 10)');

// Rubric is configured at workshop-level (required)
if (!is_array($rubric) || count($rubric) === 0) jsonFail('Missing rubric');
if (count($rubric) > 10) jsonFail('Too many rubric items (max 10)');

// Validate score sum = 100 (server-side guard)
$totalScore = 0;
foreach ($questions as $q) {
    $score = isset($q['score']) ? intval($q['score']) : 0;
    $totalScore += $score;

    $type = $q['type'] ?? '';
    $text = trim((string)($q['text'] ?? ''));
    if ($text === '') jsonFail('Question text is required');
    if ($score <= 0) jsonFail('Question score must be > 0');

    if ($type === 'choice') {
        $choices = $q['choices'] ?? [];
        $answer = $q['answer'] ?? null;
        if (!is_array($choices) || count($choices) < 2) jsonFail('Choice question must have at least 2 choices');
        if (count($choices) > 4) jsonFail('Choice question must have at most 4 choices');
        foreach ($choices as $c) {
            if (trim((string)$c) === '') jsonFail('Choice text is required');
        }
        if (!is_int($answer) && !ctype_digit((string)$answer)) jsonFail('Choice answer is required');
    } else {
        jsonFail('Invalid question type (only choice is supported)');
    }
}

// Validate workshop-level rubric
foreach ($rubric as $item) {
    if (!is_array($item)) jsonFail('Invalid rubric item');
    $title = trim((string)($item['title'] ?? ''));
    if ($title === '') jsonFail('Rubric title is required');

    $levelCount = intval($item['level_count'] ?? 0);
    if (!in_array($levelCount, [3, 5], true)) jsonFail('Rubric level_count must be 3 or 5');

    $desc = $item['desc'] ?? [];
    if (!is_array($desc) || count($desc) !== $levelCount) jsonFail('Rubric desc must match level_count');
    foreach ($desc as $d) {
        if (trim((string)$d) === '') jsonFail('Rubric description is required');
    }
}

if ($totalScore !== 100) {
    jsonFail('Total score must equal 100');
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Minimal schema: store questions as JSON for now
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

    $stmt = $db->prepare(
        "INSERT INTO elk_workshops (id, open_time, close_time, objective, main_concept, instruction, questions_json, rubric_json, created_by, updated_by)\n" .
        "VALUES (:id, :open_time, :close_time, :objective, :main_concept, :instruction, :questions_json, :rubric_json, :created_by, :updated_by)\n" .
        "ON DUPLICATE KEY UPDATE\n" .
        "  open_time = VALUES(open_time),\n" .
        "  close_time = VALUES(close_time),\n" .
        "  objective = VALUES(objective),\n" .
        "  main_concept = VALUES(main_concept),\n" .
        "  instruction = VALUES(instruction),\n" .
        "  questions_json = VALUES(questions_json),\n" .
        "  rubric_json = VALUES(rubric_json),\n" .
        "  updated_by = VALUES(updated_by)"
    );

    $questionsJson = json_encode($questions, JSON_UNESCAPED_UNICODE);
    if ($questionsJson === false) {
        jsonFail('Failed to encode questions', 500);
    }

    $rubricJson = json_encode($rubric, JSON_UNESCAPED_UNICODE);
    if ($rubricJson === false) {
        jsonFail('Failed to encode rubric', 500);
    }

    $stmt->execute([
        ':id' => $workshop_id,
        ':open_time' => $open_time,
        ':close_time' => $close_time,
        ':objective' => $objective,
        ':main_concept' => $main_concept,
        ':instruction' => $instruction,
        ':questions_json' => $questionsJson,
        ':rubric_json' => $rubricJson,
        ':created_by' => isset($credential_user_id) ? intval($credential_user_id) : null,
        ':updated_by' => isset($credential_user_id) ? intval($credential_user_id) : null,
    ]);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'บันทึกข้อมูลสำเร็จ',
        'workshop_id' => $workshop_id,
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ]);
}

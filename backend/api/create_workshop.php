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
$instruction = trim((string)($payload['instruction'] ?? ''));
$questions = $payload['questions'] ?? [];

if ($workshop_id <= 0) jsonFail('Missing workshop_id');
if ($open_time === '') jsonFail('Missing open_time');
if ($close_time === '') jsonFail('Missing close_time');
if ($objective === '') jsonFail('Missing objective');
if ($instruction === '') jsonFail('Missing instruction');
if (!is_array($questions) || count($questions) === 0) jsonFail('Missing questions');
if (count($questions) > 10) jsonFail('Too many questions (max 10)');

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
    } elseif ($type === 'open') {
        $rubric_desc = $q['rubric_desc'] ?? [];
        $rubric_score = $q['rubric_score'] ?? [];
        if (!is_array($rubric_desc) || !is_array($rubric_score) || count($rubric_desc) !== 5 || count($rubric_score) !== 5) {
            jsonFail('Open question must have 5-level rubric');
        }
    } else {
        jsonFail('Invalid question type');
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
        "  instruction TEXT NOT NULL,\n" .
        "  questions_json JSON NOT NULL,\n" .
        "  created_by INT NULL,\n" .
        "  updated_by INT NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $stmt = $db->prepare(
        "INSERT INTO elk_workshops (id, open_time, close_time, objective, instruction, questions_json, created_by, updated_by)\n" .
        "VALUES (:id, :open_time, :close_time, :objective, :instruction, :questions_json, :created_by, :updated_by)\n" .
        "ON DUPLICATE KEY UPDATE\n" .
        "  open_time = VALUES(open_time),\n" .
        "  close_time = VALUES(close_time),\n" .
        "  objective = VALUES(objective),\n" .
        "  instruction = VALUES(instruction),\n" .
        "  questions_json = VALUES(questions_json),\n" .
        "  updated_by = VALUES(updated_by)"
    );

    $questionsJson = json_encode($questions, JSON_UNESCAPED_UNICODE);
    if ($questionsJson === false) {
        jsonFail('Failed to encode questions', 500);
    }

    $stmt->execute([
        ':id' => $workshop_id,
        ':open_time' => $open_time,
        ':close_time' => $close_time,
        ':objective' => $objective,
        ':instruction' => $instruction,
        ':questions_json' => $questionsJson,
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

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

if (!isset($credential_user_id) || intval($credential_user_id) <= 0) {
    jsonFail('Unauthorized', 401);
}

// Only teacher/admin can grade
if (!isset($credential_user_type) || !in_array((string)$credential_user_type, ['teacher', 'admin'], true)) {
    jsonFail('Forbidden', 403);
}

$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'application/json') === false) {
    jsonFail('Content-Type must be application/json');
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) {
    jsonFail('Invalid JSON payload');
}

$attemptId = isset($payload['attempt_id']) ? intval($payload['attempt_id']) : 0;
$grades = $payload['grades'] ?? [];

if ($attemptId <= 0) jsonFail('Missing attempt_id');
if (!is_array($grades) || count($grades) === 0) jsonFail('grades must be a non-empty array');

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Ensure tables exist (same as submit endpoint)
    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_workshop_attempts (\n" .
        "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
        "  workshop_id INT NOT NULL,\n" .
        "  user_id INT NOT NULL,\n" .
        "  status ENUM('submitted','pending_manual','graded') NOT NULL DEFAULT 'submitted',\n" .
        "  submitted_at DATETIME NULL,\n" .
        "  score_auto INT NOT NULL DEFAULT 0,\n" .
        "  score_manual INT NOT NULL DEFAULT 0,\n" .
        "  score_total INT NOT NULL DEFAULT 0,\n" .
        "  max_score_auto INT NOT NULL DEFAULT 0,\n" .
        "  max_score_manual INT NOT NULL DEFAULT 0,\n" .
        "  max_score_total INT NOT NULL DEFAULT 0,\n" .
        "  needs_manual TINYINT(1) NOT NULL DEFAULT 0,\n" .
        "  reviewed_by INT NULL,\n" .
        "  reviewed_at DATETIME NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (id),\n" .
        "  INDEX idx_attempt_user (user_id),\n" .
        "  INDEX idx_attempt_workshop (workshop_id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_workshop_attempt_answers (\n" .
        "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
        "  attempt_id BIGINT NOT NULL,\n" .
        "  workshop_id INT NOT NULL,\n" .
        "  user_id INT NOT NULL,\n" .
        "  question_index INT NOT NULL,\n" .
        "  question_type ENUM('choice','open') NOT NULL,\n" .
        "  question_text TEXT NULL,\n" .
        "  max_score INT NOT NULL DEFAULT 0,\n" .
        "  selected_choice INT NULL,\n" .
        "  correct_choice INT NULL,\n" .
        "  answer_text TEXT NULL,\n" .
        "  is_correct TINYINT(1) NULL,\n" .
        "  score_auto INT NOT NULL DEFAULT 0,\n" .
        "  score_manual INT NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (id),\n" .
        "  UNIQUE KEY uniq_attempt_q (attempt_id, question_index),\n" .
        "  INDEX idx_attempt_id (attempt_id),\n" .
        "  INDEX idx_answer_user (user_id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $stmt = $db->prepare('SELECT id, workshop_id, user_id, score_auto, max_score_auto, max_score_manual, max_score_total, needs_manual FROM elk_workshop_attempts WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $attemptId]);
    $attempt = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$attempt) {
        jsonFail('Attempt not found', 404);
    }

    if (intval($attempt['needs_manual'] ?? 0) !== 1) {
        jsonFail('Attempt has no manual-graded questions', 400);
    }

    // Normalize grade map
    $gradeByIndex = [];
    foreach ($grades as $g) {
        if (!is_array($g)) continue;
        $idx = isset($g['question_index']) ? intval($g['question_index']) : null;
        $score = isset($g['score']) ? intval($g['score']) : null;
        if ($idx === null || $idx < 0) continue;
        if ($score === null || $score < 0) $score = 0;
        $gradeByIndex[$idx] = $score;
    }

    if (count($gradeByIndex) === 0) {
        jsonFail('No valid grades');
    }

    // Fetch open answers for this attempt
    $stmtAns = $db->prepare('SELECT id, question_index, max_score, question_type FROM elk_workshop_attempt_answers WHERE attempt_id = :attempt_id AND question_type = \'open\'');
    $stmtAns->execute([':attempt_id' => $attemptId]);
    $openAnswers = $stmtAns->fetchAll(PDO::FETCH_ASSOC);

    if (!$openAnswers || count($openAnswers) === 0) {
        jsonFail('No open answers found for this attempt', 400);
    }

    $updateOne = $db->prepare('UPDATE elk_workshop_attempt_answers SET score_manual = :score_manual WHERE attempt_id = :attempt_id AND question_index = :question_index AND question_type = \'open\'');

    $manualSum = 0;
    $gradedCount = 0;

    foreach ($openAnswers as $row) {
        $qIndex = intval($row['question_index'] ?? -1);
        $maxScore = intval($row['max_score'] ?? 0);
        if (!array_key_exists($qIndex, $gradeByIndex)) {
            continue;
        }

        $score = intval($gradeByIndex[$qIndex]);
        if ($score < 0) $score = 0;
        if ($score > $maxScore) {
            jsonFail('Score exceeds max_score for question_index ' . $qIndex);
        }

        $updateOne->execute([
            ':score_manual' => $score,
            ':attempt_id' => $attemptId,
            ':question_index' => $qIndex,
        ]);

        $manualSum += $score;
        $gradedCount++;
    }

    if ($gradedCount === 0) {
        jsonFail('No matching open questions to grade', 400);
    }

    $scoreAuto = intval($attempt['score_auto'] ?? 0);
    $scoreTotal = $scoreAuto + $manualSum;

    $updateAttempt = $db->prepare(
        'UPDATE elk_workshop_attempts ' .
        'SET status = \'graded\', score_manual = :score_manual, score_total = :score_total, reviewed_by = :reviewed_by, reviewed_at = NOW() ' .
        'WHERE id = :id'
    );
    $updateAttempt->execute([
        ':score_manual' => $manualSum,
        ':score_total' => $scoreTotal,
        ':reviewed_by' => intval($credential_user_id),
        ':id' => $attemptId,
    ]);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'graded',
        'attempt_id' => $attemptId,
        'score_auto' => $scoreAuto,
        'score_manual' => $manualSum,
        'score_total' => $scoreTotal,
        'max_score_total' => intval($attempt['max_score_total'] ?? 0),
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

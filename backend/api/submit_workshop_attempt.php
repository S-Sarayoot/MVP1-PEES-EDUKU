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

function normalizeChoiceIndex($value)
{
    if ($value === null) return null;
    if (is_int($value)) return $value;
    if (is_string($value) && ctype_digit($value)) return intval($value);
    return null;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonFail('Invalid request method', 405);
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

$workshopId = isset($payload['workshop_id']) ? intval($payload['workshop_id']) : 0;
$answers = $payload['answers'] ?? [];

if ($workshopId <= 0) jsonFail('Missing workshop_id');
if (!is_array($answers)) jsonFail('answers must be an array');
if (!isset($credential_user_id) || intval($credential_user_id) <= 0) jsonFail('Unauthorized', 401);

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // // Workshop table (shared with create_workshop.php)
    // $db->exec(
    //     "CREATE TABLE IF NOT EXISTS elk_workshops (\n" .
    //     "  id INT NOT NULL AUTO_INCREMENT,\n" .
    //     "  open_time DATETIME NOT NULL,\n" .
    //     "  close_time DATETIME NOT NULL,\n" .
    //     "  objective TEXT NOT NULL,\n" .
    //     "  instruction TEXT NOT NULL,\n" .
    //     "  questions_json JSON NOT NULL,\n" .
    //     "  created_by INT NULL,\n" .
    //     "  updated_by INT NULL,\n" .
    //     "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
    //     "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
    //     "  PRIMARY KEY (id)\n" .
    //     ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    // );

    // // Attempts schema
    // $db->exec(
    //     "CREATE TABLE IF NOT EXISTS elk_workshop_attempts (\n" .
    //     "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
    //     "  workshop_id INT NOT NULL,\n" .
    //     "  user_id INT NOT NULL,\n" .
    //     "  status ENUM('submitted','pending_manual','graded') NOT NULL DEFAULT 'submitted',\n" .
    //     "  submitted_at DATETIME NULL,\n" .
    //     "  score_auto INT NOT NULL DEFAULT 0,\n" .
    //     "  score_manual INT NOT NULL DEFAULT 0,\n" .
    //     "  score_total INT NOT NULL DEFAULT 0,\n" .
    //     "  max_score_auto INT NOT NULL DEFAULT 0,\n" .
    //     "  max_score_manual INT NOT NULL DEFAULT 0,\n" .
    //     "  max_score_total INT NOT NULL DEFAULT 0,\n" .
    //     "  needs_manual TINYINT(1) NOT NULL DEFAULT 0,\n" .
    //     "  reviewed_by INT NULL,\n" .
    //     "  reviewed_at DATETIME NULL,\n" .
    //     "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
    //     "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
    //     "  PRIMARY KEY (id),\n" .
    //     "  INDEX idx_attempt_user (user_id),\n" .
    //     "  INDEX idx_attempt_workshop (workshop_id)\n" .
    //     ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    // );

    // $db->exec(
    //     "CREATE TABLE IF NOT EXISTS elk_workshop_attempt_answers (\n" .
    //     "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
    //     "  attempt_id BIGINT NOT NULL,\n" .
    //     "  workshop_id INT NOT NULL,\n" .
    //     "  user_id INT NOT NULL,\n" .
    //     "  question_index INT NOT NULL,\n" .
    //     "  question_type ENUM('choice','open') NOT NULL,\n" .
    //     "  question_text TEXT NULL,\n" .
    //     "  max_score INT NOT NULL DEFAULT 0,\n" .
    //     "  selected_choice INT NULL,\n" .
    //     "  correct_choice INT NULL,\n" .
    //     "  answer_text TEXT NULL,\n" .
    //     "  is_correct TINYINT(1) NULL,\n" .
    //     "  score_auto INT NOT NULL DEFAULT 0,\n" .
    //     "  score_manual INT NULL,\n" .
    //     "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
    //     "  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\n" .
    //     "  PRIMARY KEY (id),\n" .
    //     "  UNIQUE KEY uniq_attempt_q (attempt_id, question_index),\n" .
    //     "  INDEX idx_attempt_id (attempt_id),\n" .
    //     "  INDEX idx_answer_user (user_id)\n" .
    //     ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    // );

    // Load workshop questions
    $stmt = $db->prepare('SELECT id, questions_json, open_time, close_time FROM elk_workshops WHERE id = :id LIMIT 1');
    $stmt->execute([':id' => $workshopId]);
    $workshopRow = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$workshopRow) {
        jsonFail('Workshop not found', 404);
    }

    // Time gate (server-side)
    $now = new DateTime('now');
    $openTime = new DateTime($workshopRow['open_time']);
    $closeTime = new DateTime($workshopRow['close_time']);
    if ($now < $openTime) {
        jsonFail('Workshop is not open yet', 403);
    }
    if ($now > $closeTime) {
        jsonFail('Workshop is closed', 403);
    }

    $questions = json_decode($workshopRow['questions_json'] ?? '[]', true);
    if (!is_array($questions)) $questions = [];
    if (count($questions) === 0) {
        jsonFail('Workshop has no questions', 400);
    }

    $db->beginTransaction();

    // Build answers map: index -> answer payload
    $answersByIndex = [];
    foreach ($answers as $a) {
        if (!is_array($a)) continue;
        $idx = isset($a['index']) ? intval($a['index']) : null;
        if ($idx === null || $idx < 0) continue;
        $answersByIndex[$idx] = $a;
    }

    // Validate all questions answered
    for ($i = 0; $i < count($questions); $i++) {
        if (!array_key_exists($i, $answersByIndex)) {
            jsonFail('Missing answer for question index ' . $i);
        }
    }

    $userId = intval($credential_user_id);

    $scoreAuto = 0;
    $maxScoreAuto = 0;
    $maxScoreManual = 0;
    $needsManual = false;

    // Reuse attempt (latest) for this user+workshop; create on first submit
    $findAttempt = $db->prepare(
        'SELECT id FROM elk_workshop_attempts WHERE workshop_id = :workshop_id AND user_id = :user_id ORDER BY id DESC LIMIT 1'
    );
    $findAttempt->execute([
        ':workshop_id' => $workshopId,
        ':user_id' => $userId,
    ]);
    $existingAttempt = $findAttempt->fetch(PDO::FETCH_ASSOC);

    if ($existingAttempt && isset($existingAttempt['id'])) {
        $attemptId = intval($existingAttempt['id']);
        if ($attemptId <= 0) {
            jsonFail('Invalid attempt id', 500);
        }

        // Reset attempt state for resubmission (clear manual review, scores)
        $resetAttempt = $db->prepare(
            'UPDATE elk_workshop_attempts ' .
            'SET status = :status, submitted_at = NOW(), score_auto = 0, score_manual = 0, score_total = 0, ' .
            '    max_score_auto = 0, max_score_manual = 0, max_score_total = 0, needs_manual = 0, ' .
            '    reviewed_by = NULL, reviewed_at = NULL ' .
            'WHERE id = :id'
        );
        $resetAttempt->execute([
            ':status' => 'submitted',
            ':id' => $attemptId,
        ]);

        // Replace all previous answers with the latest submission
        $deleteAnswers = $db->prepare('DELETE FROM elk_workshop_attempt_answers WHERE attempt_id = :attempt_id');
        $deleteAnswers->execute([':attempt_id' => $attemptId]);
    } else {
        // Create attempt
        $insertAttempt = $db->prepare(
            'INSERT INTO elk_workshop_attempts (workshop_id, user_id, status, submitted_at, score_auto, score_manual, score_total, max_score_auto, max_score_manual, max_score_total, needs_manual) ' .
            'VALUES (:workshop_id, :user_id, :status, NOW(), 0, 0, 0, 0, 0, 0, 0)'
        );
        $insertAttempt->execute([
            ':workshop_id' => $workshopId,
            ':user_id' => $userId,
            ':status' => 'submitted',
        ]);

        $attemptId = intval($db->lastInsertId());
        if ($attemptId <= 0) {
            jsonFail('Failed to create attempt', 500);
        }
    }

    $insertAnswer = $db->prepare(
        'INSERT INTO elk_workshop_attempt_answers (attempt_id, workshop_id, user_id, question_index, question_type, question_text, max_score, selected_choice, correct_choice, answer_text, is_correct, score_auto, score_manual) ' .
        'VALUES (:attempt_id, :workshop_id, :user_id, :question_index, :question_type, :question_text, :max_score, :selected_choice, :correct_choice, :answer_text, :is_correct, :score_auto, :score_manual)'
    );

    for ($i = 0; $i < count($questions); $i++) {
        $q = $questions[$i];
        if (!is_array($q)) $q = [];

        $qType = ($q['type'] ?? 'choice') === 'open' ? 'open' : 'choice';
        $qText = trim((string)($q['text'] ?? ''));
        $qScore = intval($q['score'] ?? 0);
        if ($qScore < 0) $qScore = 0;

        $a = $answersByIndex[$i];

        if ($qType === 'choice') {
            $selected = normalizeChoiceIndex($a['answer'] ?? null);
            if ($selected === null) {
                jsonFail('Missing choice answer for question index ' . $i);
            }

            $correct = normalizeChoiceIndex($q['answer'] ?? null);
            if ($correct === null) {
                jsonFail('Workshop question missing correct answer for question index ' . $i, 500);
            }

            $isCorrect = ($selected === $correct);
            $scoreThis = $isCorrect ? $qScore : 0;

            $scoreAuto += $scoreThis;
            $maxScoreAuto += $qScore;

            $insertAnswer->execute([
                ':attempt_id' => $attemptId,
                ':workshop_id' => $workshopId,
                ':user_id' => $userId,
                ':question_index' => $i,
                ':question_type' => 'choice',
                ':question_text' => $qText,
                ':max_score' => $qScore,
                ':selected_choice' => $selected,
                ':correct_choice' => $correct,
                ':answer_text' => null,
                ':is_correct' => $isCorrect ? 1 : 0,
                ':score_auto' => $scoreThis,
                ':score_manual' => null,
            ]);
        } else {
            $answerText = trim((string)($a['answer'] ?? ''));
            if ($answerText === '') {
                jsonFail('Missing open answer for question index ' . $i);
            }

            $needsManual = true;
            $maxScoreManual += $qScore;

            $insertAnswer->execute([
                ':attempt_id' => $attemptId,
                ':workshop_id' => $workshopId,
                ':user_id' => $userId,
                ':question_index' => $i,
                ':question_type' => 'open',
                ':question_text' => $qText,
                ':max_score' => $qScore,
                ':selected_choice' => null,
                ':correct_choice' => null,
                ':answer_text' => $answerText,
                ':is_correct' => null,
                ':score_auto' => 0,
                ':score_manual' => null,
            ]);
        }
    }

    $maxScoreTotal = $maxScoreAuto + $maxScoreManual;
    $status = $needsManual ? 'pending_manual' : 'graded';

    $updateAttempt = $db->prepare(
        'UPDATE elk_workshop_attempts ' .
        'SET status = :status, submitted_at = NOW(), score_auto = :score_auto, score_manual = :score_manual, score_total = :score_total, ' .
        '    max_score_auto = :max_score_auto, max_score_manual = :max_score_manual, max_score_total = :max_score_total, ' .
        '    needs_manual = :needs_manual ' .
        'WHERE id = :id'
    );

    $updateAttempt->execute([
        ':status' => $status,
        ':score_auto' => $scoreAuto,
        ':score_manual' => 0,
        ':score_total' => $scoreAuto,
        ':max_score_auto' => $maxScoreAuto,
        ':max_score_manual' => $maxScoreManual,
        ':max_score_total' => $maxScoreTotal,
        ':needs_manual' => $needsManual ? 1 : 0,
        ':id' => $attemptId,
    ]);

    $db->commit();

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'submitted',
        'attempt_id' => $attemptId,
        'workshop_id' => $workshopId,
        'score_auto' => $scoreAuto,
        'max_score_auto' => $maxScoreAuto,
        'pending_manual' => $needsManual,
        'max_score_total' => $maxScoreTotal,
        'score_total_current' => $scoreAuto,
    ], JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    if (isset($db) && $db instanceof PDO && $db->inTransaction()) {
        $db->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage(),
    ], JSON_UNESCAPED_UNICODE);
}

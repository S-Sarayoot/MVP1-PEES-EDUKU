<?php

header('Content-Type: application/json; charset=utf-8');

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

if (!isset($credential_user_type) || $credential_user_type !== 'admin') {
    jsonFail('Forbidden', 403);
}

function safeCount(PDO $db, string $sql, array $params = []): int
{
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    } catch (Throwable $e) {
        return 0;
    }
}

function safeQuery(PDO $db, string $sql, array $params = []): array
{
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        return [];
    }
}

function ensureColumnExists(PDO $db, string $table, string $column, string $definition): void
{
    try {
        $stmt = $db->prepare(
            "SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS\n" .
            "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c LIMIT 1"
        );
        $stmt->execute([':t' => $table, ':c' => $column]);
        $exists = (bool)$stmt->fetchColumn();
        if (!$exists) {
            $db->exec("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
        }
    } catch (Throwable $e) {
        // ignore
    }
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // Ensure optional tables exist
    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_user_login_log (\n" .
        "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
        "  user_id INT NOT NULL,\n" .
        "  user_type VARCHAR(50) NULL,\n" .
        "  username VARCHAR(255) NULL,\n" .
        "  ip_address VARCHAR(45) NULL,\n" .
        "  user_agent VARCHAR(255) NULL,\n" .
        "  login_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (id),\n" .
        "  INDEX idx_login_at (login_at),\n" .
        "  INDEX idx_user_id (user_id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    // In case the table existed before these columns were added
    ensureColumnExists($db, 'elk_user_login_log', 'ip_address', 'VARCHAR(45) NULL');
    ensureColumnExists($db, 'elk_user_login_log', 'user_agent', 'VARCHAR(255) NULL');

    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_backup_logs (\n" .
        "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
        "  backup_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n" .
        "  note VARCHAR(255) NULL,\n" .
        "  PRIMARY KEY (id),\n" .
        "  INDEX idx_backup_at (backup_at)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    // Counts: Teaching media
    $teachingMediaTotal = safeCount($db, 'SELECT COUNT(*) FROM elk_post');
    //$lessonPlanInStore = safeCount($db, "SELECT COUNT(*) FROM elk_teaching_media WHERE category = 'lesson_plan'");

    // Counts: Users
    $usersTotal = safeCount($db, 'SELECT COUNT(*) FROM elk_user WHERE status <> 0');
    $usersStudent = safeCount($db, "SELECT COUNT(*) FROM elk_user WHERE status <> 0 AND user_type = 'student'");
    $usersTeacher = safeCount($db, "SELECT COUNT(*) FROM elk_user WHERE status <> 0 AND user_type = 'teacher'");
    $usersAdmin = safeCount($db, "SELECT COUNT(*) FROM elk_user WHERE status <> 0 AND user_type = 'admin'");

    // Today's access (distinct logins today)
    $loginsToday = safeCount($db, 'SELECT COUNT(DISTINCT user_id) FROM elk_user_login_log WHERE DATE(login_at) = CURDATE()');

    // Workshop plans (selected posts per workshop)
    $db->exec(
        "CREATE TABLE IF NOT EXISTS elk_workshop_posts (\n" .
        "  workshop_id INT NOT NULL,\n" .
        "  post_id INT NOT NULL,\n" .
        "  created_by INT NULL,\n" .
        "  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n" .
        "  PRIMARY KEY (workshop_id, post_id)\n" .
        ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $wsCounts = [1 => 0, 2 => 0, 3 => 0];
    $wsRows = safeQuery(
        $db,
        'SELECT workshop_id, COUNT(*) AS c FROM elk_workshop_posts WHERE workshop_id IN (1,2,3) GROUP BY workshop_id'
    );
    foreach ($wsRows as $r) {
        $wid = (int) ($r['workshop_id'] ?? 0);
        if ($wid >= 1 && $wid <= 3) {
            $wsCounts[$wid] = (int) ($r['c'] ?? 0);
        }
    }
    $wsTotal = (int) ($wsCounts[1] + $wsCounts[2] + $wsCounts[3]);

    // Selected plans total = all linked workshop posts
    $selectedPlansTotal = safeCount($db, 'SELECT COUNT(*) FROM elk_workshop_posts');

    // Recent activity: combine latest teaching media + posts + new users (best-effort)
    $activities = [];

    // Recent logins
    $loginRows = safeQuery($db, 'SELECT user_type, username, ip_address, login_at FROM elk_user_login_log ORDER BY id DESC LIMIT 5');
    if (!$loginRows) {
        $loginRows = safeQuery($db, 'SELECT user_type, username, login_at FROM elk_user_login_log ORDER BY id DESC LIMIT 5');
    }
    foreach ($loginRows as $r) {
        $ut = $r['user_type'] ?? '-';
        $un = $r['username'] ?? '-';
        $ip = $r['ip_address'] ?? null;
        $detail = $ut . ' [' . $un . ']';
        if ($ip) $detail .= ' (' . $ip . ')';
        $activities[] = [
            'when' => $r['login_at'] ?? null,
            'label' => 'เข้าสู่ระบบ',
            'detail' => $detail,
        ];
    }

    $tmRows = safeQuery($db, 'SELECT id, file_name, category, uploaded_by, created_at FROM elk_teaching_media ORDER BY id DESC LIMIT 5');
    if (!$tmRows) {
        $tmRows = safeQuery($db, 'SELECT id, file_name, category, uploaded_by FROM elk_teaching_media ORDER BY id DESC LIMIT 5');
    }
    foreach ($tmRows as $r) {
        $when = $r['created_at'] ?? null;
        $activities[] = [
            'when' => $when,
            'label' => 'อัปโหลดสื่อการสอน',
            'detail' => ($r['file_name'] ?? '-') . ' (' . ($r['category'] ?? '-') . ')',
        ];
    }

    $postRows = safeQuery($db, 'SELECT id, title, category, created_at FROM elk_post ORDER BY id DESC LIMIT 5');
    foreach ($postRows as $r) {
        $activities[] = [
            'when' => $r['created_at'] ?? null,
            'label' => 'เพิ่มทรัพยากร',
            'detail' => ($r['title'] ?? '-') . ' (' . ($r['category'] ?? '-') . ')',
        ];
    }

    $userRows = safeQuery($db, 'SELECT user_id, user_type, user_code, username, create_date FROM elk_user ORDER BY user_id DESC LIMIT 5');
    if (!$userRows) {
        $userRows = safeQuery($db, 'SELECT user_id, user_type, user_code, username FROM elk_user ORDER BY user_id DESC LIMIT 5');
    }
    foreach ($userRows as $r) {
        $who = $r['user_code'] ?? ($r['username'] ?? '-');
        $activities[] = [
            'when' => $r['create_date'] ?? null,
            'label' => 'สร้างผู้ใช้งาน',
            'detail' => ($r['user_type'] ?? '-') . ' [' . $who . ']',
        ];
    }

    // Sort by time when available (desc), keep stable otherwise.
    usort($activities, function ($a, $b) {
        $ta = strtotime((string)($a['when'] ?? ''));
        $tb = strtotime((string)($b['when'] ?? ''));
        if (!$ta && !$tb) return 0;
        if (!$ta) return 1;
        if (!$tb) return -1;
        return $tb <=> $ta;
    });
    $activities = array_slice($activities, 0, 6);

    // Backup last date
    $backupAt = null;
    $b = safeQuery($db, 'SELECT backup_at FROM elk_backup_logs ORDER BY backup_at DESC LIMIT 1');
    if ($b && isset($b[0]['backup_at'])) {
        $backupAt = $b[0]['backup_at'];
    }

    echo json_encode([
        'success' => true,
        'teaching_media_total' => $teachingMediaTotal,
        //'lesson_plan_in_store' => $lessonPlanInStore,
        'users_total' => $usersTotal,
        'users_student' => $usersStudent,
        'users_teacher' => $usersTeacher,
        'users_admin' => $usersAdmin,
        'access_today' => $loginsToday,
        'workshop_plans' => [
            'w1' => $wsCounts[1],
            'w2' => $wsCounts[2],
            'w3' => $wsCounts[3],
            'total' => $wsTotal,
        ],
        'selected_plans_total' => $selectedPlansTotal,
        'recent_activities' => $activities,
        'backup_last_at' => $backupAt,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error: ' . $e->getMessage(), 500);
}

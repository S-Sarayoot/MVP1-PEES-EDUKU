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

function safeQuery(PDO $db, string $sql, array $params = []): array
{
    try {
        $stmt = $db->prepare($sql);
        foreach ($params as $k => $v) {
            if (is_int($v)) {
                $stmt->bindValue($k, $v, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($k, $v);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Throwable $e) {
        return [];
    }
}

try {
    $database = new Database();
    $db = $database->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
    if ($limit <= 0) $limit = 100;
    if ($limit > 500) $limit = 500;

    $items = [];

    // Logins
    $loginRows = safeQuery(
        $db,
        'SELECT user_type, username, ip_address, login_at FROM elk_user_login_log ORDER BY id DESC LIMIT ' . $limit
    );
    if (!$loginRows) {
        $loginRows = safeQuery(
            $db,
            'SELECT user_type, username, login_at FROM elk_user_login_log ORDER BY id DESC LIMIT ' . $limit
        );
    }
    foreach ($loginRows as $r) {
        $ut = $r['user_type'] ?? '-';
        $un = $r['username'] ?? '-';
        $ip = $r['ip_address'] ?? null;
        $who = $ut . ' [' . $un . ']';
        if ($ip) $who .= ' (' . $ip . ')';
        $items[] = [
            'when' => $r['login_at'] ?? null,
            'who' => $who,
            'action' => 'เข้าสู่ระบบ',
        ];
    }

    // Teaching media uploads
    $tmRows = safeQuery(
        $db,
        'SELECT tm.id, tm.file_name, tm.category, tm.created_at, tm.uploaded_by, u.user_type AS uploader_type, u.user_code AS uploader_code, u.username AS uploader_username '
            . 'FROM elk_teaching_media tm '
            . 'LEFT JOIN elk_user u ON u.user_id = tm.uploaded_by '
            . 'ORDER BY tm.id DESC LIMIT ' . $limit
    );
    if (!$tmRows) {
        $tmRows = safeQuery(
            $db,
            'SELECT id, file_name, category, created_at, uploaded_by FROM elk_teaching_media ORDER BY id DESC LIMIT ' . $limit
        );
    }
    foreach ($tmRows as $r) {
        $who = 'ผู้ใช้งาน';
        $ut = $r['uploader_type'] ?? null;
        $uc = $r['uploader_code'] ?? null;
        $un = $r['uploader_username'] ?? null;
        if ($ut || $uc || $un) {
            $code = $uc ?: ($un ?: '-');
            $who = ($ut ?: '-') . ' [' . $code . ']';
        } elseif (isset($r['uploaded_by']) && $r['uploaded_by'] !== null) {
            $who = 'ผู้ใช้งาน [' . $r['uploaded_by'] . ']';
        }

        $file = $r['file_name'] ?? '-';
        $cat = $r['category'] ?? '-';
        $items[] = [
            'when' => $r['created_at'] ?? null,
            'who' => $who,
            'action' => 'อัปโหลดสื่อการสอน: ' . $file . ' (' . $cat . ')',
        ];
    }

    // Resource posts
    $postRows = safeQuery(
        $db,
        'SELECT p.id, p.title, p.category, p.created_at, p.created_by, u.user_type AS creator_type, u.user_code AS creator_code, u.username AS creator_username '
            . 'FROM elk_post p '
            . 'LEFT JOIN elk_user u ON u.user_id = p.created_by '
            . 'ORDER BY p.id DESC LIMIT ' . $limit
    );
    if (!$postRows) {
        $postRows = safeQuery(
            $db,
            'SELECT id, title, category, created_at FROM elk_post ORDER BY id DESC LIMIT ' . $limit
        );
    }
    foreach ($postRows as $r) {
        $who = 'ระบบ';
        $ut = $r['creator_type'] ?? null;
        $uc = $r['creator_code'] ?? null;
        $un = $r['creator_username'] ?? null;
        if ($ut || $uc || $un) {
            $code = $uc ?: ($un ?: '-');
            $who = ($ut ?: '-') . ' [' . $code . ']';
        } elseif (isset($r['created_by']) && $r['created_by'] !== null) {
            $who = 'ผู้ใช้งาน [' . $r['created_by'] . ']';
        }

        $title = $r['title'] ?? '-';
        $cat = $r['category'] ?? '-';
        $items[] = [
            'when' => $r['created_at'] ?? null,
            'who' => $who,
            'action' => 'เพิ่มทรัพยากร: ' . $title . ' (' . $cat . ')',
        ];
    }

    // User creation
    $userRows = safeQuery(
        $db,
        'SELECT user_id, user_type, user_code, username, create_date FROM elk_user ORDER BY user_id DESC LIMIT ' . $limit
    );
    if (!$userRows) {
        $userRows = safeQuery(
            $db,
            'SELECT user_id, user_type, user_code, username FROM elk_user ORDER BY user_id DESC LIMIT ' . $limit
        );
    }
    foreach ($userRows as $r) {
        $whoCode = $r['user_code'] ?? ($r['username'] ?? '-');
        $items[] = [
            'when' => $r['create_date'] ?? null,
            'who' => ($r['user_type'] ?? '-') . ' [' . $whoCode . ']',
            'action' => 'สร้างผู้ใช้งาน',
        ];
    }

    // Workshop submissions
    $attemptRows = safeQuery(
        $db,
        'SELECT a.id, a.workshop_id, a.submitted_at, u.user_type, u.user_code, u.username '
            . 'FROM elk_workshop_attempts a '
            . 'LEFT JOIN elk_user u ON u.user_id = a.user_id '
            . 'WHERE a.submitted_at IS NOT NULL '
            . 'ORDER BY a.id DESC LIMIT ' . $limit
    );
    foreach ($attemptRows as $r) {
        $code = $r['user_code'] ?? ($r['username'] ?? '-');
        $items[] = [
            'when' => $r['submitted_at'] ?? null,
            'who' => ($r['user_type'] ?? '-') . ' [' . $code . ']',
            'action' => 'ส่งกิจกรรม Workshop ' . ($r['workshop_id'] ?? '-'),
        ];
    }

    // Sort by time desc
    usort($items, function ($a, $b) {
        $ta = strtotime((string)($a['when'] ?? ''));
        $tb = strtotime((string)($b['when'] ?? ''));
        if (!$ta && !$tb) return 0;
        if (!$ta) return 1;
        if (!$tb) return -1;
        return $tb <=> $ta;
    });

    $items = array_slice($items, 0, $limit);

    echo json_encode([
        'success' => true,
        'data' => $items,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error: ' . $e->getMessage(), 500);
}

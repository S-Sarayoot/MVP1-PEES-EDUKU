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

function safeJsonDecodeArray($raw): array
{
    if ($raw === null || $raw === '') return [];
    $decoded = json_decode((string)$raw, true);
    return is_array($decoded) ? $decoded : [];
}

function computeThumb(array $post): string
{
    // Match thumbnail logic used in backend/api/get_posts.php
    $thumb = '../image/no-thumbnail.png';

    $images = safeJsonDecodeArray($post['images'] ?? null);
    $videos = safeJsonDecodeArray($post['videos'] ?? null);
    $files  = safeJsonDecodeArray($post['files'] ?? null);
    $media_link = (string)($post['media_link'] ?? '');

    if (!empty($images)) {
        $thumb = '../uploads/' . $images[0];
    } elseif (!empty($videos)) {
        $thumb = '../uploads/' . $videos[0];
    } elseif (!empty($files)) {
        $thumb = '../uploads/' . $files[0];
    } elseif ($media_link !== '') {
        if (preg_match('/(?:youtube\\.com\\/watch\\?v=|youtu\\.be\\/)([A-Za-z0-9_-]+)/', $media_link, $m)) {
            $thumb = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
        } elseif (preg_match('/tiktok\\.com\\/(@[\\w.-]+)\\/video\\/([0-9]+)/', $media_link, $m)) {
            $thumb = '../image/TikTok-Logomark.svg';
        } elseif (preg_match('/facebook\\.com\\/watch\\/\\?v=([0-9]+)/', $media_link, $m)) {
            $thumb = '../image/facebook-video-ads.webp';
        }
    }

    return $thumb;
}

try {
    $db = (new Database())->getConnection();
    if (!$db) {
        jsonFail('Database connection failed', 500);
    }

    // 1) Resources (latest posts)
    $resources = [];
    try {
        $stmt = $db->prepare(
            "SELECT p.*, u.user_name AS author_name " .
            "FROM elk_post p " .
            "LEFT JOIN elk_user u ON u.user_id = p.uploaded_by " .
            "ORDER BY p.id DESC " .
            "LIMIT 6"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($rows as $row) {
            $id = (int)($row['id'] ?? 0);
            $resources[] = [
                'id' => $id,
                'title' => $row['title'] ?? '',
                'description' => $row['description'] ?? '',
                'tag' => $row['category'] ?? '',
                'author' => $row['author_name'] ?? '',
                'image' => computeThumb($row),
                'src' => $id ? ('post?id=' . rawurlencode((string)$id)) : '#',
            ];
        }
    } catch (Throwable $e) {
        $resources = [];
    }

    // 2) Workshop progress: percent of students who submitted per workshop
    $totalStudents = 0;
    try {
        $totalStudents = (int)$db->query("SELECT COUNT(*) FROM elk_user WHERE user_type = 'student'")->fetchColumn();
    } catch (Throwable $e) {
        $totalStudents = 0;
    }

    $workshopProgress = [];
    for ($wid = 1; $wid <= 3; $wid++) {
        $submittedCount = 0;
        try {
            $stmt = $db->prepare(
                "SELECT COUNT(DISTINCT a.user_id) " .
                "FROM elk_workshop_attempts a " .
                "JOIN elk_user u ON u.user_id = a.user_id " .
                "WHERE a.workshop_id = :wid AND u.user_type = 'student'"
            );
            $stmt->execute([':wid' => $wid]);
            $submittedCount = (int)$stmt->fetchColumn();
        } catch (Throwable $e) {
            $submittedCount = 0;
        }

        $pct = 0;
        if ($totalStudents > 0) {
            $pct = (int)round(($submittedCount / $totalStudents) * 100);
            if ($pct < 0) $pct = 0;
            if ($pct > 100) $pct = 100;
        }

        $workshopProgress[] = [
            'label' => 'Workshop ' . $wid,
            'value' => $pct,
            'submitted' => $submittedCount,
            'total' => $totalStudents,
            'workshop_id' => $wid,
        ];
    }

    // 3) Latest submissions (latest attempts)
    $latestSubmissions = [];
    try {
        $stmt = $db->prepare(
            "SELECT a.workshop_id, COALESCE(a.submitted_at, a.created_at) AS submitted_at, " .
            "u.username AS student_id, u.user_name AS student_name, m.name AS program " .
            "FROM elk_workshop_attempts a " .
            "JOIN elk_user u ON u.user_id = a.user_id " .
            "LEFT JOIN elk_major m ON m.id = u.major_id " .
            "WHERE u.user_type = 'student' " .
            "ORDER BY COALESCE(a.submitted_at, a.created_at) DESC " .
            "LIMIT 10"
        );
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        foreach ($rows as $r) {
            $wid = (int)($r['workshop_id'] ?? 0);
            $rawDt = $r['submitted_at'] ?? null;
            $date = '-';
            if ($rawDt) {
                $ts = strtotime((string)$rawDt);
                if ($ts) {
                    $date = date('d/m/Y', $ts);
                }
            }

            $latestSubmissions[] = [
                'date' => $date,
                'student_id' => $r['student_id'] ?? '',
                'student_name' => $r['student_name'] ?? '',
                'program' => $r['program'] ?? '',
                'workshop' => $wid ? ('Workshop ' . $wid) : '',
                'workshop_id' => $wid,
            ];
        }
    } catch (Throwable $e) {
        $latestSubmissions = [];
    }

    echo json_encode([
        'success' => true,
        'message' => 'ok',
        'resources' => $resources,
        'workshopProgress' => $workshopProgress,
        'latestSubmissions' => $latestSubmissions,
    ], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error', 500);
}

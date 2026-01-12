<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Post.php';

$database = new Database();
$db = $database->getConnection();
$postModel = new Post($db);

$posts = $postModel->getAll();

$data = [];
foreach ($posts as $post) {
    // thumbnail: รูปแรกใน images หรือ files หรือ videos หรือจากลิงก์ youtube/tiktok
    $thumb = '../image/no-thumbnail.png';
    $images = json_decode($post['images'] ?? '[]', true);
    $videos = json_decode($post['videos'] ?? '[]', true);
    $files = json_decode($post['files'] ?? '[]', true);
    $media_link = $post['media_link'] ?? '';
    if (!empty($images)) {
        $thumb = '../uploads/' . $images[0];
    } elseif (!empty($videos)) {
        $thumb = '../uploads/' . $videos[0];
    } elseif (!empty($files)) {
        $thumb = '../uploads/' . $files[0];
    } elseif ($media_link) {
        // YouTube
        if (preg_match('/(?:youtube\\.com\\/watch\\?v=|youtu\\.be\\/)([A-Za-z0-9_-]+)/', $media_link, $m)) {
            $thumb = 'https://img.youtube.com/vi/' . $m[1] . '/hqdefault.jpg';
        }
        // TikTok (ใช้ snapshot จาก tiktokcdn, fallback เป็น no-thumbnail)
        elseif (preg_match('/tiktok\\.com\\/(@[\w.-]+)\\/video\\/([0-9]+)/', $media_link, $m)) {
            // ไม่มี API ตรง, ใช้ placeholder หรือโลโก้ tiktok แทน
            $thumb = '../image/TikTok-Logomark.svg';
        }
        // Facebook (รองรับ /watch/?v=...)
        elseif (preg_match('/facebook\\.com\\/watch\\/\\?v=([0-9]+)/', $media_link, $m)) {
            // ไม่มี API ตรง, ใช้ placeholder หรือโลโก้ facebook แทน
            $thumb = '../image/facebook-video-ads.webp';
        }
    }
    $data[] = [
        'id' => $post['id'],
        'title' => $post['title'],
        'category' => $post['category'],
        'uploaded_at' => $post['created_at'] ?? '',
        'thumbnail' => $thumb,
        'files' => $files,
        'images' => $images,
        'videos' => $videos,
        'media_link' => $post['media_link'] ?? '',
    ];
}

echo json_encode(['success' => true, 'data' => $data]);

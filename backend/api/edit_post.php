<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Post.php';

$database = new Database();
$db = $database->getConnection();
$postModel = new Post($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        error_log('DEBUG: edit_post.php POST called');
        error_log('DEBUG: _FILES = ' . print_r($_FILES, true));
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    $media_link = $_POST['media_link'] ?? '';
    $images = isset($_POST['images']) ? json_decode($_POST['images'], true) : null;
    $videos = isset($_POST['videos']) ? json_decode($_POST['videos'], true) : null;
    $files = isset($_POST['files']) ? json_decode($_POST['files'], true) : null;
    $credential_user_id = $_POST['credential_user_id'] ?? null;

    // รองรับการอัปโหลดไฟล์ใหม่ (ถ้ามี)
    $targetDir = __DIR__ . '/../../uploads/';
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    // อัปโหลดไฟล์ใหม่
    if (isset($_FILES['images'])) {
            error_log('DEBUG: _FILES[images] found');
        foreach ($_FILES['images']['name'] as $idx => $name) {
            if ($_FILES['images']['error'][$idx] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $filePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['images']['tmp_name'][$idx], $filePath)) {
                    if ($images === null) $images = [];
                    $images[] = $fileName;
                }
            }
        }
    }
    if (isset($_FILES['videos'])) {
            error_log('DEBUG: _FILES[videos] found');
        foreach ($_FILES['videos']['name'] as $idx => $name) {
            if ($_FILES['videos']['error'][$idx] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $filePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['videos']['tmp_name'][$idx], $filePath)) {
                    if ($videos === null) $videos = [];
                    $videos[] = $fileName;
                }
            }
        }
    }
    if (isset($_FILES['files'])) {
            error_log('DEBUG: _FILES[files] found');
        foreach ($_FILES['files']['name'] as $idx => $name) {
            if ($_FILES['files']['error'][$idx] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $filePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['files']['tmp_name'][$idx], $filePath)) {
                    if ($files === null) $files = [];
                    $files[] = $fileName;
                }
            }
        }
    }
error_log('DEBUG: update called, images=' . print_r($images, true) . ', videos=' . print_r($videos, true) . ', files=' . print_r($files, true));
    $result = $postModel->update([
            
        'id' => $id,
        'title' => $title,
        'description' => $description,
        'category' => $category,
        'media_link' => $media_link,
        'images' => $images,
        'videos' => $videos,
        'files' => $files,
        'credential_user_id' => $credential_user_id
    ]);
    if ($result) {
            error_log('DEBUG: update success');
        echo json_encode(['success' => true, 'message' => 'อัปเดตข้อมูลสำเร็จ']);
    } else {
            error_log('DEBUG: update failed');
        echo json_encode(['success' => false, 'message' => 'อัปเดตข้อมูลไม่สำเร็จ']);
    }
    exit;
}
// GET: ดึงข้อมูลโพสต์
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $post = $postModel->getById($id);
        if ($post) {
            echo json_encode(['success' => true, 'data' => $post]);
        } else {
            echo json_encode(['success' => false, 'message' => 'ไม่พบโพสต์']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'ไม่ระบุ id']);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Invalid request method']);

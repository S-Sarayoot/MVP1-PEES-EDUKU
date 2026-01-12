<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Post.php';

$database = new Database();
$db = $database->getConnection();
$postModel = new Post($db);

// รองรับเฉพาะ GET สำหรับดึงข้อมูลโพสต์ตาม id
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

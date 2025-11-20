
<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TeachingMedia.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

$response = ['success' => false, 'message' => ''];

if ($id) {
    $database = new Database();
    $db = $database->getConnection();
    $teachingMedia = new TeachingMedia($db);
    if ($teachingMedia->delete($id)) {
        $response['success'] = true;
    } else {
        $response['message'] = 'ลบข้อมูลไม่สำเร็จ';
    }
} else {
    $response['message'] = 'ไม่พบ ID';
}

echo json_encode($response);
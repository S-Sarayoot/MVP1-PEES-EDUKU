<?php
// Simple file upload handler for teaching media
header('Content-Type: application/json');


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TeachingMedia.php';

//credential
require_once __DIR__ . '/../config/credential.php';

$targetDir = __DIR__ . '/../../uploads/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$response = ["success" => false, "message" => ""];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    $fileName = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];
        $fileName = basename($file['name']);
        $filePath = $targetDir . $fileName;
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $response['file'] = $fileName;
        } else {
            $response['message'] = 'เกิดข้อผิดพลาดในการอัปโหลดไฟล์';
            echo json_encode($response);
            exit;
        }
    }
    // เชื่อมต่อฐานข้อมูลและบันทึกข้อมูล
    $database = new Database();
    $db = $database->getConnection();
    $teachingMedia = new TeachingMedia($db);
    $saved = $teachingMedia->create($fileName, $description, $category, $credential_user_id);
    if ($saved) {
        $response['success'] = true;
        $response['message'] = $fileName ? 'อัปโหลดไฟล์สำเร็จ' : 'บันทึกข้อมูลสำเร็จ';
        $response['description'] = $description;
        $response['category'] = $category;
    } else {
        $response['message'] = $fileName ? 'อัปโหลดไฟล์สำเร็จ แต่บันทึกข้อมูลลงฐานข้อมูลไม่สำเร็จ' : 'บันทึกข้อมูลไม่สำเร็จ';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);

<?php
// Simple file upload handler for teaching media
header('Content-Type: application/json');


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Post.php';

//credential
require_once __DIR__ . '/../config/credential.php';

$targetDir = __DIR__ . '/../../uploads/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$response = ["success" => false, "message" => ""];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    $media_link = $_POST['media_link'] ?? '';


    // รองรับหลายไฟล์ภาพ
    $images = [];
    if (isset($_FILES['images'])) {
        foreach ($_FILES['images']['name'] as $idx => $name) {
            if ($_FILES['images']['error'][$idx] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $filePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['images']['tmp_name'][$idx], $filePath)) {
                    $images[] = $fileName;
                }
            }
        }
    }

    // รองรับหลายไฟล์วิดีโอ
    $videos = [];
    if (isset($_FILES['videos'])) {
        foreach ($_FILES['videos']['name'] as $idx => $name) {
            if ($_FILES['videos']['error'][$idx] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $filePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['videos']['tmp_name'][$idx], $filePath)) {
                    $videos[] = $fileName;
                }
            }
        }
    }

    // รองรับหลายไฟล์ทั่วไป (files[])
    $files = [];
    if (isset($_FILES['files'])) {
        foreach ($_FILES['files']['name'] as $idx => $name) {
            if ($_FILES['files']['error'][$idx] === UPLOAD_ERR_OK) {
                $fileName = basename($name);
                $filePath = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['files']['tmp_name'][$idx], $filePath)) {
                    $files[] = $fileName;
                }
            }
        }
    }

    $database = new Database();
    $db = $database->getConnection();
    $postModel = new Post($db);

    if ($postModel->create([
        'title' => $title,
        'description' => $description,
        'category' => $category,
        'media_link' => $media_link,
        'images' => $images,
        'videos' => $videos,
        'files' => $files,
        'credential_user_id' => $credential_user_id])
    ) {
        $response['success'] = true;
        $response['message'] = 'บันทึกข้อมูลสำเร็จ';
        $response['title'] = $title;
        $response['description'] = $description;
        $response['category'] = $category;
        $response['media_link'] = $media_link;
        $response['images'] = $images;
        $response['videos'] = $videos;
        $response['files'] = $files;
        echo json_encode($response);
        http_response_code(200);
    } else {
        $response['message'] = 'บันทึกข้อมูลไม่สำเร็จ';
        echo json_encode($response);
        http_response_code(500);
    }
        
    
} else {
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
    http_response_code(405);
}

<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id            = $_POST['user_id']            ?? null;
    $user_code          = $_POST['user_code']          ?? null;
    $user_type          = $_POST['user_type']          ?? null;
    $user_name          = $_POST['user_name']          ?? null;
    $user_province      = $_POST['user_province']      ?? null;
    $user_district      = $_POST['user_district']      ?? null;
    $user_address       = $_POST['user_address']       ?? null;
    $user_zipcode       = $_POST['user_zipcode']       ?? null;
    $user_telephone     = $_POST['user_telephone']     ?? null;
    $user_email         = $_POST['user_email']         ?? null;
    $user_contactname   = $_POST['user_contactname']   ?? null;
    $company_house_file = $_POST['company_house_file'] ?? null;
    $idcard_file        = $_POST['idcard_file']        ?? null;
    $book_bank_file     = $_POST['book_bank_file']     ?? null;
    $status             = $_POST['status']             ?? null;
    $faculty_id         = $_POST['faculty_id']         ?? null;
    $major_id           = $_POST['major_id']           ?? null;

    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);

    // กำหนดค่า property ใน object
    $userModel->user_id            = $user_id;
    $userModel->user_code          = $user_code;
    $userModel->user_type          = $user_type;
    $userModel->user_name          = $user_name;
    $userModel->user_province      = $user_province;
    $userModel->user_district      = $user_district;
    $userModel->user_address       = $user_address;
    $userModel->user_zipcode       = $user_zipcode;
    $userModel->user_telephone     = $user_telephone;
    $userModel->user_email         = $user_email;
    $userModel->user_contactname   = $user_contactname;
    $userModel->company_house_file = $company_house_file;
    $userModel->idcard_file        = $idcard_file;
    $userModel->book_bank_file     = $book_bank_file;
    $userModel->status             = $status;
    $userModel->faculty_id         = $faculty_id;
    $userModel->major_id           = $major_id;

    $result = $userModel->updateUser();

    if ($result) {
        $response['success'] = true;
    } else {
        $response['message'] = 'อัพเดตข้อมูลไม่สำเร็จ';
    }
} else {
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
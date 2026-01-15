<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/credential.php';
require_once __DIR__ . '/../models/User.php';

function jsonFail($message, $status = 400)
{
    http_response_code($status);
    echo json_encode(['success' => false, 'message' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    jsonFail('Invalid request method', 405);
}

$userId = isset($credential_user_id) ? intval($credential_user_id) : 0;
if ($userId <= 0) {
    jsonFail('Unauthorized', 401);
}

try {
    $db = (new Database())->getConnection();
    $userModel = new User($db);

    $existingStmt = $userModel->getUserById($userId);
    $existing = $existingStmt ? $existingStmt->fetch(PDO::FETCH_ASSOC) : null;
    if (!$existing) {
        jsonFail('User not found', 404);
    }

    // Only allow updating selected fields from the profile page
    $user_name = $_POST['user_name'] ?? $existing['user_name'];
    $user_telephone = $_POST['user_telephone'] ?? $existing['user_telephone'];
    $user_address = $_POST['user_address'] ?? $existing['user_address'];
    $user_province = $_POST['user_province'] ?? $existing['user_province'];
    $user_district = $_POST['user_district'] ?? $existing['user_district'];
    $user_zipcode = $_POST['user_zipcode'] ?? $existing['user_zipcode'];
    $user_contactname = $_POST['user_contactname'] ?? $existing['user_contactname'];

    $faculty_id = array_key_exists('faculty_id', $_POST) ? $_POST['faculty_id'] : ($existing['faculty_id'] ?? null);
    $major_id = array_key_exists('major_id', $_POST) ? $_POST['major_id'] : ($existing['major_id'] ?? null);

    $academic_year = array_key_exists('academic_year', $_POST) ? $_POST['academic_year'] : ($existing['academic_year'] ?? null);
    $academic_term = array_key_exists('academic_term', $_POST) ? $_POST['academic_term'] : ($existing['academic_term'] ?? null);

    // Keep these from DB (not editable here)
    $userModel->user_id = $userId;
    $userModel->user_code = $existing['user_code'] ?? '';
    $userModel->user_type = $existing['user_type'] ?? '';
    $userModel->user_email = $existing['user_email'] ?? '';
    $userModel->status = $existing['status'] ?? '1';

    $userModel->company_house_file = $existing['company_house_file'] ?? null;
    $userModel->idcard_file = $existing['idcard_file'] ?? null;
    $userModel->book_bank_file = $existing['book_bank_file'] ?? null;

    // Updatable fields
    $userModel->user_name = $user_name ?? '';
    $userModel->user_telephone = $user_telephone ?? '';
    $userModel->user_address = $user_address ?? '';
    $userModel->user_province = $user_province ?? '';
    $userModel->user_district = $user_district ?? '';
    $userModel->user_zipcode = $user_zipcode ?? '';
    $userModel->user_contactname = $user_contactname ?? '';

    $userModel->faculty_id = ($faculty_id === '' || $faculty_id === null) ? null : $faculty_id;
    $userModel->major_id = ($major_id === '' || $major_id === null) ? null : $major_id;
    $userModel->academic_year = ($academic_year === '' ? null : $academic_year);
    $userModel->academic_term = ($academic_term === '' ? null : $academic_term);

    $ok = $userModel->updateUser();
    if (!$ok) {
        jsonFail('อัพเดตข้อมูลไม่สำเร็จ', 500);
    }

    echo json_encode(['success' => true], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    jsonFail('Server error', 500);
}

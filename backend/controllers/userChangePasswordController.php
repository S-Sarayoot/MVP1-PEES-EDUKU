<?php
require __DIR__.'../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'../../../');
$dotenv->load();
$base_url = $_ENV['APP_URL'] ?? '';
//check credentials
require_once(__DIR__.'../../config/credential.php');
if (empty($credential_username) ) {
    header("location: ".$base_url."/logout.php");
    exit();
}

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include User model
require_once('../models/user.php');
require_once('../config/database.php');

try {
    // Process form data - handle both regular form data and JSON
    $postData = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!empty($_POST)) {
            // Form data submitted via regular form
            $postData = $_POST;
        } else {
            // Data submitted via JSON (for API calls)
            $postData = json_decode(file_get_contents('php://input'), true);
        }
    }

    if (empty($postData)) {
        throw new Exception('No data received');
    }

    // Validate required fields
    $currentPassword = $postData['currentPassword'] ?? '';
    $newPassword = $postData['newPassword'] ?? '';
    $confirmPassword = $postData['confirmPassword'] ?? '';
    $user_id = $postData['id'] ?? $credential_user_id;

    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'กรุณากรอกข้อมูลให้ครบถ้วน'
        ]);
        exit();
    }

    // Validate password length
    if (strlen($newPassword) < 8) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'รหัสผ่านใหม่ต้องมีความยาวอย่างน้อย 8 หลัก'
        ]);
        exit();
    }

    // Check if new password and confirm password match
    if ($newPassword !== $confirmPassword) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'รหัสผ่านใหม่และการยืนยันรหัสผ่านไม่ตรงกัน'
        ]);
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $user->user_id = $user_id ;

    // Get current user's hashed password from database
    $currentUserData = $user->getUserById($user_id);
    // fetch $currentUserData = $user->getUserById($credential_user_id);
    // count row
    $currentUserData_count = $currentUserData->rowCount();
    $currentUserData = $currentUserData->fetch(PDO::FETCH_ASSOC);

    if ($currentUserData_count < 1) {
        http_response_code(404);
        echo json_encode([
            'status' => 'error',
            'message' => 'ไม่พบข้อมูลผู้ใช้'
        ]);
        exit();
    }

    // Verify current password with hash stored in database
    if (!password_verify($currentPassword, $currentUserData['password'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง'
        ]);
        exit();
    }

    // Check if new password is same as current password
    if (password_verify($newPassword, $currentUserData['password'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'รหัสผ่านใหม่ต้องไม่เหมือนกับรหัสผ่านปัจจุบัน'
        ]);
        exit();
    }

    // Hash the new password
    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update password in database
    $user->password = $hashedNewPassword;
    if (!$user->updatePassword()) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => 'ไม่สามารถอัปเดตรหัสผ่านได้ในขณะนี้'
        ]);
        exit();
    }

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'เกิดข้อผิดพลาด: ' . $e->getMessage()
    ]);
}

?>
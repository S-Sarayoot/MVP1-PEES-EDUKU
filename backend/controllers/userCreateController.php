<?php
require __DIR__.'../../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'../../../');
$dotenv->load();
$base_url = $_ENV['APP_URL'] ?? '';
//check credentials
require_once(__DIR__.'../../config/credential.php');
if (empty($credential_username) || $credential_user_type != 'admin') {
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
    $requiredFields = ['username', 'password', 'user_type', 'user_code', 'user_name', 
                      'user_contactname', 'user_telephone', 'user_address', 
                      'user_zipcode'];
    
    foreach ($requiredFields as $field) {
        if (!isset($postData[$field]) || empty($postData[$field])) {
            throw new Exception("Missing required field: {$field}");
        }
    }
    


    // Password validation
    if (strlen($postData['password']) < 8) {
        throw new Exception("Password must be at least 8 characters long");
    }
    
    // connect to the database
    $database = new Database();
    $db = $database->getConnection();
    
    // Create new user instance
    $user = new User($db);
    
    // Handle file uploads if present
    $uploadedFiles = [];
    
    if (!empty($_FILES)) {
        $uploadDir = __DIR__.'../../uploads/user_documents/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileFields = ['idcard_file', 'company_house_file', 'book_bank_file'];
        
        foreach ($fileFields as $field) {
            if (!empty($_FILES[$field]['name'])) {
                $fileName = $postData['user_code'].time() . '_' . basename($_FILES[$field]['name']);
                $targetFilePath = $uploadDir . $fileName;
                
                // Upload file
                if (move_uploaded_file($_FILES[$field]['tmp_name'], $targetFilePath)) {
                    $uploadedFiles[$field] = $fileName;
                } else {
                    throw new Exception("Failed to upload file: {$field}");
                }
            }
        }
    }
    
    // กำหนดค่าให้กับ object properties แทนการใช้ array
    $user->user_code = $postData['user_code'];
    $user->username = $postData['username'];
    $user->user_email = $postData['username']; // Using username as email
    $user->password = password_hash($postData['password'], PASSWORD_DEFAULT); // Hash the password before saving
    $user->user_type = $postData['user_type'];
    $user->user_name = $postData['user_name'];
    $user->user_contactname = $postData['user_contactname'];
    $user->user_telephone = $postData['user_telephone'];
    $user->user_address = $postData['user_address'];
    $user->user_zipcode = $postData['user_zipcode'];
    $user->user_district = '';
    $user->user_province = '';
    $user->idcard_file = $uploadedFiles['idcard_file'] ?? null;
    $user->company_house_file = $uploadedFiles['company_house_file'] ?? null;
    $user->book_bank_file = $uploadedFiles['book_bank_file'] ?? null;
    $user->status = '1'; // กำหนดค่าเริ่มต้นเป็น active
    
    $result = $user->createUser();

    if ($result) {
        http_response_code(201);
        echo json_encode([
            'status' => 'success',
            'message' => 'User created successfully'
        ]);
    } else {
        throw new Exception('Failed to create user');
    }

} catch (Exception $e) {
    if($e->getMessage() == "SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '0' for key 'PRIMARY'") {
        http_response_code(200);
        echo json_encode([
            'status' => 'error',
            'message' => 'User already exists with this username or user code'
        ]);
        exit();
    }else{
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}
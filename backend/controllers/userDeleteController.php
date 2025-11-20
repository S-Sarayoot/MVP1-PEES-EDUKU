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
    
    $user_id = isset($_GET['userId'] ) ? $_GET['userId'] : die();

    $database = new database();
    $db = $database->getConnection();

    //prepare data to temp user
    //random number 6digit

    $user_code =  str_pad(rand(0, 9), 6, '6', STR_PAD_LEFT);
    $username = "temp-".$user_code;
    $update_date = date("Y-m-d H:m:s");


    $user = new User($db);
    $user->status = '0';
    $user->user_code = $user_code;
    $user->username = $username;
    $user->update_date = $update_date;
    $user->user_id = $user_id;

    


    if ($user->deleteUser()) {
        http_response_code(201);
        echo json_encode([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to deleted user');
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
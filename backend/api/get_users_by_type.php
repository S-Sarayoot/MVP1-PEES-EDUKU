<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

$type = $_GET['type'] ?? '';
$response = ['success' => false, 'data' => []];

if ($type) {
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new User($db);
    $response['data'] = $userModel->getByType($type);
    $response['success'] = true;
} else {
    $response['message'] = 'Missing user type';
}
// filepath: c:\xampp2\htdocs\MVP1-PEES-EDUKU\backend\api\get_users_by_type.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo json_encode($response);
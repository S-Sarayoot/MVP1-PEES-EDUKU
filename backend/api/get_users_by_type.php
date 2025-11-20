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

echo json_encode($response);
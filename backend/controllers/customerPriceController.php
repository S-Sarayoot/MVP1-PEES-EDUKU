<?php
require_once '../config/credential.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/price.php';

// ตรวจสอบสิทธิ์การเข้าถึง
if(!($credential_user_type == "admin")) {
    header("Location: ../../../logout.php");
    exit();
}

// รับข้อมูล JSON จาก request body
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// ตรวจสอบว่า JSON ถูกต้องหรือไม่
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON format: " . json_last_error_msg()
    ]);
    exit();
}

// ตรวจสอบว่ามีข้อมูลที่จำเป็นครบถ้วนหรือไม่
if (!isset($data['user_id']) || !isset($data['prices'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing required data: user_id or prices"
    ]);
    exit();
}

// ตรวจสอบโครงสร้างข้อมูลราคา
if (!isset($data['prices']['chill']) || !isset($data['prices']['frozen']) || !isset($data['prices']['cod_price'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing price data for chill or frozen"
    ]);
    exit();
}

// เชื่อมต่อฐานข้อมูล
$database = new Database();
$db = $database->getConnection();

// สร้าง instance ของ Price model
$price = new Price($db);

// กำหนดค่าให้กับ properties ของ Price object
$price->user_id = $data['user_id'];
$price->chill_s = $data['prices']['chill']['S'];
$price->chill_m = $data['prices']['chill']['M'];
$price->chill_l = $data['prices']['chill']['L'];
$price->chill_xl = $data['prices']['chill']['XL'];
$price->frozen_s = $data['prices']['frozen']['S'];
$price->frozen_m = $data['prices']['frozen']['M'];
$price->frozen_l = $data['prices']['frozen']['L'];
$price->frozen_xl = $data['prices']['frozen']['XL'];
$price->cod_price = $data['prices']['cod_price'];

// บันทึกข้อมูลราคา
if ($price->savePrice()) {
    // ส่งผลลัพธ์กลับเมื่อบันทึกสำเร็จ
    http_response_code(200);
    echo json_encode([
        "status" => "success",
        "message" => "Price data saved successfully"
    ]);
} else {
    // ส่งข้อความผิดพลาดเมื่อบันทึกไม่สำเร็จ
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save price data"
    ]);
}
?>
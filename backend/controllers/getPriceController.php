<?php
require_once '../config/credential.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../models/price.php';

// ตรวจสอบสิทธิ์การเข้าถึง
if(!($credential_user_type == "admin")) {
    header("Location: ../../../logout.php");
    exit();
}

// ตรวจสอบว่ามีการส่ง user_id มาหรือไม่
if(!isset($_GET['user_id'])) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Missing user_id parameter"
    ]);
    exit();
}

$user_id = $_GET['user_id'];

// เชื่อมต่อฐานข้อมูล
$database = new Database();
$db = $database->getConnection();

// สร้าง instance ของ Price model
$price = new Price($db);

// ดึงข้อมูลราคาตาม user_id
$result = $price->getPriceByUserId($user_id);

if($result) {
    $price_data = $result->fetch(PDO::FETCH_ASSOC);
    
    if($price_data) {
        // แปลงข้อมูลราคาให้อยู่ในรูปแบบที่ต้องการ
        $formatted_prices = [
            "chill" => [
                "S" => $price_data['chill_s'],
                "M" => $price_data['chill_m'],
                "L" => $price_data['chill_l'],
                "XL" => $price_data['chill_xl']
            ],
            "frozen" => [
                "S" => $price_data['frozen_s'],
                "M" => $price_data['frozen_m'],
                "L" => $price_data['frozen_l'],
                "XL" => $price_data['frozen_xl']
            ],
            "parcel" => [
                "S" => $price_data['parcel_s'],
                "M" => $price_data['parcel_m'],
                "L" => $price_data['parcel_l'],
                "XL" => $price_data['parcel_xl']
            ],
            "cod_price" => $price_data['cod_price']
        ];
        
        // ส่งข้อมูลกลับ
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => $formatted_prices
        ]);
    } else {
        // ไม่พบข้อมูลราคา (ยังไม่เคยกำหนดราคา)
        http_response_code(200);
        echo json_encode([
            "status" => "success",
            "data" => null,
            "message" => "No price data found for this user"
        ]);
    }
} else {
    // กรณีมีข้อผิดพลาดในการดึงข้อมูล
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Failed to fetch price data"
    ]);
}
?>
<?php
    require_once '../config/credential.php';
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once '../config/database.php';
    require_once '../models/user.php';
    
    if(!($credential_user_type == "admin" || $credential_user_type == "customer" || $credential_user_type == "driver")) {
        header("Location: ../../../logout.php");
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $get_user_id = isset($_GET['user_id']) ? $_GET['user_id'] : $credential_user_id; // Use the user_id from the request or the session

    $stmt = $user->getUserById($get_user_id);
    $num = $stmt->rowCount();
    
    if($num>0){    
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);
    
            $user_item=array(
                "user_id" => $user_id,
                "user_code" => $user_code,
                "username" => $username,
                "user_type" => $user_type,
                "status" => $status,
                "user_name" => $user_name,
                "user_zipcode" => $user_zipcode,
                "user_address" => $user_address,
                "user_telephone" => $user_telephone,
                "user_contactname" => $user_contactname,
                "company_house_file" => $company_house_file,
                "idcard_file" => $idcard_file,
                "book_bank_file" => $book_bank_file

            );
    
        }
    
        // set response code - 200 OK
        http_response_code(201);
    
        // show products data in json format
        // ส่งข้อมูลในรูปแบบที่ DataTables ต้องการ
        echo json_encode($user_item, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
    
    // no products found will be here
    else{
    
        // set response code - 404 Not found
        http_response_code(200);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "Notfound-".$credential_user_id)
        );
    }
    
?>
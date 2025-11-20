<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// files needed to connect to database
require_once('../../credential.php');
include_once('../config/core.php');
include_once('../config/database.php');
include_once('../controller/customer.php');
include_once('../controller/agent.php');
include_once('../controller/admin.php');

// get database connection
$database = new Database();
$db = $database->getConnection();

if ($usertype == "customer") {

    $customer = new Customer($db);

    // set  property values
    $customer->username = $username;
    $userExists = $customer->userExists();

    if ($userExists && password_verify($_POST["old_password"], $customer->password)) {
        
        if ($customer->changepwd($user_code,password_hash($_POST["new_password1"],PASSWORD_BCRYPT))) { 
           // set response code
            http_response_code(200);  
            echo json_encode(array("message" => "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว"));
        }
        else{
            http_response_code(401);
            // tell the user login failed
            echo json_encode(array("message" => "การเปลี่ยนรหัสผ่านมีข้อผิดพลาด โปรดติดต่อผู้ดูและระบบ"));
        }
       
    }
    // failed
    else {
        // set response code
        http_response_code(401);
        // tell the user login failed
        echo json_encode(array("message" => "กรอกรหัสผ่านเดิมไม่ถูกต้อง"));
    }
} else if ($usertype == "agent") {

    $agent = new Agent($db);

    // set  property values
    $agent->username = $user_code;
    $userExists = $agent->userExists();

    if ($userExists && password_verify($_POST["old_password"], $agent->password)) {

        if ($agent->changepwd($user_code,password_hash($_POST["new_password1"],PASSWORD_BCRYPT))) { 
           // set response code
            http_response_code(200);  
            echo json_encode(array("message" => "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว"));
        }
        else{
            http_response_code(401);
            // tell the user login failed
            echo json_encode(array("message" => "การเปลี่ยนรหัสผ่านมีข้อผิดพลาด โปรดติดต่อผู้ดูและระบบ"));
        }
       
    }
    // failed
    else {
        // set response code
        http_response_code(401);
        // tell the user login failed
        echo json_encode(array("message" => "กรอกรหัสผ่านเดิมไม่ถูกต้อง"));
    }

} else if ($usertype == "admin") { 
    $admin = new Admin($db);

    // set  property values
    $admin->username = $user_code;
    $userExists = $admin->userExists();

    if ($userExists && password_verify($_POST["old_password"], $admin->password)) {

        if ($admin->changepwd($user_code,password_hash($_POST["new_password1"],PASSWORD_BCRYPT))) { 
            // set response code
             http_response_code(200);  
             echo json_encode(array("message" => "เปลี่ยนรหัสผ่านเรียบร้อยแล้ว"));
         }
         else{
             http_response_code(401);
             // tell the user login failed
            echo json_encode(array("message" => "การเปลี่ยนรหัสผ่านมีข้อผิดพลาด โปรดติดต่อผู้ดูและระบบ"));
         }
        
     }
     // failed
     else {
         // set response code
         http_response_code(401);
         // tell the user login failed
         echo json_encode(array("message" => "กรอกรหัสผ่านเดิมไม่ถูกต้อง"));
     }
}

/*
$token = array(
    "iss" => $iss,
    "aud" => $aud,
    "iat" => $iat,
    "nbf" => $nbf,
    'exp' => $exp,
    "data" => array(
        "id" => "TARA",
        "firstname" => "TARA1",
        "lastname" => "TARA2",
        "email" => "TARA@gmail.com"
    )
);
*/
// set response code
//http_response_code(200);

// generate jwt
//$token = JWT::encode($token, $key);

//setcookie("smartpost", $token, time() + 30 * 24 * 60 * 60);

//echo json_encode(
//		array(
//			"message" => "Successful login.",
//			"token" => $token
//		)
//    );

/*
if (!isset($_COOKIE["smartpost"])) {
    echo json_encode(array(
        'error' => 'Token not provided.'
    ));
} else {
    try {
        $credentials = JWT::decode($_COOKIE["smartpost"], $key, ['HS256']);

        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $credentials
        ));

    } catch (ExpiredException $e) {
        echo json_encode(array(
            'error' => 'Provided token is expired.'
        ));
    } catch (Exception $e) {
        echo json_encode(array(
            'error' => 'An error while decoding token.'
        ));
    }
}
*/
        //$decoded = JWT::decode($token, $key, array('HS256'));
        
        //echo $decoded->data->id;

        //echo json_encode(array(
        //    "message" => "Access granted.",
        //    "data" => $credentials
        //))
	 
	//}
	 
	// login failed will be here
	// login failed
	//else{
	 
		// set response code
	//	http_response_code(401);
	 
		// tell the user login failed
	//	echo json_encode(array("message" => "Login failed."));
	//}

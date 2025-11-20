<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// database connection will be here
// files needed to connect to database
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../models/user.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// files for jwt will be here
// generate json web token
// include_once '../libs/php-jwt-master/src/BeforeValidException.php';
// include_once '../libs/php-jwt-master/src/ExpiredException.php';
// include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
// include_once '../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;


$user = new User($db);
// set  property values
$user->username = $_POST["email"];

$userExists = $user->userExists();

if ($userExists && password_verify($_POST["password"], $user->password)) {

    
    
    $token = array(
        "iss" => $iss,
        "aud" => $aud,
        "iat" => $iat,
        "nbf" => $nbf,
        'exp' => $exp,
        "data" => array(
            "user_id" => $user->user_id,
            "user_code" => $user->user_code,
            "username" => $user->username,
            "user_name" => $user->user_name,
            "user_province" => $user->user_province,
            "user_district" => $user->user_district,
            "user_zipcode" => $user->user_zipcode,
            "user_address" => $user->user_address,
            "user_telephone" => $user->user_telephone,
            "user_email" => $user->user_email,
            "user_contactname" => $user->user_contactname,
            "user_type" => $user->user_type,
            "services" => $user->services
           

        )
    );

    // set response code
    http_response_code(200);

    // generate jwt
    $token = JWT::encode($token, $key, 'HS256');

    setcookie("EquityLearnKU", $token, $exp,"/");

    echo json_encode(
        array(
            "message" => "Successful login.",
            "token" => $token
        )
    );
}

// login failed
else {
    // set response code
    http_response_code(401);
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}


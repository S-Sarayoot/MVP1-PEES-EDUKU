<?php
    require_once 'core.php';
    // require_once (__DIR__ . '/../libs/php-jwt-master/src/BeforeValidException.php');
    // require_once (__DIR__ . '/../libs/php-jwt-master/src/ExpiredException.php');
    // require_once (__DIR__ . '/../libs/php-jwt-master/src/SignatureInvalidException.php');
    // require_once (__DIR__ . '/../libs/php-jwt-master/src/JWT.php');

    use \Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    require __DIR__.'/../../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../../");
    $dotenv->load();
    $base_url = $_ENV['APP_URL'] ?? '';

    $credential_user_id = "0";
    $credential_user_code = "";
    $credential_username = "";
    $credential_user_name = "";
    $credential_user_province = "";
    $credential_user_district = "";
    $credential_user_zipcode = "";
    $credential_user_address = "";
    $credential_user_telephone = "";
    $credential_user_email = "";
    $credential_user_contactname = "";
    $credential_user_type = "";
    $credential_services = "";





    if (!isset($_COOKIE["EquityLearnKU"])) {
        header("Location: ".$base_url."/login");
        //header("Location: ./login");
    } else {
        try {
            $credentials = JWT::decode($_COOKIE["EquityLearnKU"], new Key($key, 'HS256'));

            $credential_user_id = $credentials->data->user_id;
            $credential_user_code = $credentials->data->user_code;            
            $credential_username = $credentials->data->username;
            $credential_user_name = $credentials->data->user_name;
            $credential_user_province = $credentials->data->user_province;
            $credential_user_district = $credentials->data->user_district;
            $credential_user_zipcode = $credentials->data->user_zipcode;
            $credential_user_address = $credentials->data->user_address;
            $credential_user_telephone = $credentials->data->user_telephone;
            $credential_user_email = $credentials->data->user_email;
            $credential_user_type = $credentials->data->user_type;
            $credential_services = $credentials->data->services;


        } catch (\Firebase\JWT\ExpiredException $e) {
            header("Location:/login.php");
        } catch (Exception $e) {
            header("Location:/login.php");

        }
    }
?>
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

    // Record login (used by admin dashboard)
    try {
        $ensureColumnExists = function ($db, $table, $column, $definition) {
            try {
                $stmt = $db->prepare(
                    "SELECT 1 FROM INFORMATION_SCHEMA.COLUMNS\n" .
                    "WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :t AND COLUMN_NAME = :c LIMIT 1"
                );
                $stmt->execute([':t' => $table, ':c' => $column]);
                $exists = (bool)$stmt->fetchColumn();
                if (!$exists) {
                    $db->exec("ALTER TABLE `{$table}` ADD COLUMN `{$column}` {$definition}");
                }
            } catch (Throwable $e) {
                // ignore schema migration failures
            }
        };

        $db->exec(
            "CREATE TABLE IF NOT EXISTS elk_user_login_log (\n" .
            "  id BIGINT NOT NULL AUTO_INCREMENT,\n" .
            "  user_id INT NOT NULL,\n" .
            "  user_type VARCHAR(50) NULL,\n" .
            "  username VARCHAR(255) NULL,\n" .
            "  ip_address VARCHAR(45) NULL,\n" .
            "  user_agent VARCHAR(255) NULL,\n" .
            "  login_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,\n" .
            "  PRIMARY KEY (id),\n" .
            "  INDEX idx_login_at (login_at),\n" .
            "  INDEX idx_user_id (user_id)\n" .
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
        );

        // In case the table already existed before ip/user_agent columns were added
        $ensureColumnExists($db, 'elk_user_login_log', 'ip_address', 'VARCHAR(45) NULL');
        $ensureColumnExists($db, 'elk_user_login_log', 'user_agent', 'VARCHAR(255) NULL');

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;

        $stmtLogin = $db->prepare('INSERT INTO elk_user_login_log (user_id, user_type, username, ip_address, user_agent) VALUES (:uid, :ut, :un, :ip, :ua)');
        $stmtLogin->execute([
            ':uid' => (int)$user->user_id,
            ':ut' => $user->user_type ?? null,
            ':un' => $user->username ?? null,
            ':ip' => $ip,
            ':ua' => $ua,
        ]);
    } catch (Throwable $e) {
        // ignore logging failures
    }

    
    
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


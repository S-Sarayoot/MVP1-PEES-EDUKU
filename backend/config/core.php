<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// โหลด environment variables จากไฟล์ .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

// show error reporting
error_reporting(E_ALL);

// set your default time-zone
date_default_timezone_set('Asia/Bangkok');

// variables used for jwt
$key = $_ENV['JWT_SECRET'] ?? "eoMw5mhs/FxJ5UFjTJ4n9Zq32WiJTJMW7d2+wYEHFEY=";
$iss = $_ENV['APP_URL'] ?? "https://mis.edu.ku.ac.th/EquityLearnKU";
$aud = $_ENV['APP_URL'] ?? "https://mis.edu.ku.ac.th/EquityLearnKU";
$iat = time(); 
$nbf = time();
$exp = time() + 24*60*60; // 24 hours * 60 minutes * 60 seconds/minute

?>
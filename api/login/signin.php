<?php
    header('Content-Type: application/json');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');
    
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Login endpoint is active.'
    ]);
    
    exit;
?>
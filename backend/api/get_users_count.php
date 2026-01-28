<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$db = $database->getConnection();

$total = $db->query("SELECT COUNT(*) FROM elk_user WHERE status != '0'")->fetchColumn();
$student = $db->query("SELECT COUNT(*) FROM elk_user WHERE user_type = 'student' AND status != '0'")->fetchColumn();
$teacher = $db->query("SELECT COUNT(*) FROM elk_user WHERE user_type = 'teacher' AND status != '0'")->fetchColumn();
$admin = $db->query("SELECT COUNT(*) FROM elk_user WHERE user_type = 'admin' AND status != '0'")->fetchColumn();

echo json_encode([
    'total' => (int)$total,
    'student' => (int)$student,
    'teacher' => (int)$teacher,
    'admin' => (int)$admin
]);
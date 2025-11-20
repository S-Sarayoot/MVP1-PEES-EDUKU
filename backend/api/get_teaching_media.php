<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/TeachingMedia.php';

$database = new Database();
$db = $database->getConnection();
$teachingMedia = new TeachingMedia($db);

$data = $teachingMedia->getAll();
echo json_encode(['success' => true, 'data' => $data]);

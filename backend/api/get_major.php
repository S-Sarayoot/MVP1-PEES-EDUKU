<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
$db = (new Database())->getConnection();
$stmt = $db->query("SELECT id, name FROM elk_major ORDER BY name");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
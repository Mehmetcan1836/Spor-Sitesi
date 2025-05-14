<?php
header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID gerekli."]);
    exit;
}

$locationsFile = '../locations.json';
$locations = json_decode(file_get_contents($locationsFile), true);
$locations = array_filter($locations, fn($loc) => $loc['id'] != $_POST['id']);
file_put_contents($locationsFile, json_encode(array_values($locations), JSON_PRETTY_PRINT));

echo json_encode(["success" => true]);

<?php
header('Content-Type: application/json');

$id = $_POST['id'] ?? '';
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$lat = $_POST['lat'] ?? '';
$lng = $_POST['lng'] ?? '';

if (!$id || !$name || !$description || !$lat || !$lng) {
    http_response_code(400);
    echo json_encode(["error" => "Tüm alanlar zorunlu."]);
    exit;
}

$locationsFile = '../locations.json';
$locations = json_decode(file_get_contents($locationsFile), true);

foreach ($locations as &$loc) {
    if ($loc['id'] == $id) {
        $loc['name'] = $name;
        $loc['description'] = $description;
        $loc['lat'] = floatval($lat);
        $loc['lng'] = floatval($lng);
    }
}

file_put_contents($locationsFile, json_encode($locations, JSON_PRETTY_PRINT));
echo json_encode(["success" => true]);

<?php
header('Content-Type: application/json');

// Basit bir güvenlik anahtarı (daha gelişmiş için JWT, session kullanabilirsin)
$api_key = "12345";
if (!isset($_POST['api_key']) || $_POST['api_key'] !== $api_key) {
    http_response_code(403);
    echo json_encode(["error" => "Geçersiz API anahtarı."]);
    exit;
}

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$lat = $_POST['lat'] ?? '';
$lng = $_POST['lng'] ?? '';

if (!$name || !$description || !$lat || !$lng) {
    http_response_code(400);
    echo json_encode(["error" => "Lütfen tüm alanları doldurun."]);
    exit;
}

$locationsFile = '../locations.json';
$locations = [];

if (file_exists($locationsFile)) {
    $locations = json_decode(file_get_contents($locationsFile), true);
}

// Yeni ID otomatik
$newId = count($locations) > 0 ? max(array_column($locations, 'id')) + 1 : 1;

$newLocation = [
    "id" => $newId,
    "name" => $name,
    "description" => $description,
    "lat" => floatval($lat),
    "lng" => floatval($lng)
];

$locations[] = $newLocation;

// JSON'u kaydet
file_put_contents($locationsFile, json_encode($locations, JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "message" => "Lokasyon eklendi.", "data" => $newLocation]);
?>

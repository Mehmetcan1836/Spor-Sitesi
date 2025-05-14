<?php
header('Content-Type: application/json');
$locationsFile = '../locations.json';
$locations = file_exists($locationsFile) ? json_decode(file_get_contents($locationsFile), true) : [];
echo json_encode($locations);

<?php

$lat = $_GET['lat'] ?? '';
$lon = $_GET['lon'] ?? '';

$url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=$lat&lon=$lon";

$options = [
    "http" => [
        "method" => "GET",
        "header" =>
            "User-Agent: DriveMoto/1.0\r\n" .
            "Accept: application/json\r\n"
    ]
];

$context = stream_context_create($options);

$response = file_get_contents($url,false,$context);

header("Content-Type: application/json");

echo $response;
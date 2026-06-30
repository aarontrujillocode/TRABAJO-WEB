<?php

header("Content-Type: application/json");

if (!isset($_GET['q'])) {
    echo json_encode([]);
    exit();
}

$q = urlencode($_GET['q']);

$url = "https://nominatim.openstreetmap.org/search?format=jsonv2&q=$q&limit=5";

$options = [
    "http" => [
        "method" => "GET",
        "header" =>
            "User-Agent: DriveMoto/1.0\r\n" .
            "Accept: application/json\r\n"
    ]
];

$context = stream_context_create($options);

$response = file_get_contents($url, false, $context);

echo $response;
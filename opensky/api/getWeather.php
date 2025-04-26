<?php
header("Content-Type: application/json");
$lat = $_GET['lat'] ?? '39.92'; // Varsayılan enlem
$lon = $_GET['lon'] ?? '32.85'; // Varsayılan boylam
$url = "https://api.open-meteo.com/v1/forecast?latitude=$lat&longitude=$lon&hourly=temperature_2m";
$response = file_get_contents($url);
echo $response;
?>
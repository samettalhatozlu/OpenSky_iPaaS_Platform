<?php
header('Content-Type: application/json');

// OpenSky API endpoint
$opensky_api = "https://opensky-network.org/api";

// ICAO24 kodunu al
$icao24 = isset($_GET['icao24']) ? $_GET['icao24'] : null;

if (!$icao24) {
    echo json_encode(['error' => 'ICAO24 kodu gerekli']);
    exit;
}

// OpenSky API'den uçuş detaylarını al
$states_url = $opensky_api . "/states/all?icao24=" . urlencode($icao24);
$aircraft_url = $opensky_api . "/metadata/aircraft/icao/" . urlencode($icao24);

// API isteklerini yap
$states_data = file_get_contents($states_url);
$aircraft_data = @file_get_contents($aircraft_url);

if ($states_data === false) {
    echo json_encode(['error' => 'OpenSky API erişim hatası']);
    exit;
}

$states = json_decode($states_data, true);
$aircraft = $aircraft_data ? json_decode($aircraft_data, true) : null;

// Uçuş verilerini hazırla
$flight_details = [];

if (isset($states['states']) && !empty($states['states'][0])) {
    $state = $states['states'][0];
    
    $flight_details = [
        'icao24' => $state[0],
        'callsign' => trim($state[1]),
        'origin_country' => $state[2],
        'longitude' => $state[5],
        'latitude' => $state[6],
        'altitude' => round($state[7] * 3.28084), // metre -> feet
        'heading' => round($state[10]),
        'velocity' => round($state[9] * 1.944), // m/s -> knots
        'verticalRate' => round($state[11] * 196.85), // m/s -> ft/min
        'squawk' => $state[14] ?? null,
        'onGround' => $state[8],
        'lastUpdate' => $state[3]
    ];

    // Eğer aircraft metadata varsa, ekstra bilgileri ekle
    if ($aircraft) {
        $flight_details['aircraftType'] = $aircraft['typecode'] ?? null;
        $flight_details['manufacturer'] = $aircraft['manufacturername'] ?? null;
        $flight_details['model'] = $aircraft['model'] ?? null;
        $flight_details['operator'] = $aircraft['operatorname'] ?? null;
    }
}

echo json_encode($flight_details); 
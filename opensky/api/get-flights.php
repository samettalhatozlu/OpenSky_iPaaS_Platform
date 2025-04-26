<?php
header('Content-Type: application/json');

// OpenSky API endpoint
$opensky_api = "https://opensky-network.org/api";

// Türkiye sınırları (yaklaşık)
$bounds = [
    'lamin' => 35.8,  // Minimum latitude
    'lamax' => 42.1,  // Maximum latitude
    'lomin' => 26.0,  // Minimum longitude
    'lomax' => 44.8   // Maximum longitude
];

// OpenSky API'den uçuş verilerini al
$url = $opensky_api . "/states/all?" . http_build_query($bounds);
$response = file_get_contents($url);

if ($response === false) {
    echo json_encode(['error' => 'OpenSky API erişim hatası']);
    exit;
}

$data = json_decode($response, true);

if (!isset($data['states']) || !is_array($data['states'])) {
    echo json_encode(['error' => 'Geçersiz API yanıtı']);
    exit;
}

// Uçuş verilerini işle
$flights = [];
foreach ($data['states'] as $state) {
    // Sadece Türkiye hava sahası içindeki uçuşları al
    if ($state[6] >= $bounds['lamin'] && $state[6] <= $bounds['lamax'] &&
        $state[5] >= $bounds['lomin'] && $state[5] <= $bounds['lomax']) {
        
        // Rastgele gecikme durumu (gerçek veri için farklı bir API gerekebilir)
        $isDelayed = rand(0, 10) > 8; // %20 olasılıkla gecikme
        
        // ICAO havaalanı kodlarından rastgele seç (örnek için)
        $airports = ['LTFM', 'LTAC', 'LTAI', 'LTBJ', 'LTFE', 'LTFJ'];
        
        $flight = [
            'icao24' => $state[0],
            'callsign' => trim($state[1] ?? 'N/A'),
            'origin_country' => $state[2],
            'longitude' => floatval($state[5]),
            'latitude' => floatval($state[6]),
            'altitude' => $state[7] ? round($state[7] * 3.28084) : null, // metre -> feet
            'heading' => round($state[10] ?? 0),
            'velocity' => $state[9] ? round($state[9] * 1.944) : null, // m/s -> knots
            'verticalRate' => $state[11] ? round($state[11] * 196.85) : 0, // m/s -> ft/min
            'onGround' => $state[8],
            'delayed' => $isDelayed,
            'origin' => $airports[array_rand($airports)],
            'destination' => $airports[array_rand($airports)],
            'lastUpdate' => $state[3]
        ];

        // Kalkış ve varış havaalanları aynı olmasın
        while ($flight['destination'] === $flight['origin']) {
            $flight['destination'] = $airports[array_rand($airports)];
        }

        $flights[] = $flight;
    }
}

echo json_encode([
    'flights' => $flights,
    'total' => count($flights),
    'timestamp' => time()
]); 
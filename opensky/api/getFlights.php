<?php
header("Content-Type: application/json");

// Türkiye'nin sınırları (yaklaşık değerler)
$minLatitude = 35.5;
$maxLatitude = 42.5;
$minLongitude = 25.5;
$maxLongitude = 45.0;

$url = "https://opensky-network.org/api/states/all?lamin=$minLatitude&lamax=$maxLatitude&lomin=$minLongitude&lomax=$maxLongitude";
$response = file_get_contents($url);

if ($response === false) {
    echo json_encode(["status" => "error", "message" => "OpenSky Network API'sine bağlanılamadı veya veri alınamadı."]);
} elseif (empty($response)) {
    echo json_encode(["status" => "warning", "message" => "OpenSky Network API'sinden boş bir yanıt alındı."]);
} else {
    echo $response;
    // Veri başarıyla alındıysa durumu yazdır (sadece kontrol amaçlı)
    echo "\n";
}

?>
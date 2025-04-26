<?php
header('Content-Type: application/json');

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-scout:free';

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);
$mapBounds = $data['mapBounds'] ?? null;

if (!$mapBounds) {
    echo json_encode(['error' => 'Harita sınırları belirtilmedi']);
    exit;
}

// Prepare the prompt for flight analysis
$prompt = "Türkiye üzerindeki uçuşları analiz et ve aşağıdaki başlıklarda detaylı bir rapor hazırla:\n";
$prompt .= "1. Genel Uçuş Durumu\n";
$prompt .= "2. Yoğun Uçuş Bölgeleri\n";
$prompt .= "3. Potansiyel Gecikme Riskleri\n";
$prompt .= "4. Hava Trafiği Önerileri\n";
$prompt .= "5. Operasyonel İyileştirme Önerileri\n\n";
$prompt .= "Harita sınırları: " . json_encode($mapBounds);

$messages = [
    [
        "role" => "user",
        "content" => [
            [
                "type" => "text",
                "text" => $prompt
            ]
        ]
    ]
];

$post_fields = json_encode([
    "model" => $model,
    "messages" => $messages,
    "temperature" => 0.7,
    "max_tokens" => 2000
], JSON_UNESCAPED_UNICODE);

$headers = [
    "Content-Type: application/json",
    "Authorization: Bearer $api_key",
    "HTTP-Referer: https://opensky.com",
    "X-Title: OpenSky iPaaS"
];

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_error = curl_error($ch);
curl_close($ch);

if ($http_code === 200 && !$curl_error) {
    $response_data = json_decode($result, true);
    $analysis = $response_data['choices'][0]['message']['content'] ?? 'Yanıt alınamadı.';
    echo json_encode(['analysis' => $analysis]);
} else {
    echo json_encode(['error' => "API hatası: $curl_error (HTTP kodu: $http_code)"]);
} 
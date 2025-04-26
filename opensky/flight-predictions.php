<?php
include 'views/header.php';

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-maverick:free';

$response = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['prediction_type'])) {
    $prediction_type = $_POST['prediction_type'];
    $flight_number = $_POST['flight_number'] ?? '';
    $date = $_POST['date'] ?? date('Y-m-d');
    $origin = $_POST['origin'] ?? '';
    $destination = $_POST['destination'] ?? '';
    
    // Prepare the prompt based on prediction type
    $prompt = "Havacılık sektöründe {$prediction_type} konusunda tahmin yap. ";
    if (!empty($flight_number)) {
        $prompt .= "Uçuş numarası: {$flight_number}. ";
    }
    if (!empty($date)) {
        $prompt .= "Tarih: {$date}. ";
    }
    if (!empty($origin) && !empty($destination)) {
        $prompt .= "Rota: {$origin} - {$destination}. ";
    }
    
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
        "max_tokens" => 1000
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
        $response = $response_data['choices'][0]['message']['content'] ?? 'Yanıt alınamadı.';
    } else {
        $error = "API hatası: $curl_error (HTTP kodu: $http_code)";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="prediction-card">
                <h2 class="text-center mb-4">Uçuş Tahminleri</h2>
                
                <form method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="prediction_type">Tahmin Türü:</label>
                        <select class="form-control" id="prediction_type" name="prediction_type" required>
                            <option value="">Seçiniz...</option>
                            <option value="uçuş gecikmesi">Uçuş Gecikmesi</option>
                            <option value="yakıt tüketimi">Yakıt Tüketimi</option>
                            <option value="hava trafiği yoğunluğu">Hava Trafiği Yoğunluğu</option>
                            <option value="bagaj teslim süresi">Bagaj Teslim Süresi</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="flight_number">Uçuş Numarası (Opsiyonel):</label>
                        <input type="text" class="form-control" id="flight_number" name="flight_number" placeholder="Örn: TK123">
                    </div>
                    
                    <div class="form-group">
                        <label for="date">Tarih:</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="origin">Kalkış Noktası (Opsiyonel):</label>
                            <input type="text" class="form-control" id="origin" name="origin" placeholder="Örn: IST">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="destination">Varış Noktası (Opsiyonel):</label>
                            <input type="text" class="form-control" id="destination" name="destination" placeholder="Örn: JFK">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Tahmin Et</button>
                </form>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($response): ?>
                    <div class="prediction-result">
                        <h3 class="mb-3">Tahmin Sonucu:</h3>
                        <div class="result-content">
                            <?php echo nl2br(htmlspecialchars($response)); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.prediction-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.prediction-result {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.result-content {
    white-space: pre-wrap;
    line-height: 1.6;
}
</style>

<?php include 'views/footer.php'; ?> 
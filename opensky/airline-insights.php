<?php
include 'views/header.php';

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-maverick:free';

$response = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['airline_code'])) {
    $airline_code = $_POST['airline_code'];
    $analysis_type = $_POST['analysis_type'];
    $time_period = $_POST['time_period'] ?? 'son 1 ay';
    
    // Prepare the prompt based on analysis type
    $prompt = "Havayolu şirketi {$airline_code} için {$analysis_type} konusunda detaylı bir analiz yap. ";
    $prompt .= "Zaman aralığı: {$time_period}. ";
    $prompt .= "Analiz sonuçlarını maddeler halinde ve sayısal verilerle destekleyerek sun.";
    
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
            <div class="insights-card">
                <h2 class="text-center mb-4">Havayolu İstatistikleri</h2>
                
                <form method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="airline_code">Havayolu Kodu:</label>
                        <input type="text" class="form-control" id="airline_code" name="airline_code" required placeholder="Örn: TK, LH, BA">
                    </div>
                    
                    <div class="form-group">
                        <label for="analysis_type">Analiz Türü:</label>
                        <select class="form-control" id="analysis_type" name="analysis_type" required>
                            <option value="">Seçiniz...</option>
                            <option value="uçuş performansı">Uçuş Performansı</option>
                            <option value="punctuality">Punctuality (Zamanında Kalkış/Varış)</option>
                            <option value="yolcu memnuniyeti">Yolcu Memnuniyeti</option>
                            <option value="operasyonel verimlilik">Operasyonel Verimlilik</option>
                            <option value="finansal performans">Finansal Performans</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="time_period">Zaman Aralığı:</label>
                        <select class="form-control" id="time_period" name="time_period">
                            <option value="son 1 hafta">Son 1 Hafta</option>
                            <option value="son 1 ay" selected>Son 1 Ay</option>
                            <option value="son 3 ay">Son 3 Ay</option>
                            <option value="son 6 ay">Son 6 Ay</option>
                            <option value="son 1 yıl">Son 1 Yıl</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Analiz Et</button>
                </form>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($response): ?>
                    <div class="insights-result">
                        <h3 class="mb-3">Analiz Sonucu:</h3>
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
.insights-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.insights-result {
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
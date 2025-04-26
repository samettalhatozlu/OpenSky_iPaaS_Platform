<?php
include 'views/header.php';

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-maverick:free';

$response = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['analysis_type'])) {
    $analysis_type = $_POST['analysis_type'];
    $additional_context = $_POST['additional_context'] ?? '';
    
    // Prepare the prompt based on analysis type
    $prompt = "Havacılık sektöründe {$analysis_type} konusunda detaylı bir analiz yap. ";
    if (!empty($additional_context)) {
        $prompt .= "Aşağıdaki bağlamı dikkate al: {$additional_context}";
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
            <div class="ai-analysis-card">
                <h2 class="text-center mb-4">AI Destekli Havacılık Analizi</h2>
                
                <form method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="analysis_type">Analiz Türü:</label>
                        <select class="form-control" id="analysis_type" name="analysis_type" required>
                            <option value="">Seçiniz...</option>
                            <option value="uçuş rotaları optimizasyonu">Uçuş Rotaları Optimizasyonu</option>
                            <option value="yakıt tüketimi analizi">Yakıt Tüketimi Analizi</option>
                            <option value="hava trafik yönetimi">Hava Trafik Yönetimi</option>
                            <option value="uçuş gecikmeleri tahmini">Uçuş Gecikmeleri Tahmini</option>
                            <option value="havaalanı kapasite planlaması">Havaalanı Kapasite Planlaması</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="additional_context">Ek Bağlam (Opsiyonel):</label>
                        <textarea class="form-control" id="additional_context" name="additional_context" rows="3" placeholder="Analiz için ek bilgiler giriniz..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Analiz Et</button>
                </form>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($response): ?>
                    <div class="analysis-result">
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
.ai-analysis-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.analysis-result {
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
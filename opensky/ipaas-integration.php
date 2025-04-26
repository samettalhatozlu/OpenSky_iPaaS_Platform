<?php
include 'views/header.php';

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-maverick:free';

$response = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['integration_type'])) {
    $integration_type = $_POST['integration_type'];
    $company_name = $_POST['company_name'] ?? '';
    $current_systems = $_POST['current_systems'] ?? '';
    $integration_goals = $_POST['integration_goals'] ?? '';
    
    // Prepare the prompt for integration analysis
    $prompt = "Havayolu şirketi {$company_name} için {$integration_type} entegrasyon sürecini analiz et ve görselleştir. ";
    if (!empty($current_systems)) {
        $prompt .= "Mevcut sistemler: {$current_systems}. ";
    }
    if (!empty($integration_goals)) {
        $prompt .= "Entegrasyon hedefleri: {$integration_goals}. ";
    }
    $prompt .= "Lütfen aşağıdaki başlıklarda detaylı bir analiz sun:";
    $prompt .= "\n1. Entegrasyon Mimarisi";
    $prompt .= "\n2. Veri Akış Diyagramı";
    $prompt .= "\n3. Sistem Bağlantıları";
    $prompt .= "\n4. Güvenlik Önlemleri";
    $prompt .= "\n5. Uygulama Adımları";
    $prompt .= "\n6. Potansiyel Zorluklar ve Çözümler";
    
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
        $response = $response_data['choices'][0]['message']['content'] ?? 'Yanıt alınamadı.';
    } else {
        $error = "API hatası: $curl_error (HTTP kodu: $http_code)";
    }
}
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="integration-card">
                <h2 class="text-center mb-4">iPaaS Entegrasyon Analizi</h2>
                
                <form method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="company_name">Havayolu Şirketi Adı:</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required placeholder="Örn: Türk Hava Yolları">
                    </div>
                    
                    <div class="form-group">
                        <label for="integration_type">Entegrasyon Türü:</label>
                        <select class="form-control" id="integration_type" name="integration_type" required>
                            <option value="">Seçiniz...</option>
                            <option value="rezervasyon sistemi">Rezervasyon Sistemi</option>
                            <option value="bagaj takip sistemi">Bagaj Takip Sistemi</option>
                            <option value="müşteri ilişkileri yönetimi">Müşteri İlişkileri Yönetimi</option>
                            <option value="uçuş operasyonları">Uçuş Operasyonları</option>
                            <option value="finansal sistemler">Finansal Sistemler</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="current_systems">Mevcut Sistemler (Opsiyonel):</label>
                        <textarea class="form-control" id="current_systems" name="current_systems" rows="3" placeholder="Mevcut kullandığınız sistemleri listeleyin..."></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="integration_goals">Entegrasyon Hedefleri (Opsiyonel):</label>
                        <textarea class="form-control" id="integration_goals" name="integration_goals" rows="3" placeholder="Entegrasyon ile ulaşmak istediğiniz hedefleri belirtin..."></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Analiz Et</button>
                </form>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($response): ?>
                    <div class="integration-result">
                        <h3 class="mb-3">Entegrasyon Analizi Sonucu:</h3>
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
.integration-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.integration-result {
    margin-top: 20px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}

.result-content {
    white-space: pre-wrap;
    line-height: 1.6;
}

.result-content h4 {
    color: #007bff;
    margin-top: 20px;
    margin-bottom: 10px;
}

.result-content ul {
    padding-left: 20px;
}

.result-content li {
    margin-bottom: 5px;
}
</style>

<?php include 'views/footer.php'; ?> 
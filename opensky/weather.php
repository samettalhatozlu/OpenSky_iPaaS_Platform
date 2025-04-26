<?php
include 'views/header.php';

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-maverick:free';

$response = null;
$error = null;
$current_date = date('d.m.Y');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['city'])) {
    $city = $_POST['city'];
    $country = $_POST['country'] ?? 'TR';
    
    // Prepare the prompt for weather information
    $prompt = "İzmir şehri için güncel hava durumu bilgilerini detaylı bir şekilde açıkla. ";
    $prompt .= "Sıcaklık, nem, rüzgar hızı, hava durumu açıklaması ve diğer önemli meteorolojik bilgileri içeren bir rapor hazırla. ";
    $prompt .= "Tarih: {$current_date}. ";
    $prompt .= "Lütfen bilgileri maddeler halinde ve sayısal değerlerle birlikte sun.";
    
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
            <div class="weather-card">
                <h2 class="text-center mb-4">İzmir Hava Durumu</h2>
                <p class="text-center text-muted">Güncel Tarih: <?php echo $current_date; ?></p>
                
                <form method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="city">Şehir:</label>
                        <input type="text" class="form-control" id="city" name="city" value="İzmir" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="country">Ülke:</label>
                        <input type="text" class="form-control" id="country" name="country" value="TR" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Hava Durumunu Güncelle</button>
                </form>
                
                <?php if ($error): ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($response): ?>
                    <div class="weather-info">
                        <div class="weather-details">
                            <?php echo nl2br(htmlspecialchars($response)); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        Hava durumu bilgisi almak için "Hava Durumunu Güncelle" butonuna tıklayın.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.weather-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.weather-details {
    font-size: 1.1em;
    line-height: 1.6;
    white-space: pre-wrap;
}

.weather-details p {
    margin: 10px 0;
}

.weather-details i {
    width: 30px;
    color: #007bff;
}
</style>

<?php include 'views/footer.php'; ?> 
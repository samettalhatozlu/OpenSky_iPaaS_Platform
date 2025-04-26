<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Enable CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Create logs directory if it doesn't exist
$logDir = __DIR__ . '/../logs';
if (!file_exists($logDir)) {
    mkdir($logDir, 0777, true);
}

function writeLog($message, $type = 'info') {
    global $logDir;
    $date = date('Y-m-d H:i:s');
    $logMessage = "[$date] [$type] $message\n";
    file_put_contents($logDir . '/chat.log', $logMessage, FILE_APPEND);
}

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// OpenRouter API configuration
$api_key = '*';
$api_url = 'https://openrouter.ai/api/v1/chat/completions';
$model = 'meta-llama/llama-4-scout:free';  // Daha stabil bir model kullanıyoruz

try {
    // Get the raw POST data
    $rawData = file_get_contents('php://input');
    writeLog("Received request data: " . $rawData);

    // Decode JSON data
    $data = json_decode($rawData, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON: ' . json_last_error_msg());
    }

    // Extract message content
    $messageContent = $data['message'] ?? '';
    if (empty($messageContent)) {
        throw new Exception('Message is required');
    }

    // Prepare system message
    $systemMessage = [
        'role' => 'system',
        'content' => "Sen arkadaş canlısı bir havacılık asistanısın. Havacılık, uçuşlar, havalimanları ve seyahat konularında bilgi verirsin. 
        Yanıtların kısa, net ve sohbet tarzında olmalı. Karmaşık havacılık terimlerini basitçe açıklamalısın.
        Her zaman Türkçe konuşmalı ve samimi bir dil kullanmalısın."
    ];

    // Prepare user message
    $userMessage = [
        'role' => 'user',
        'content' => is_array($messageContent) ? $messageContent : $messageContent
    ];

    // Prepare the request to OpenRouter API
    $requestData = [
        'model' => $model,
        'messages' => [$systemMessage, $userMessage],
        'temperature' => 0.7,
        'max_tokens' => 500,
        'top_p' => 0.9,
        'frequency_penalty' => 0.0,
        'presence_penalty' => 0.0
    ];

    writeLog("Sending request to OpenRouter: " . json_encode($requestData));

    // Initialize cURL session
    $ch = curl_init($api_url);
    if ($ch === false) {
        throw new Exception('Failed to initialize cURL');
    }

    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($requestData),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
            'HTTP-Referer: https://openrouter.ai/@localhost',
            'X-Title: OpenSky iPaaS'
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0
    ]);

    // Execute the request
    $response = curl_exec($ch);
    writeLog("API Response: " . $response);

    if ($response === false) {
        $error = curl_error($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        throw new Exception("cURL Error ($errno): $error");
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception("API returned non-200 status code: $httpCode");
    }

    $result = json_decode($response, true);
    if (!isset($result['choices'][0]['message']['content'])) {
        throw new Exception('Invalid response structure from API');
    }

    $aiResponse = $result['choices'][0]['message']['content'];
    writeLog("AI Response: " . $aiResponse);

    echo json_encode([
        'success' => true,
        'message' => $aiResponse
    ]);

} catch (Exception $e) {
    writeLog("Error: " . $e->getMessage(), 'error');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 
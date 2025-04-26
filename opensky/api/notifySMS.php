<?php
require '../vendor/autoload.php';

// Twilio Hesap Bilgilerinizi Buraya Girin
$sid = "*";
$token = "*"; 

if (isset($_POST['phone']) && isset($_POST['message'])) {
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    try {
        $client = new \Twilio\Rest\Client($sid, $token);
        $message = $client->messages->create(
            $phone, 
            [
                'from' => '*',
                'body' => $message,
            ]
        );
        echo json_encode(["message" => "SMS başarıyla gönderildi.", "sid" => $message->sid]);
    } catch (\Twilio\Exceptions\RestException $e) {
        http_response_code(500);
        echo json_encode(["error" => "Twilio hatası: " . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "Telefon numarası ve mesaj belirtilmedi."]);
}
?>
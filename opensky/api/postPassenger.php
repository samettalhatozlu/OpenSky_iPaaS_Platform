<?php
header("Content-Type: application/json");
require '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($name) && !empty($email)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO passengers (name, email) VALUES (?, ?)");
            $stmt->execute([$name, $email]);
            $passengerId = $pdo->lastInsertId();
            echo json_encode(["message" => "Yolcu başarıyla eklendi.", "id" => $passengerId]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(["message" => "Veritabanı hatası: " . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["message" => "Lütfen tüm alanları doldurun."]);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Sadece POST metodu kabul edilir."]);
}
?>
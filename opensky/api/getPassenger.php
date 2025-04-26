<?php
header("Content-Type: application/json");
require '../config.php';

if (isset($_GET['id'])) {
    $passengerId = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT * FROM passengers WHERE id = ?");
        $stmt->execute([$passengerId]);
        $passenger = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($passenger) {
            echo json_encode($passenger);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Yolcu bulunamadı."]);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(["message" => "Veritabanı hatası: " . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Yolcu ID'si belirtilmedi."]);
}
?>
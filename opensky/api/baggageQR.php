<?php
require '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if (isset($_GET['id'])) {
    $baggageId = $_GET['id'];
    $qrCode = QrCode::create("https://opensky.com/baggage?id=$baggageId")
        ->setSize(200)
        ->setMargin(10);

    $writer = new PngWriter();
    header('Content-Type: image/png');
    echo $writer->write($qrCode)->getString();
} else {
    http_response_code(400);
    echo "Bagaj ID'si belirtilmedi.";
}
?>
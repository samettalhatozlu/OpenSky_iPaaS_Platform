<?php
$title = "PIREP Bilgileri";
include 'header.php';

function getPirepData() {
    $apiUrl = "https://aviationweather.gov/api/data/pirep";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return ['error' => 'API bağlantı hatası: ' . curl_error($ch)];
    }

    curl_close($ch);

    return $response; // Ham metin veriyi döndür
}

$pirepRawData = getPirepData();
$pirepArray = [];

if (isset($pirepRawData['error'])) {
    $error = $pirepRawData['error'];
} else {
    // Ham metin verisini satırlara ayır
    $pirepLines = explode("\n", trim($pirepRawData));

    // Her satırı işle ve anlamlı verilere ayır (basit bir ayrıştırma örneği)
    foreach ($pirepLines as $line) {
        if (strpos($line, 'ARP') === 0) {
            $parts = preg_split('/\s+/', trim($line));
            if (count($parts) >= 8) {
                $pirepArray[] = [
                    'raw_text' => htmlspecialchars($line),
                    'location' => htmlspecialchars(substr($parts[1], 3)), // 'ARP ' kısmını atla
                    'time' => htmlspecialchars($parts[2]),
                    'altitude' => htmlspecialchars(substr($parts[3], 1)), // 'F' kısmını atla
                    'report' => htmlspecialchars(implode(' ', array_slice($parts, 4)))
                ];
            }
        }
    }
}
?>

<div class="container mt-4">
    <h2 class="text-center mb-4"><i class="fas fa-plane-departure me-2"></i>Pilot Raporları (PIREP)</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Hata:</strong> <?php echo $error; ?>
        </div>
    <?php elseif (!empty($pirepArray)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="bg-secondary text-white">
                    <tr>
                        <th>Ham Rapor</th>
                        <th>Konum</th>
                        <th>Zaman (UTC)</th>
                        <th>Rakım (ft)</th>
                        <th>Detaylar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pirepArray as $pirep): ?>
                        <tr>
                            <td><?php echo $pirep['raw_text']; ?></td>
                            <td><?php echo $pirep['location']; ?></td>
                            <td><?php echo $pirep['time']; ?></td>
                            <td><?php echo $pirep['altitude']; ?></td>
                            <td><?php echo $pirep['report']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Henüz herhangi bir PIREP raporu bulunmamaktadır veya veri ayrıştırılamadı.
        </div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
<?php include 'header.php'; ?>
    <h2>Yeni Yolcu Ekle</h2>
    <form method="POST" action="../api/postPassenger.php">
        <div>
            <label for="name">Ad Soyad:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Kaydet</button>
    </form>
<?php include 'footer.php'; ?>
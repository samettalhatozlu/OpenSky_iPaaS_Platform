document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([39.92, 32.85], 6); // Türkiye merkezli başlangıç görünümü

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var flightDetailsDiv = document.getElementById('flight-details');

    function updateFlights() {
        fetch('api/getFlights.php')
            .then(res => res.json())
            .then(data => {
                // Önceki işaretçileri temizle
                map.eachLayer(layer => {
                    if (layer instanceof L.Marker) {
                        map.removeLayer(layer);
                    }
                });

                if (data && data.states) {
                    data.states.forEach(flight => {
                        const latitude = flight[6];
                        const longitude = flight[5];
                        const callsign = flight[1] || 'Bilinmiyor';
                        const originCountry = flight[2] || 'Bilinmiyor';
                        const onGround = flight[8] ? 'Evet' : 'Hayır';
                        const velocity = flight[9] ? flight[9].toFixed(2) + ' m/s' : 'Bilinmiyor';
                        const altitude = flight[7] ? flight[7].toFixed(2) + ' metre' : 'Bilinmiyor';

                        if (typeof latitude === 'number' && typeof longitude === 'number') {
                            var marker = L.marker([latitude, longitude])
                                .addTo(map)
                                .bindPopup(`Uçuş Kodu: ${callsign}`);

                            // İşaretçiye tıklanınca detayları göster
                            marker.on('click', function() {
                                flightDetailsDiv.innerHTML = `
                                    <h3>Uçuş Detayları</h3>
                                    <p><strong>Uçuş Kodu:</strong> ${callsign}</p>
                                    <p><strong>Kalkış Ülkesi:</strong> ${originCountry}</p>
                                    <p><strong>Yerde mi:</strong> ${onGround}</p>
                                    <p><strong>Hız:</strong> ${velocity}</p>
                                    <p><strong>Yükseklik:</strong> ${altitude}</p>
                                    `;
                            });
                        }
                    });
                }
            })
            .catch(error => {
                console.error("Uçuş verisi alınırken hata oluştu:", error);
            });
    }

    // İlk yüklemede uçuşları getir
    updateFlights();

    // Belirli aralıklarla uçuş verilerini güncelle
    setInterval(updateFlights, 5000);

    // Haritayı yenile butonu
    document.getElementById('refresh-map').addEventListener('click', updateFlights);
});
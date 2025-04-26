<?php include 'views/header.php'; ?>

<div class="flight-tracker-container">
    <div class="sidebar">
        <div class="search-box">
            <h3><i class="fas fa-search"></i> Uçuş Ara</h3>
            <div class="search-inputs">
                <input type="text" id="flightSearch" class="form-control" placeholder="Uçuş kodu veya havayolu">
                <select id="filterType" class="form-select">
                    <option value="all">Tüm Uçuşlar</option>
                    <option value="departures">Kalkışlar</option>
                    <option value="arrivals">Varışlar</option>
                    <option value="delayed">Gecikmeli</option>
                </select>
            </div>
        </div>

        <div class="flight-list">
            <h3><i class="fas fa-plane"></i> Aktif Uçuşlar</h3>
            <div id="flightsList" class="flights-container">
                <!-- Uçuşlar JavaScript ile doldurulacak -->
            </div>
        </div>

        <div class="stats-box">
            <h3><i class="fas fa-chart-pie"></i> İstatistikler</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <i class="fas fa-plane text-primary"></i>
                    <span id="totalFlights">0</span>
                    <small>Toplam Uçuş</small>
                </div>
                <div class="stat-item">
                    <i class="fas fa-plane-departure text-success"></i>
                    <span id="departingFlights">0</span>
                    <small>Kalkan</small>
                </div>
                <div class="stat-item">
                    <i class="fas fa-plane-arrival text-info"></i>
                    <span id="arrivingFlights">0</span>
                    <small>İnen</small>
                </div>
                <div class="stat-item">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    <span id="delayedFlights">0</span>
                    <small>Gecikmeli</small>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="map-container">
            <div id="map"></div>
            <div class="map-controls">
                <button id="refreshMap" class="btn btn-outline-primary">
                    <i class="fas fa-sync-alt"></i> Yenile
                </button>
                <div class="map-layers">
                    <button id="toggleHeatmap" class="btn btn-outline-secondary">
                        <i class="fas fa-fire"></i> Yoğunluk Haritası
                    </button>
                    <button id="toggleWeather" class="btn btn-outline-info">
                        <i class="fas fa-cloud"></i> Hava Durumu
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.flight-tracker-container {
    display: flex;
    height: calc(100vh - 60px);
    background: var(--bg-light);
}

.sidebar {
    width: 400px;
    background: var(--bg-color);
    box-shadow: var(--shadow);
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    overflow-y: auto;
}

.search-box, .flight-list, .stats-box {
    background: white;
    border-radius: 10px;
    padding: 15px;
    box-shadow: var(--shadow-sm);
}

.search-box h3, .flight-list h3, .stats-box h3 {
    font-size: 1.2rem;
    color: var(--primary-color);
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.search-inputs {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.flights-container {
    max-height: 400px;
    overflow-y: auto;
}

.flight-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.flight-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.flight-item.delayed {
    border-left: 4px solid var(--warning-color);
}

.flight-item.on-time {
    border-left: 4px solid var(--success-color);
}

.flight-info {
    flex: 1;
}

.flight-callsign {
    font-weight: 600;
    color: var(--primary-color);
}

.flight-route {
    font-size: 0.9em;
    color: var(--text-light);
}

.flight-status {
    font-size: 0.8em;
    padding: 4px 8px;
    border-radius: 12px;
}

.status-delayed {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning-color);
}

.status-ontime {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success-color);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.stat-item {
    text-align: center;
    padding: 15px;
    background: var(--bg-light);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.stat-item i {
    font-size: 1.5rem;
    margin-bottom: 5px;
}

.stat-item span {
    display: block;
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--text-color);
}

.stat-item small {
    color: var(--text-light);
}

.main-content {
    flex: 1;
    padding: 20px;
}

.map-container {
    height: 100%;
    background: white;
    border-radius: 10px;
    box-shadow: var(--shadow);
    overflow: hidden;
    position: relative;
}

#map {
    height: 100%;
}

.map-controls {
    position: absolute;
    top: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
    z-index: 1000;
}

.map-layers {
    display: flex;
    gap: 10px;
}

@media (max-width: 768px) {
    .flight-tracker-container {
        flex-direction: column;
    }

    .sidebar {
        width: 100%;
        height: auto;
        max-height: 50vh;
    }

    .main-content {
        height: 50vh;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Harita başlatma
    var map = L.map('map').setView([39.92, 32.85], 6);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Uçuş listesini güncelleme fonksiyonu
    function updateFlightsList(flights) {
        const flightsList = document.getElementById('flightsList');
        flightsList.innerHTML = '';

        flights.forEach(flight => {
            const flightItem = document.createElement('div');
            flightItem.className = `flight-item ${flight.delayed ? 'delayed' : 'on-time'}`;
            flightItem.innerHTML = `
                <div class="flight-info">
                    <div class="flight-callsign">${flight.callsign}</div>
                    <div class="flight-route">${flight.origin} → ${flight.destination}</div>
                </div>
                <span class="flight-status ${flight.delayed ? 'status-delayed' : 'status-ontime'}">
                    ${flight.delayed ? 'Gecikmeli' : 'Zamanında'}
                </span>
            `;

            flightItem.addEventListener('click', () => {
                map.setView([flight.latitude, flight.longitude], 9);
                // Uçuş detaylarını göster
                fetch(`api/get-flight-details.php?icao24=${flight.icao24}`)
                    .then(response => response.json())
                    .then(details => {
                        showFlightDetails(details, flight);
                    });
            });

            flightsList.appendChild(flightItem);
        });

        // İstatistikleri güncelle
        document.getElementById('totalFlights').textContent = flights.length;
        document.getElementById('delayedFlights').textContent = 
            flights.filter(f => f.delayed).length;
        document.getElementById('departingFlights').textContent = 
            flights.filter(f => f.verticalRate > 0).length;
        document.getElementById('arrivingFlights').textContent = 
            flights.filter(f => f.verticalRate < 0).length;
    }

    // Uçuşları getir ve güncelle
    function fetchAndUpdateFlights() {
        fetch('api/get-flights.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    console.error('Hata:', data.error);
                    return;
                }
                updateFlightsList(data.flights || []);
                updateMapMarkers(data.flights || []);
            })
            .catch(error => {
                console.error('Uçuş verileri alınamadı:', error);
            });
    }

    // Harita işaretçilerini güncelleme
    function updateMapMarkers(flights) {
        // Önceki işaretçileri temizle
        map.eachLayer((layer) => {
            if (layer instanceof L.Marker) {
                map.removeLayer(layer);
            }
        });

        // Yeni işaretçileri ekle
        flights.forEach(flight => {
            const marker = L.marker([flight.latitude, flight.longitude])
                .on('click', function() {
                    fetch(`api/get-flight-details.php?icao24=${flight.icao24}`)
                        .then(response => response.json())
                        .then(details => {
                            const popup = L.popup()
                                .setLatLng(marker.getLatLng())
                                .setContent(`
                                    <div class="flight-popup">
                                        <div class="flight-header">
                                            <h4>${flight.callsign || 'N/A'}</h4>
                                            <span class="aircraft-type">${details.aircraftType || 'N/A'}</span>
                                        </div>
                                        <div class="flight-details">
                                            <div class="detail-section">
                                                <h5><i class="fas fa-info-circle"></i> Uçuş Bilgileri</h5>
                                                <p><i class="fas fa-plane-departure"></i> <strong>Kalkış:</strong> ${flight.origin || 'N/A'}</p>
                                                <p><i class="fas fa-plane-arrival"></i> <strong>Varış:</strong> ${flight.destination || 'N/A'}</p>
                                                <p><i class="fas fa-clock"></i> <strong>Durum:</strong> 
                                                    <span class="${flight.delayed ? 'text-warning' : 'text-success'}">
                                                        ${flight.delayed ? 'Gecikmeli' : 'Zamanında'}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="detail-section">
                                                <h5><i class="fas fa-chart-line"></i> Teknik Veriler</h5>
                                                <p><i class="fas fa-ruler-vertical"></i> <strong>İrtifa:</strong> ${details.altitude || flight.altitude || 'N/A'} ft</p>
                                                <p><i class="fas fa-tachometer-alt"></i> <strong>Hız:</strong> ${details.velocity || flight.velocity || 'N/A'} knots</p>
                                                <p><i class="fas fa-compass"></i> <strong>Yön:</strong> ${details.heading || flight.heading || 'N/A'}°</p>
                                                <p><i class="fas fa-angle-up"></i> <strong>Dikey Hız:</strong> ${details.verticalRate || 'N/A'} ft/min</p>
                                            </div>
                                            <div class="detail-section">
                                                <h5><i class="fas fa-cog"></i> Operasyonel Bilgiler</h5>
                                                <p><i class="fas fa-fingerprint"></i> <strong>ICAO24:</strong> ${flight.icao24}</p>
                                                <p><i class="fas fa-flag"></i> <strong>Ülke:</strong> ${details.origin_country || 'N/A'}</p>
                                                <p><i class="fas fa-broadcast-tower"></i> <strong>Squawk:</strong> ${details.squawk || 'N/A'}</p>
                                            </div>
                                        </div>
                                    </div>
                                `)
                                .openOn(map);
                        });
                });
            
            if (flight.delayed) {
                marker.setIcon(L.divIcon({
                    className: 'delayed-flight-marker',
                    html: '<i class="fas fa-plane text-warning"></i>'
                }));
            } else {
                marker.setIcon(L.divIcon({
                    className: 'ontime-flight-marker',
                    html: '<i class="fas fa-plane text-success"></i>'
                }));
            }
            
            marker.addTo(map);
        });
    }

    // Arama fonksiyonu
    document.getElementById('flightSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const filterType = document.getElementById('filterType').value;
        
        fetch('api/get-flights.php')
            .then(response => response.json())
            .then(data => {
                if (data.error) return;
                
                let flights = data.flights || [];
                
                // Filtreleme
                flights = flights.filter(flight => {
                    const matchesSearch = 
                        flight.callsign.toLowerCase().includes(searchTerm) ||
                        flight.origin.toLowerCase().includes(searchTerm) ||
                        flight.destination.toLowerCase().includes(searchTerm);
                        
                    if (!matchesSearch) return false;
                    
                    switch(filterType) {
                        case 'departures':
                            return flight.verticalRate > 0;
                        case 'arrivals':
                            return flight.verticalRate < 0;
                        case 'delayed':
                            return flight.delayed;
                        default:
                            return true;
                    }
                });
                
                updateFlightsList(flights);
                updateMapMarkers(flights);
            });
    });

    // Filtre değişikliği
    document.getElementById('filterType').addEventListener('change', function() {
        document.getElementById('flightSearch').dispatchEvent(new Event('input'));
    });

    // Harita yenileme butonu
    document.getElementById('refreshMap').addEventListener('click', fetchAndUpdateFlights);

    // Yoğunluk haritası toggle
    let heatmapLayer = null;
    document.getElementById('toggleHeatmap').addEventListener('click', function() {
        if (heatmapLayer) {
            map.removeLayer(heatmapLayer);
            heatmapLayer = null;
            this.classList.remove('active');
        } else {
            fetch('api/get-flights.php')
                .then(response => response.json())
                .then(data => {
                    if (data.error) return;
                    
                    const points = (data.flights || []).map(flight => [
                        flight.latitude,
                        flight.longitude,
                        flight.delayed ? 1 : 0.5
                    ]);
                    
                    heatmapLayer = L.heatLayer(points, {
                        radius: 25,
                        blur: 15,
                        maxZoom: 10
                    }).addTo(map);
                    
                    this.classList.add('active');
                });
        }
    });

    // İlk yükleme
    fetchAndUpdateFlights();
    
    // Otomatik yenileme (30 saniyede bir)
    setInterval(fetchAndUpdateFlights, 30000);
});
</script>

<?php include 'views/footer.php'; ?> 
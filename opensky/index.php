<?php include 'views/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>OpenSky iPaaS</h1>
            <p class="hero-subtitle">Yapay Zeka Destekli Havacılık Entegrasyon Platformu</p>
            <div class="hero-buttons">
                <a href="flight-tracker.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-plane"></i> Uçuş Takibi
                </a>
                <a href="#ai-features" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-brain"></i> AI Özellikleri
                </a>
            </div>
        </div>
    </div>
    <div class="hero-background">
        <div class="particles" id="particles-js"></div>
    </div>
</section>

<!-- AI Chat Section -->
<div class="chat-container">
    <div class="chat-header">
        <div class="d-flex align-items-center">
            <i class="fas fa-robot me-2"></i>
            <div>
                <h3 class="mb-0">AI Asistan</h3>
                <p class="text-muted mb-0"><small>Havacılık verilerinizi analiz ediyorum...</small></p>
            </div>
        </div>
        <button id="refreshChat" class="btn btn-light btn-sm">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
    <div id="chatMessages" class="chat-messages"></div>
    <div class="chat-input-container">
        <div id="typingIndicator" class="typing-indicator" style="display: none;">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="image-preview" id="imagePreview"></div>
        <div class="chat-input">
            <label for="imageUpload" class="image-upload-btn">
                <i class="fas fa-image"></i>
            </label>
            <input type="file" id="imageUpload" accept="image/*" style="display: none;">
            <input type="text" id="userInput" placeholder="Mesajınızı yazın...">
            <button id="sendMessage">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

<!-- AI Chat & Visualization Section -->
<section class="ai-interaction-section" id="ai-features">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="visualization-container">
                    <div class="viz-header">
                        <div>
                            <h3 class="mb-0"><i class="fas fa-chart-network"></i> Canlı Veri Görselleştirme</h3>
                            <p class="text-muted mb-0"><small>Gerçek zamanlı uçuş verileri</small></p>
                        </div>
                        <div class="viz-controls btn-group">
                            <button class="btn btn-primary active" data-viz="traffic">
                                <i class="fas fa-plane"></i> Trafik Analizi
                            </button>
                            <button class="btn btn-outline-primary" data-viz="performance">
                                <i class="fas fa-chart-line"></i> Performans
                            </button>
                            <button class="btn btn-outline-primary" data-viz="routes">
                                <i class="fas fa-route"></i> Rotalar
                            </button>
                        </div>
                    </div>
                    <div id="visualizationArea"></div>
                    <div class="viz-stats">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="stat-icon text-primary">
                                        <i class="fas fa-plane"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4 class="aktif-ucus">156</h4>
                                        <p>Aktif Uçuş</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="stat-icon text-success">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4 class="zamaninda">142</h4>
                                        <p>Zamanında</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="stat-card">
                                    <div class="stat-icon text-warning">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h4 class="gecikmeli">14</h4>
                                        <p>Gecikmeli</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- iPaaS Features Section -->
<section class="ipaas-features">
    <div class="container">
        <div class="section-header text-center">
            <h2>iPaaS Çözümlerimiz</h2>
            <p>Havacılık operasyonlarınızı optimize edin</p>
        </div>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-project-diagram"></i>
                </div>
                <h3>Süreç Görselleştirme</h3>
                <p>Drag & drop arayüzü ile iş süreçlerinizi kolayca tasarlayın</p>
                <a href="#" class="btn btn-outline-primary btn-sm">Detaylı Bilgi</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <h3>Veri Entegrasyonu</h3>
                <p>Farklı sistemler arasında kesintisiz veri akışı sağlayın</p>
                <a href="#" class="btn btn-outline-primary btn-sm">Detaylı Bilgi</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h3>AI Analitik</h3>
                <p>Yapay zeka ile verilerinizden değer üretin</p>
                <a href="#" class="btn btn-outline-primary btn-sm">Detaylı Bilgi</a>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Gerçek Zamanlı İzleme</h3>
                <p>Operasyonlarınızı anlık takip edin</p>
                <a href="#" class="btn btn-outline-primary btn-sm">Detaylı Bilgi</a>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Process Designer -->
<section class="process-designer">
    <div class="container">
        <div class="section-header text-center">
            <h2>Süreç Tasarımcısı</h2>
            <p>Sürükle & Bırak ile kendi iş akışınızı oluşturun</p>
        </div>
        <div class="designer-container">
            <div class="toolbox">
                <div class="tool-group">
                    <h4>Bileşenler</h4>
                    <div class="tool-item" draggable="true" data-type="start">
                        <i class="fas fa-play-circle"></i> Başlangıç
                    </div>
                    <div class="tool-item" draggable="true" data-type="process">
                        <i class="fas fa-cog"></i> Süreç
                    </div>
                    <div class="tool-item" draggable="true" data-type="decision">
                        <i class="fas fa-question-circle"></i> Karar
                    </div>
                    <div class="tool-item" draggable="true" data-type="end">
                        <i class="fas fa-stop-circle"></i> Bitiş
                    </div>
                </div>
                <div class="tool-group">
                    <h4>Bağlayıcılar</h4>
                    <div class="tool-item" draggable="true" data-type="connector">
                        <i class="fas fa-arrow-right"></i> Bağlayıcı
                    </div>
                </div>
            </div>
            <div class="canvas-container">
                <div id="processCanvas"></div>
            </div>
            <div class="properties-panel">
                <h4>Özellikler</h4>
                <div id="elementProperties">
                    <!-- Seçili eleman özellikleri buraya gelecek -->
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* Hero Section */
.hero-section {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-dark), var(--primary-color));
    overflow: hidden;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.hero-content h1 {
    font-size: 4rem;
    font-weight: 700;
    margin-bottom: 1rem;
    animation: fadeInUp 1s ease;
}

.hero-subtitle {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    animation: fadeInUp 1s ease 0.2s;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    animation: fadeInUp 1s ease 0.4s;
}

/* AI Interaction Section */
.ai-interaction-section {
    padding: 4rem 0;
    background: var(--bg-light);
}

.chat-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    z-index: 1000;
}

.chat-header {
    padding: 15px;
    background: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-header h3 {
    font-size: 16px;
    margin: 0;
    color: #2563eb;
}

.chat-header p {
    font-size: 12px;
    margin: 0;
}

.chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.message {
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    margin: 2px 0;
    word-wrap: break-word;
}

.user-message {
    background: #2563eb;
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 5px;
}

.ai-message {
    background: #f3f4f6;
    color: #1f2937;
    align-self: flex-start;
    border-bottom-left-radius: 5px;
}

.chat-input-container {
    padding: 15px;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
}

.chat-input {
    display: flex;
    gap: 10px;
}

#userInput {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    border-radius: 20px;
    outline: none;
    font-size: 14px;
}

#userInput:focus {
    border-color: #2563eb;
}

#sendMessage {
    background: #2563eb;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

#sendMessage:hover {
    background: #1d4ed8;
    transform: scale(1.05);
}

.typing-indicator {
    padding: 8px 15px;
    background: #f3f4f6;
    border-radius: 15px;
    margin-bottom: 10px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.typing-indicator span {
    width: 6px;
    height: 6px;
    background: #94a3b8;
    border-radius: 50%;
    animation: typing 1s infinite ease-in-out;
}

.typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
.typing-indicator span:nth-child(3) { animation-delay: 0.4s; }

@keyframes typing {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

@media (max-width: 768px) {
    .chat-container {
        width: 100%;
        height: 100%;
        bottom: 0;
        right: 0;
        border-radius: 0;
    }
}

/* Visualization Container */
.visualization-container {
    background: white;
    border-radius: 1rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.08);
    height: 600px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.viz-header {
    padding: 1.25rem;
    border-bottom: 1px solid rgba(0,0,0,0.08);
    background: #f8f9fa;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.viz-header h3 {
    font-size: 1.25rem;
    color: var(--primary-color);
}

.viz-controls {
    display: flex;
    gap: 0.5rem;
}

#visualizationArea {
    flex: 1;
    padding: 1.25rem;
    position: relative;
    overflow: hidden;
}

.viz-stats {
    padding: 1.25rem;
    border-top: 1px solid rgba(0,0,0,0.08);
    background: #f8f9fa;
}

.stat-card {
    background: white;
    border-radius: 0.75rem;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.04);
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    background: rgba(var(--primary-rgb), 0.1);
}

.stat-info {
    flex: 1;
}

.stat-info h4 {
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
}

.stat-info p {
    margin: 0;
    color: #6c757d;
    font-size: 0.875rem;
}

/* iPaaS Features */
.ipaas-features {
    padding: 4rem 0;
    background: white;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.feature-card {
    background: var(--bg-light);
    padding: 2rem;
    border-radius: 1rem;
    text-align: center;
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow);
}

.feature-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: var(--primary-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-icon i {
    font-size: 2rem;
    color: white;
}

/* Process Designer */
.process-designer {
    padding: 4rem 0;
    background: var(--bg-light);
}

.designer-container {
    display: grid;
    grid-template-columns: 200px 1fr 250px;
    gap: 1rem;
    margin-top: 2rem;
    background: white;
    border-radius: 1rem;
    box-shadow: var(--shadow);
    padding: 1rem;
    min-height: 600px;
}

.toolbox {
    border-right: 1px solid var(--border-color);
    padding-right: 1rem;
}

.tool-group {
    margin-bottom: 1.5rem;
}

.tool-group h4 {
    margin-bottom: 1rem;
    color: var(--primary-color);
    font-weight: 600;
}

.tool-item {
    padding: 0.75rem;
    background: var(--bg-light);
    border-radius: 0.5rem;
    margin-bottom: 0.75rem;
    cursor: move;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid var(--border-color);
}

.tool-item:hover {
    background: var(--primary-color);
    color: white;
    transform: translateY(-2px);
}

.tool-item i {
    font-size: 1.2rem;
}

.canvas-container {
    background: #f8f9fa;
    border-radius: 0.5rem;
    min-height: 600px;
    position: relative;
    border: 1px dashed var(--border-color);
}

#processCanvas {
    width: 100%;
    height: 100%;
    min-height: 600px;
    position: relative;
}

.process-element {
    width: 100px;
    height: 50px;
    background: white;
    border: 2px solid var(--primary-color);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: move;
    position: absolute;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.process-element:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
}

.process-element i {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-right: 0.5rem;
}

.process-element.start {
    background: #e8f5e9;
}

.process-element.process {
    background: #e3f2fd;
}

.process-element.decision {
    background: #fff3e0;
}

.process-element.end {
    background: #ffebee;
}

.properties-panel {
    border-left: 1px solid var(--border-color);
    padding-left: 1rem;
}

.properties-panel h4 {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: 1rem;
}

#elementProperties {
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 0.5rem;
}

.jtk-connector {
    z-index: 1;
}

.jtk-endpoint {
    z-index: 2;
}

.connect-point {
    width: 10px;
    height: 10px;
    background: var(--primary-color);
    border-radius: 50%;
    position: absolute;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .hero-content h1 {
        font-size: 3rem;
    }
    
    .designer-container {
        grid-template-columns: 1fr;
    }
    
    .toolbox, .properties-panel {
        border: none;
        padding: 1rem 0;
    }
}

@media (max-width: 767.98px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
}

/* Mevcut stiller korunacak */
.image-upload-btn {
    padding: 8px;
    cursor: pointer;
    color: #2563eb;
    transition: color 0.3s ease;
}

.image-upload-btn:hover {
    color: #1d4ed8;
}

.image-preview {
    padding: 10px;
    display: none;
}

.image-preview img {
    max-width: 200px;
    max-height: 150px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.image-preview .remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<!-- Particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<!-- D3.js for visualizations -->
<script src="https://d3js.org/d3.v7.min.js"></script>
<!-- jsPlumb for process designer -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsPlumb/2.15.6/js/jsplumb.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Particles.js başlatma
    particlesJS('particles-js', {
        particles: {
            number: { value: 80 },
            color: { value: '#ffffff' },
            shape: { type: 'circle' },
            opacity: { value: 0.5 },
            size: { value: 3 },
            line_linked: {
                enable: true,
                distance: 150,
                color: '#ffffff',
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2
            }
        }
    });

    const chatMessages = document.getElementById('chatMessages');
    const userInput = document.getElementById('userInput');
    const sendButton = document.getElementById('sendMessage');
    const refreshButton = document.getElementById('refreshChat');
    const typingIndicator = document.getElementById('typingIndicator');
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    
    let currentImage = null;
    let isProcessing = false;

    function addMessage(content, isAi = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isAi ? 'ai-message' : 'user-message'}`;
        messageDiv.textContent = content;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTyping() {
        typingIndicator.style.display = 'inline-flex';
    }

    function hideTyping() {
        typingIndicator.style.display = 'none';
    }

    async function processMessage(message) {
        if (!message.trim() || isProcessing) return;
        
        isProcessing = true;
        userInput.value = '';
        addMessage(message, false);
        showTyping();

        try {
            const response = await fetch('api/chat-assistant.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    message: message
                })
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            hideTyping();

            if (data.success && data.message) {
                addMessage(data.message, true);
            } else {
                throw new Error(data.error || 'Bir hata oluştu');
            }
        } catch (error) {
            console.error('Chat Error:', error);
            hideTyping();
            addMessage('Üzgünüm, bir hata oluştu. Lütfen tekrar deneyin.', true);
        } finally {
            isProcessing = false;
        }
    }

    // Image handling
    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                currentImage = e.target.result;
                imagePreview.style.display = 'block';
                imagePreview.innerHTML = `
                    <div style="position: relative; display: inline-block;">
                        <img src="${currentImage}" alt="Yüklenen görsel">
                        <button class="remove-image" onclick="removeImage()">×</button>
                    </div>
                `;
            };
            reader.readAsDataURL(file);
        }
    });

    window.removeImage = function() {
        currentImage = null;
        imagePreview.style.display = 'none';
        imagePreview.innerHTML = '';
        imageUpload.value = '';
    };

    // Event Listeners
    sendButton.addEventListener('click', () => {
        const message = userInput.value.trim();
        if (message) {
            processMessage(message);
        }
    });

    userInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            const message = userInput.value.trim();
            if (message) {
                processMessage(message);
            }
        }
    });

    refreshButton.addEventListener('click', () => {
        if (!isProcessing) {
            chatMessages.innerHTML = '';
            processMessage('Merhaba');
        }
    });

    // Başlangıç mesajı
    setTimeout(() => {
        processMessage('Merhaba');
    }, 1000);

    // Visualization Controls
    const vizButtons = document.querySelectorAll('.viz-controls .btn');
    vizButtons.forEach(button => {
        button.addEventListener('click', function() {
            vizButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            updateVisualization(this.dataset.viz);
        });
    });

    // D3.js Visualization
    function updateVisualization(type) {
        const vizArea = d3.select('#visualizationArea');
        vizArea.selectAll('*').remove();

        const width = vizArea.node().getBoundingClientRect().width;
        const height = 400;

        const svg = vizArea.append('svg')
            .attr('width', width)
            .attr('height', height);

        // Sample data
        const data = {
            nodes: Array.from({length: 20}, (_, i) => ({
                id: i,
                group: Math.floor(Math.random() * 3)
            })),
            links: Array.from({length: 30}, () => ({
                source: Math.floor(Math.random() * 20),
                target: Math.floor(Math.random() * 20),
                value: Math.random()
            }))
        };

        // Force-directed graph
        const simulation = d3.forceSimulation(data.nodes)
            .force('link', d3.forceLink(data.links).id(d => d.id))
            .force('charge', d3.forceManyBody().strength(-100))
            .force('center', d3.forceCenter(width / 2, height / 2));

        // Add links
        const link = svg.append('g')
            .selectAll('line')
            .data(data.links)
            .enter().append('line')
            .style('stroke', '#999')
            .style('stroke-opacity', 0.6)
            .style('stroke-width', d => Math.sqrt(d.value));

        // Add nodes
        const node = svg.append('g')
            .selectAll('circle')
            .data(data.nodes)
            .enter().append('circle')
            .attr('r', 5)
            .style('fill', d => ['#4299e1', '#48bb78', '#ed8936'][d.group])
            .call(d3.drag()
                .on('start', dragstarted)
                .on('drag', dragged)
                .on('end', dragended));

        // Add hover effects
        node.append('title')
            .text(d => `Node ${d.id}`);

        simulation.nodes(data.nodes)
            .on('tick', ticked);

        simulation.force('link')
            .links(data.links);

        function ticked() {
            link
                .attr('x1', d => d.source.x)
                .attr('y1', d => d.source.y)
                .attr('x2', d => d.target.x)
                .attr('y2', d => d.target.y);

            node
                .attr('cx', d => d.x)
                .attr('cy', d => d.y);
        }

        function dragstarted(event) {
            if (!event.active) simulation.alphaTarget(0.3).restart();
            event.subject.fx = event.subject.x;
            event.subject.fy = event.subject.y;
        }

        function dragged(event) {
            event.subject.fx = event.x;
            event.subject.fy = event.y;
        }

        function dragended(event) {
            if (!event.active) simulation.alphaTarget(0);
            event.subject.fx = null;
            event.subject.fy = null;
        }
    }

    // Initialize visualization
    updateVisualization('traffic');

    // Update stats periodically
    function updateStats() {
        const aktifUcus = Math.floor(Math.random() * 50) + 130;
        const gecikmeli = Math.floor(Math.random() * 20) + 5;
        const zamaninda = aktifUcus - gecikmeli;

        document.querySelector('.aktif-ucus').textContent = aktifUcus;
        document.querySelector('.zamaninda').textContent = zamaninda;
        document.querySelector('.gecikmeli').textContent = gecikmeli;
    }

    setInterval(updateStats, 5000);
    updateStats();

    // Süreç tasarımcısı
    const jsPlumbInstance = jsPlumb.getInstance({
        Container: 'processCanvas',
        Connector: ['Flowchart', { cornerRadius: 5 }],
        Anchors: ['Right', 'Left'],
        Endpoint: ['Dot', { radius: 5 }],
        PaintStyle: { stroke: '#4299e1', strokeWidth: 2 },
        HoverPaintStyle: { stroke: '#2563eb', strokeWidth: 3 },
        ConnectionOverlays: [
            ['Arrow', { location: 1, width: 12, length: 12, foldback: 0.8 }],
            ['Label', { label: '', cssClass: 'connection-label' }]
        ],
        DragOptions: { cursor: 'move' }
    });

    let elementCount = 0;

    // Sürükle & bırak işlevselliği
    const toolItems = document.querySelectorAll('.tool-item');
    const canvas = document.getElementById('processCanvas');

    toolItems.forEach(item => {
        item.addEventListener('dragstart', function(e) {
            e.dataTransfer.setData('text/plain', e.target.dataset.type);
        });
    });

    canvas.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'copy';
    });

    canvas.addEventListener('drop', function(e) {
        e.preventDefault();
        const type = e.dataTransfer.getData('text/plain');
        const rect = canvas.getBoundingClientRect();
        const element = document.createElement('div');
        
        elementCount++;
        const elementId = `element_${type}_${elementCount}`;
        
        element.id = elementId;
        element.className = `process-element ${type}`;
        element.innerHTML = `
            <i class="fas fa-${getIconForType(type)}"></i>
            <span>${getNameForType(type)}</span>
        `;
        
        // Position relative to canvas
        const x = e.clientX - rect.left - 50; // Center horizontally
        const y = e.clientY - rect.top - 25;  // Center vertically
        
        element.style.left = `${x}px`;
        element.style.top = `${y}px`;
        
        canvas.appendChild(element);
        
        // Make element draggable
        jsPlumbInstance.draggable(elementId, {
            containment: true,
            grid: [10, 10]
        });

        // Add endpoints based on element type
        if (type !== 'end') {
            jsPlumbInstance.addEndpoint(elementId, {
                anchor: 'Right',
                isSource: true,
                connectionType: 'basic',
                maxConnections: -1
            });
        }
        
        if (type !== 'start') {
            jsPlumbInstance.addEndpoint(elementId, {
                anchor: 'Left',
                isTarget: true,
                maxConnections: -1
            });
        }

        // Add click handler for properties
        element.addEventListener('click', function() {
            showProperties(elementId, type);
        });
    });

    function getIconForType(type) {
        const icons = {
            start: 'play-circle',
            process: 'cog',
            decision: 'question-circle',
            end: 'stop-circle',
            connector: 'arrow-right'
        };
        return icons[type] || 'circle';
    }

    function getNameForType(type) {
        const names = {
            start: 'Başlangıç',
            process: 'Süreç',
            decision: 'Karar',
            end: 'Bitiş',
            connector: 'Bağlayıcı'
        };
        return names[type] || type;
    }

    function showProperties(elementId, type) {
        const propertiesPanel = document.getElementById('elementProperties');
        propertiesPanel.innerHTML = `
            <div class="mb-3">
                <label class="form-label">Element ID</label>
                <input type="text" class="form-control" value="${elementId}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">Tip</label>
                <input type="text" class="form-control" value="${getNameForType(type)}" readonly>
            </div>
            <div class="mb-3">
                <label class="form-label">İsim</label>
                <input type="text" class="form-control" id="elementName" placeholder="Element adı">
            </div>
            <button class="btn btn-danger btn-sm" onclick="deleteElement('${elementId}')">
                <i class="fas fa-trash"></i> Sil
            </button>
        `;
    }

    // Add to window for access from inline onclick
    window.deleteElement = function(elementId) {
        jsPlumbInstance.remove(elementId);
        document.getElementById('elementProperties').innerHTML = '';
    };

    // Make canvas zoomable
    let scale = 1;
    const zoomSpeed = 0.1;
    
    canvas.addEventListener('wheel', function(e) {
        if (e.ctrlKey) {
            e.preventDefault();
            const delta = e.deltaY > 0 ? -zoomSpeed : zoomSpeed;
            scale = Math.max(0.5, Math.min(2, scale + delta));
            
            canvas.style.transform = `scale(${scale})`;
            jsPlumbInstance.setZoom(scale);
        }
    });
});
</script>

<?php include 'views/footer.php'; ?>
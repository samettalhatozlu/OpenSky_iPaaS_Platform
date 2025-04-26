</main>
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-brand">
                        <img src="assets/images/logo.png" alt="OpenSky Logo" height="40" class="mb-3">
                        <p class="text-muted">Havayolu Şirketleri İçin Yapay Zeka Destekli Entegrasyon Platformu</p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                    
                    <div class="footer-links">
                        <div class="footer-column">
                            <h5>Ürün</h5>
                            <ul>
                                <li><a href="features.php">Özellikler</a></li>
                                <li><a href="pricing.php">Fiyatlandırma</a></li>
                                <li><a href="integrations.php">Entegrasyonlar</a></li>
                                <li><a href="updates.php">Güncellemeler</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-column">
                            <h5>Kaynaklar</h5>
                            <ul>
                                <li><a href="documentation.php">Dokümantasyon</a></li>
                                <li><a href="api-docs.php">API Dokümantasyonu</a></li>
                                <li><a href="tutorials.php">Eğitimler</a></li>
                                <li><a href="blog.php">Blog</a></li>
                            </ul>
                        </div>
                        
                        <div class="footer-column">
                            <h5>Şirket</h5>
                            <ul>
                                <li><a href="about.php">Hakkımızda</a></li>
                                <li><a href="careers.php">Kariyer</a></li>
                                <li><a href="contact.php">İletişim</a></li>
                                <li><a href="privacy.php">Gizlilik Politikası</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p class="text-muted">&copy; <?php echo date('Y'); ?> OpenSky iPaaS. Tüm hakları saklıdır.</p>
                </div>
            </div>
        </footer>
    </div>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="assets/js/map.js"></script>
    <style>
    .footer {
        background-color: var(--bg-dark);
        color: white;
        padding: 4rem 0 2rem;
        margin-top: 4rem;
    }

    .footer-content {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 4rem;
        margin-bottom: 3rem;
    }

    .footer-brand {
        max-width: 300px;
    }

    .footer-brand p {
        margin: 1rem 0;
    }

    .social-links {
        display: flex;
        gap: 1rem;
    }

    .social-link {
        color: white;
        font-size: 1.25rem;
        transition: all 0.3s ease;
    }

    .social-link:hover {
        color: var(--primary-light);
        transform: translateY(-2px);
    }

    .footer-links {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .footer-column h5 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        color: white;
    }

    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-column ul li {
        margin-bottom: 0.75rem;
    }

    .footer-column ul li a {
        color: var(--text-light);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .footer-column ul li a:hover {
        color: var(--primary-light);
        padding-left: 0.5rem;
    }

    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 2rem;
        text-align: center;
    }

    @media (max-width: 991.98px) {
        .footer-content {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .footer-brand {
            max-width: 100%;
            text-align: center;
        }
        
        .social-links {
            justify-content: center;
        }
        
        .footer-links {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767.98px) {
        .footer-links {
            grid-template-columns: 1fr;
        }
        
        .footer-column {
            text-align: center;
        }
        
        .footer-column ul li a:hover {
            padding-left: 0;
        }
    }
    </style>
</body>
</html>
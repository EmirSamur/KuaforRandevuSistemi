<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUKLE BAYAN KUAFÖRÜ - Elit Saç Sanatı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-bg: #0F0F0F; /* Çok koyu gri, neredeyse siyah */
            --color-surface: #181818; /* Kartlar, ikincil yüzeyler */
            --color-primary-text: #EAEAEA; /* Ana metin rengi */
            --color-secondary-text: #A0A0A0; /* İkincil, daha soluk metin */
            --color-accent: #B08D57; /* Sofistike altın/bronz */
            --color-accent-hover: #c8a67a;
            --color-border: #2A2A2A; /* İnce sınırlar için */

            --font-primary: 'Montserrat', sans-serif;
            --font-display: 'Playfair Display', serif; /* Başlıklar için şık bir serif */

            --transition-fast: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --transition-medium: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        /* --- TEMEL AYARLAR & RESET --- */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            font-size: 16px; /* Responsive typografi için temel */
        }

        body {
            font-family: var(--font-primary);
            background-color: var(--color-bg);
            color: var(--color-primary-text);
            line-height: 1.7;
            font-weight: 300; /* Daha ince bir genel görünüm */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display); /* Başlıklar için serif font */
            color: var(--color-primary-text);
            font-weight: 700; /* Başlıklar belirgin olsun */
            line-height: 1.3;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 1.5rem;
            color: var(--color-secondary-text);
            font-weight: 300;
            font-size: 1rem;
        }
        p.lead { /* Bootstrap lead sınıfını özelleştirme */
            font-size: 1.25rem;
            font-weight: 300;
            color: var(--color-primary-text);
            opacity: 0.9;
        }

        a {
            color: var(--color-accent);
            text-decoration: none;
            transition: var(--transition-fast);
        }
        a:hover {
            color: var(--color-accent-hover);
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* --- Navbar --- */
        .navbar {
            background-color: rgba(15, 15, 15, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--color-border);
            transition: var(--transition-fast);
        }
        .navbar-brand {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--color-primary-text);
            font-size: 1.75rem;
            letter-spacing: 1px;
        }
        .navbar-brand .fa-cut {
            color: var(--color-accent);
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }
        .navbar-nav .nav-link {
            color: var(--color-secondary-text);
            font-weight: 400; /* Biraz daha belirgin */
            font-size: 0.95rem;
            margin-left: 1.8rem;
            padding: 0.5rem 0;
            position: relative;
            letter-spacing: 0.5px;
            text-transform: uppercase; /* Menü linkleri büyük harf */
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--color-primary-text);
        }
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background-color: var(--color-accent);
            transition: width 0.4s ease;
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }
        .navbar-toggler {
            border: 1px solid var(--color-accent);
            padding: 0.35rem 0.6rem;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(176, 141, 87, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* --- Hero Section --- */
        .hero-section {
            min-height: 90vh; /* Ekran yüksekliğinin büyük kısmını kaplasın */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(15, 15, 15, 0.7), rgba(15, 15, 15, 0.9)),
                        url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80') no-repeat center center/cover;
            background-attachment: fixed; /* Parallax etkisi için */
            padding: 6rem 1rem; /* Kenar boşlukları */
            position: relative;
        }
        .hero-section .container {
            max-width: 900px; /* İçerik genişliği */
            position: relative;
            z-index: 2;
        }
        .hero-section h1 {
            font-size: clamp(2.8rem, 6vw, 4.5rem); /* Responsive başlık boyutu */
            font-weight: 700;
            color: var(--color-primary-text);
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            text-shadow: 0 0 30px rgba(0,0,0,0.5);
        }
        .hero-section .lead { /* Bootstrap lead sınıfını burada kullanıyoruz */
            font-family: var(--font-primary);
            font-size: clamp(1.1rem, 2.5vw, 1.35rem);
            font-weight: 300;
            color: var(--color-primary-text);
            opacity: 0.85;
            max-width: 700px;
            margin: 0 auto 3rem auto;
        }

        /* --- Genel Buton Stilleri --- */
        .btn { /* Bootstrap .btn sınıfını temel alarak özelleştirme */
            font-family: var(--font-primary);
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 0.9rem 2.2rem;
            border-radius: 50px; /* Tamamen yuvarlak */
            transition: var(--transition-fast);
            border-width: 2px; /* Sınır kalınlığı */
            font-size: 0.9rem;
            box-shadow: none; /* Bootstrap gölgesini kaldır */
        }
        .btn-vip-primary {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: var(--color-bg); /* Koyu arka plan üzerinde açık renk */
        }
        .btn-vip-primary:hover {
            background-color: var(--color-accent-hover);
            border-color: var(--color-accent-hover);
            color: var(--color-bg);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(176, 141, 87, 0.2);
        }
        .btn-vip-outline {
            background-color: transparent;
            border-color: var(--color-accent);
            color: var(--color-accent);
        }
        .btn-vip-outline:hover {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: var(--color-bg);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(176, 141, 87, 0.2);
        }
        .btn-vip-outline .fab { color: var(--color-accent); transition: var(--transition-fast); }
        .btn-vip-outline:hover .fab { color: var(--color-bg); }


        /* --- Section Genel Ayarları --- */
        .section { /* Tüm bölümlere uygulanacak genel bir class */
            padding: 6rem 0;
            overflow: hidden; /* Animasyonlar için */
        }
        .section-title {
            font-size: clamp(2rem, 5vw, 3rem);
            text-align: center;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }
        .section-subtitle { /* Bölüm başlığı altına opsiyonel alt başlık */
            text-align: center;
            font-size: 1.1rem;
            color: var(--color-secondary-text);
            max-width: 600px;
            margin: 0 auto 4rem auto;
            font-family: var(--font-primary);
            font-weight: 300;
        }
        .section-title::after, .section-subtitle::after { /* Alt çizgi efekti için opsiyonel */
            content: '';
            display: block;
            width: 60px;
            height: 2px;
            background-color: var(--color-accent);
            margin: 1.5rem auto 0;
        }


        /* --- Feature Cards --- */
        .feature-card-section { background-color: var(--color-bg); } /* Ana arka plan */
        .feature-card {
            background-color: var(--color-surface);
            padding: 2.5rem;
            border-radius: 8px;
            text-align: center;
            height: 100%;
            border: 1px solid var(--color-border);
            transition: var(--transition-medium);
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* İçeriği yukarıdan başlat */
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            border-color: var(--color-accent);
        }
        .feature-icon {
            font-size: 2.8rem;
            color: var(--color-accent);
            margin-bottom: 1.8rem;
            line-height: 1; /* İkonların dikey hizalaması için */
        }
        .feature-card h3 {
            font-family: var(--font-primary); /* Daha modern bir görünüm için primary font */
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--color-primary-text);
        }
        .feature-card p {
            font-size: 0.9rem;
            line-height: 1.6;
            color: var(--color-secondary-text);
            margin-bottom: 0; /* Kartın sonunda boşluk olmasın */
        }

        /* --- Services Section --- */
        #services { background-color: var(--color-surface); } /* Farklı bir yüzey rengi */
        .service-item {
            background-color: var(--color-bg); /* İç kartlar için ana arka plan */
            border-radius: 8px;
            overflow: hidden; /* Resim taşmasını engelle */
            height: 100%;
            display: flex;
            flex-direction: column;
            border: 1px solid var(--color-border);
            transition: var(--transition-medium);
        }
        .service-item:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            border-color: var(--color-accent);
        }
        .service-item img {
            width: 100%;
            height: 280px; /* Yükseklik ayarı */
            object-fit: cover;
            transition: transform 0.5s ease; /* Hover'da yumuşak zoom */
        }
        .service-item:hover img {
            transform: scale(1.1);
        }
        .service-item-content { /* Resim altına içerik alanı */
            padding: 1.8rem;
            text-align: center;
            flex-grow: 1; /* İçeriğin kalan alanı doldurmasını sağla */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .service-item h4 {
            font-family: var(--font-primary);
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--color-primary-text);
            margin-bottom: 0;
        }


        /* --- Testimonials Section --- */
        #testimonials { background-color: var(--color-bg); }
        .testimonial-card {
            background-color: var(--color-surface);
            padding: 2.5rem;
            border-radius: 8px;
            text-align: center;
            height: 100%;
            border: 1px solid var(--color-border);
            transition: var(--transition-medium);
            display: flex;
            flex-direction: column;
            justify-content: center; /* İçeriği ortala */
        }
        .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.2);
            border-color: var(--color-accent);
        }
        .testimonial-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 1.8rem auto;
            border: 4px solid var(--color-accent);
            box-shadow: 0 0 15px rgba(176, 141, 87, 0.25);
        }
        .testimonial-card h4 {
            font-family: var(--font-primary);
            font-size: 1.15rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--color-primary-text);
        }
        .testimonial-card .stars {
            color: var(--color-accent);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }
        .testimonial-card p { /* Müşteri yorumu metni */
            font-family: var(--font-display); /* Yorum için şık font */
            font-style: italic;
            font-size: 1.05rem;
            line-height: 1.6;
            color: var(--color-secondary-text); /* Biraz daha soluk */
            margin-bottom: 0;
            opacity: 0.9;
        }
        .testimonial-card p::before { /* Alıntı işaretleri */
            content: "“";
            font-size: 2rem;
            color: var(--color-accent);
            display: block;
            margin-bottom: -0.5rem;
            opacity: 0.7;
        }
        .testimonial-card p::after {
            content: "”";
            font-size: 2rem;
            color: var(--color-accent);
            display: block;
            margin-top: -0.5rem;
            text-align: right;
            opacity: 0.7;
        }

        /* --- Footer --- */
        footer {
            background-color: var(--color-surface);
            color: var(--color-secondary-text);
            padding: 5rem 0 2rem;
            border-top: 1px solid var(--color-border);
        }
        footer h4 {
            font-family: var(--font-display);
            font-size: 1.4rem;
            color: var(--color-primary-text);
            margin-bottom: 2rem;
            position: relative;
        }
        footer h4::after { /* Başlık altı çizgi */
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--color-accent);
        }
        footer p, footer li {
            font-size: 0.9rem;
            margin-bottom: 0.8rem;
        }
        footer a {
            color: var(--color-secondary-text);
        }
        footer a:hover {
            color: var(--color-accent);
        }
        footer .list-unstyled li a { padding: 0.2rem 0; display: inline-block; }
        footer .social-icons a {
            display: inline-block;
            margin-right: 1rem;
            font-size: 1.3rem; /* İkon boyutu */
            color: var(--color-secondary-text);
        }
        footer .social-icons a:hover {
            color: var(--color-accent);
            transform: scale(1.1);
        }
        footer hr {
            border-top: 1px solid var(--color-border);
            opacity: 0.5;
            margin: 3rem 0;
        }
        footer .small {
            font-size: 0.85rem;
        }

        /* --- Responsive Ayarlamalar --- */
        @media (max-width: 991px) { /* Tablet ve altı */
            .navbar { padding: 1.2rem 0; }
            .navbar-nav .nav-link { margin-left: 0; padding: 0.8rem 1rem; text-align: center;}
            .navbar-nav .nav-link::after { left: 50%; transform: translateX(-50%); }

            .hero-section { min-height: 70vh; padding: 4rem 1rem; }

            .section { padding: 4rem 0; }
            .section-title { margin-bottom: 1rem; }
            .section-subtitle { margin-bottom: 3rem; }

            .feature-card, .service-item, .testimonial-card { margin-bottom: 2rem; }
            .service-item img { height: 240px; }

            footer { padding: 4rem 0 1.5rem; }
            footer h4 { margin-bottom: 1.5rem; }
            footer .col-lg-4 { margin-bottom: 2.5rem; }
        }

        @media (max-width: 767px) { /* Mobil */
            html { font-size: 15px; }
            .hero-section { text-align: center; }
            .hero-section .btn { display: block; margin-bottom: 1rem; width: 100%; max-width: 300px; margin-left:auto; margin-right:auto; }
            .hero-section .btn:last-child { margin-bottom: 0; }

            /* Hizmetler bölümünde mobil için 2'li grid */
            #services .col-md-3.col-6 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            .service-item img { height: 200px; }

            footer .text-center { text-align: left !important; } /* Mobilde sola yasla */
            footer h4::after { left: 0; }
            footer .social-icons { text-align: left; }
        }

        @media (max-width: 575px) { /* Çok küçük mobil ekranlar */
            #services .col-md-3.col-6 { /* Hizmetleri tekli sütuna düşür */
                flex: 0 0 100%;
                max-width: 100%;
            }
            .service-item img { height: 220px; }
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cut"></i>BUKLE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="randevu_ekle.php">Randevu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="giris.php">Randevularım</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Hizmetler</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">İletişim</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <!-- HTML'deki başlık ve paragrafı kullanıyoruz -->
            <h1>VIP Saç Sanatı Deneyimi</h1>
            <p class="lead">Kişiye özel hizmet anlayışı ve uzman dokunuşlarla stilinizi yeniden keşfedin.</p>
            <a href="randevu_ekle.php" class="btn btn-vip-primary btn-lg me-md-2 mb-3 mb-md-0">Online Randevu Alın</a>
            <a href="https://wa.me/+905434647965?text=Merhaba,%20randevu%20almak%20istiyorum." class="btn btn-vip-outline btn-lg" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
        </div>
    </section>

    <!-- section class'ını ekliyoruz -->
    <section class="feature-card-section section">
        <div class="container">
            <!-- Opsiyonel: Bölüm için alt başlık -->
            <h2 class="section-title">Neden BUKLE?</h2>
            <p class="section-subtitle">
                Size sıradan bir kuaför deneyiminden çok daha fazlasını sunuyoruz. Zarafet, uzmanlık ve kişiye özel ilgiyle tanışın.
            </p>
            <div class="row g-4 g-lg-5 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="far fa-calendar-check"></i> <!-- İkonu değiştirdim -->
                        </div>
                        <h3>Zahmetsiz Planlama</h3>
                        <p>Kullanıcı dostu online sistemimizle size en uygun zamanı kolayca seçin, randevunuzu anında oluşturun.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                             <i class="fas fa-crown"></i> <!-- İkonu değiştirdim -->
                        </div>
                        <h3>Usta Sanatkarlar</h3>
                        <p>Sektördeki en son trendleri takip eden, ödüllü ve deneyimli stilistlerimizle farkı yaşayın.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6"> <!-- col-md-12'yi 6 yaptım daha simetrik olması için-->
                     <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-gem"></i> <!-- İkonu değiştirdim -->
                        </div>
                        <h3>Premium Ürünler</h3>
                        <p>Saç ve cilt sağlığınız bizim için öncelikli. Sadece en seçkin ve kaliteli markaların ürünlerini kullanıyoruz.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="section"> <!-- section class'ını ekliyoruz -->
        <div class="container">
            <h2 class="section-title">İmza Hizmetlerimiz</h2>
            <p class="section-subtitle">
                Her biri sanatsal bir dokunuşla sunulan, size özel olarak tasarlanmış premium hizmetlerimizi keşfedin.
            </p>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
                             alt="Özel Saç Kesimi">
                        <div class="service-item-content">
                            <h4>Artistlik Kesimler</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                     <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=688&q=80"
                             alt="Profesyonel Renklendirme">
                        <div class="service-item-content">
                            <h4>Usta Renklendirme</h4>
                        </div>
                     </div>
                </div>
                <div class="col-md-3 col-6">
                     <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1621607512214-68297480165e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                             alt="Lüks Cilt Bakımı">
                        <div class="service-item-content">
                            <h4>Yenileyici Bakımlar</h4>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                     <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1596704017255-ee7b0a1e0cd1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
                             alt="Kalıcı Makyaj">
                        <div class="service-item-content">
                            <h4>Kalıcı Güzellik</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="section"> <!-- section class'ını ekliyoruz -->
        <div class="container">
            <h2 class="section-title">Müşteri Deneyimleri</h2>
            <p class="section-subtitle">
                Değerli misafirlerimizin BUKLE hakkındaki içten yorumları ve yaşadıkları eşsiz deneyimler.
            </p>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/43.jpg" class="testimonial-img" alt="Müşteri Ayşe K.">
                        <h4>Ayşe K.</h4>
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Beklentilerimin ötesinde bir ilgi ve profesyonellik. Bukle, saçlarıma yeniden hayat verdi. Teşekkürler!"</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/32.jpg" class="testimonial-img" alt="Müşteri Elif T."> <!-- Görseli değiştirdim -->
                        <h4>Elif T.</h4>
                         <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i> <!-- Yarım yıldız örneği -->
                        </div>
                        <p>"Salonun atmosferi ve çalışanların samimiyeti harika. Saç kesimim tam istediğim gibi oldu, kesinlikle tavsiye ederim."</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12"> <!-- Bu sütun md'de tam genişlikte kalabilir veya 6 yapılabilir -->
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" class="testimonial-img" alt="Müşteri Zeynep A.">
                        <h4>Zeynep A.</h4>
                        <div class="stars">
                             <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Kullanılan ürünlerin kalitesi ve uzman dokunuşlar sayesinde saçlarım hiç bu kadar sağlıklı görünmemişti. Bukle bir numara!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact"> <!-- section class'ı burada gerekmeyebilir, footer kendi başına bir bölüm -->
        <div class="container">
            <div class="row gy-5"> <!-- gy-4'ü gy-5 yaptım, dikey boşluk artışı -->
                <div class="col-lg-4 col-md-6">
                    <h4>BUKLE</h4>
                    <p class="pe-lg-3">Stilinizi lüks ve konforla buluşturan, size özel bir deneyim sunan elit saç sanatı merkezi.</p>
                    <div class="mt-4 social-icons">
                        <a href="#" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/+905434647965?text=Merhaba" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6"> <!-- col-lg-4'ü 3 yaptım, daha dar bir sütun -->
                    <h4>Hızlı Erişim</h4>
                     <ul class="list-unstyled">
                        <li><a href="index.php">Ana Sayfa</a></li>
                        <li><a href="randevu_ekle.php">Randevu Oluştur</a></li>
                        <li><a href="#services">Hizmetlerimiz</a></li>
                        <li><a href="#testimonials">Yorumlar</a></li>
                        <li><a href="#contact">Bize Ulaşın</a></li>
                     </ul>
                </div>
                 <div class="col-lg-5 col-md-12"> <!-- col-lg-4'ü 5 yaptım, daha geniş bir sütun -->
                    <h4>İletişim & Konum</h4>
                    <p><i class="fas fa-map-marker-alt me-2 opacity-75"></i> Elit Cadde, No:25, Lüks Plaza, Beşiktaş/İstanbul</p>
                    <p><i class="fas fa-phone me-2 opacity-75"></i> (0432) 210 13 50</p>
                    <p><i class="fas fa-envelope me-2 opacity-75"></i> buklebayan@gmail.com</p>
                    <p><i class="far fa-clock me-2 opacity-75"></i> H.içi: 09:00 - 20:00 | Cmt: 10:00 - 19:00</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0 small">© <script>document.write(new Date().getFullYear())</script> BUKLE BAYAN KUAFÖRÜ. Tüm Hakları Saklıdır. | <a href="#" target="_blank" rel="noopener noreferrer" class="text-white">Tasarım: CWTCH</a></p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Elysian Locks - Lüks saç tasarımı, profesyonel bakım ve kişiye özel stil danışmanlığı. Hayalinizdeki görünüme kavuşun.">
    <meta name="keywords" content="kadın kuaförü, saç kesimi, saç boyama, fön, gelin saçı, manikür, pedikür, cilt bakımı, makyaj, beşiktaş kuaför, lüks kuaför">
    <title>BUKLE BAYAN KUAFÖRÜ</title>

    <!-- Favicon (Örnek - Kendi favicon'unuzu ekleyin) -->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS (Animate On Scroll) CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --color-bg: #0a0a0a; /* Neredeyse Siyah */
            --color-surface: #141414; /* Kartlar, ikincil yüzeyler için biraz daha açık */
            --color-primary-text: #f0f0f0; /* Ana metin rengi - çok açık gri */
            --color-secondary-text: #b0b0b0; /* İkincil, daha soluk metin */
            --color-accent: #d4af37; /* Klasik altın rengi */
            --color-accent-hover: #e7c668; /* Altın hover */
            --color-border: #282828; /* İnce sınırlar için */

            --font-primary: 'Montserrat', sans-serif;
            --font-display: 'Playfair Display', serif;

            --transition-fast: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --transition-medium: all 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);

            --shadow-light: 0 5px 15px rgba(0,0,0,0.1);
            --shadow-medium: 0 8px 25px rgba(0,0,0,0.15);
        }

        /* --- TEMEL AYARLAR & RESET --- */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; font-size: 16px; }
        body {
            font-family: var(--font-primary);
            background-color: var(--color-bg);
            color: var(--color-primary-text);
            line-height: 1.7;
            font-weight: 300;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-display);
            color: var(--color-primary-text);
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 1.25rem;
        }
        h1 { font-size: clamp(2.5rem, 5vw, 4rem); }
        h2 { font-size: clamp(2rem, 4vw, 3rem); }
        h3 { font-size: clamp(1.5rem, 3vw, 2.2rem); }

        p { margin-bottom: 1.5rem; color: var(--color-secondary-text); font-weight: 300; font-size: 1rem; }
        p.lead { font-size: 1.2rem; font-weight: 300; color: var(--color-primary-text); opacity: 0.9; }
        a { color: var(--color-accent); text-decoration: none; transition: var(--transition-fast); }
        a:hover { color: var(--color-accent-hover); text-decoration: none; }
        img { max-width: 100%; height: auto; display: block; }

        /* --- Utility --- */
        .section-padding { padding: 6rem 0; }
        .section-title { text-align: center; margin-bottom: 1rem; }
        .section-subtitle {
            text-align: center;
            font-size: 1.1rem;
            color: var(--color-secondary-text);
            max-width: 700px;
            margin: 0 auto 4rem auto;
            font-family: var(--font-primary);
            font-weight: 300;
        }
        .section-title::after {
            content: ''; display: block; width: 70px; height: 3px;
            background-color: var(--color-accent); margin: 1rem auto 0;
        }
        .text-accent { color: var(--color-accent) !important; }

        /* --- Butonlar --- */
        .btn {
            font-family: var(--font-primary);
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            transition: var(--transition-fast);
            border-width: 2px;
            font-size: 0.9rem;
            box-shadow: none !important;
            display: inline-flex; /* İkon ve metni hizalamak için */
            align-items: center;
            justify-content: center;
        }
        .btn i { margin-right: 0.5rem; }
        .btn-lg { padding: 1rem 2.5rem; font-size: 1rem; }

        .btn-accent {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: var(--color-bg) !important;
        }
        .btn-accent:hover {
            background-color: var(--color-accent-hover);
            border-color: var(--color-accent-hover);
            color: var(--color-bg) !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.2) !important;
        }
        .btn-outline-accent {
            background-color: transparent;
            border-color: var(--color-accent);
            color: var(--color-accent) !important;
        }
        .btn-outline-accent:hover {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: var(--color-bg) !important;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.15) !important;
        }

        /* --- Navbar --- */
        .navbar {
            background-color: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 1.2rem 0;
            border-bottom: 1px solid var(--color-border);
            transition: padding 0.3s ease-in-out;
        }
        .navbar-scrolled { padding: 0.8rem 0; background-color: rgba(10, 10, 10, 0.95); }
        .navbar-brand {
            font-family: var(--font-display);
            font-weight: 700;
            color: var(--color-primary-text) !important;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }
        .navbar-brand i { color: var(--color-accent); margin-right: 0.5rem; font-size: 1.6rem; }
        .navbar-nav .nav-link {
            color: var(--color-secondary-text);
            font-weight: 500; /* Biraz daha kalın */
            font-size: 0.9rem;
            margin: 0 0.8rem; /* Sağ ve sol boşluk */
            padding: 0.5rem 0;
            position: relative;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active { color: var(--color-primary-text) !important; }
        .navbar-nav .nav-link::after {
            content: ''; position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
            width: 0; height: 2px; background-color: var(--color-accent);
            transition: width 0.3s ease;
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after { width: 70%; }
        .navbar-toggler { border: 1px solid var(--color-accent); padding: 0.3rem 0.5rem; }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(212, 175, 55, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .navbar-nav .btn-nav { margin-left: 1rem; }


        /* --- Hero Section --- */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(rgba(10, 10, 10, 0.75), rgba(10, 10, 10, 0.85)),
                        url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=85') no-repeat center center/cover;
            background-attachment: fixed;
            padding: 8rem 1rem 4rem; /* Navbar yüksekliğini de hesaba katın */
            position: relative;
        }
        .hero-section .container { max-width: 900px; position: relative; z-index: 2; }
        .hero-section h1 { text-shadow: 0 2px 15px rgba(0,0,0,0.5); margin-bottom: 1.5rem; }
        .hero-section .lead { max-width: 700px; margin: 0 auto 2.5rem auto; opacity: 0.9; }

        /* --- About Section --- */
        #about .about-img {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow-medium);
        }
        #about .about-img img { transition: transform 0.5s ease; }
        #about .about-img:hover img { transform: scale(1.05); }
        #about .icon-box { display: flex; align-items: flex-start; margin-bottom: 2rem; }
        #about .icon-box i {
            font-size: 2rem; color: var(--color-accent); margin-right: 1rem;
            width: 50px; text-align: center;
        }
        #about .icon-box h4 { margin-bottom: 0.5rem; font-size: 1.2rem; font-family: var(--font-primary); font-weight: 600;}
        #about .icon-box p { font-size: 0.9rem; margin-bottom: 0; }

        /* --- Services Section --- */
        #services { background-color: var(--color-surface); }
        .service-card {
            background-color: var(--color-bg);
            padding: 2.5rem;
            border-radius: 10px;
            text-align: center;
            height: 100%;
            border: 1px solid var(--color-border);
            transition: var(--transition-medium);
            box-shadow: var(--shadow-light);
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-medium);
            border-color: var(--color-accent);
        }
        .service-card .service-icon {
            font-size: 3rem; color: var(--color-accent); margin-bottom: 1.5rem;
            line-height: 1;
        }
        .service-card h3 {
            font-family: var(--font-primary); font-size: 1.3rem; font-weight: 600;
            margin-bottom: 1rem; color: var(--color-primary-text);
        }
        .service-card p { font-size: 0.9rem; line-height: 1.6; color: var(--color-secondary-text); margin-bottom: 1.5rem; }
        .service-card .price {
            font-family: var(--font-display); font-size: 1.5rem; color: var(--color-accent);
            font-weight: 700; display: block; margin-top: auto; /* Fiyatı en alta iter */
        }

        /* --- Team Section --- */
        .team-member {
            background-color: var(--color-surface);
            border-radius: 10px;
            overflow: hidden;
            border: 1px solid var(--color-border);
            transition: var(--transition-medium);
            box-shadow: var(--shadow-light);
            text-align: center;
        }
        .team-member:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-medium);
            border-color: var(--color-accent);
        }
        .team-member img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            object-position: top center; /* Yüzler genellikle üstte olur */
            transition: transform 0.4s ease;
        }
        .team-member:hover img { transform: scale(1.05); }
        .team-member-content { padding: 1.8rem; }
        .team-member h4 { font-family: var(--font-primary); font-size: 1.3rem; font-weight: 600; margin-bottom: 0.3rem; }
        .team-member p.role { color: var(--color-accent); font-weight: 500; margin-bottom: 1rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .team-social a {
            color: var(--color-secondary-text); font-size: 1.2rem; margin: 0 0.5rem;
            transition: var(--transition-fast);
        }
        .team-social a:hover { color: var(--color-accent); transform: translateY(-2px); }

        /* --- Gallery Section --- */
        #gallery { background-color: var(--color-surface); }
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            aspect-ratio: 1 / 1; /* Kare görseller */
        }
        .gallery-item img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s ease, filter 0.5s ease;
        }
        .gallery-item:hover img { transform: scale(1.1); filter: brightness(0.7); }
        .gallery-item .overlay {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: linear-gradient(rgba(10,10,10,0.1), rgba(10,10,10,0.6));
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transition: opacity 0.4s ease;
        }
        .gallery-item:hover .overlay { opacity: 1; }
        .gallery-item .overlay i { font-size: 2.5rem; color: var(--color-primary-text); }

        /* --- Testimonials Section --- */
        .testimonial-card {
            background-color: var(--color-surface);
            padding: 2.5rem; border-radius: 10px;
            border: 1px solid var(--color-border);
            box-shadow: var(--shadow-light);
            height: 100%;
            display: flex; flex-direction: column;
        }
        .testimonial-img {
            width: 80px; height: 80px; border-radius: 50%; object-fit: cover;
            margin: 0 auto 1.5rem auto; border: 3px solid var(--color-accent);
            box-shadow: 0 0 15px rgba(212,175,55,0.2);
        }
        .testimonial-card h4 { font-family: var(--font-primary); font-size: 1.1rem; font-weight: 600; margin-bottom: 0.2rem; }
        .testimonial-card .stars { color: var(--color-accent); margin-bottom: 1rem; font-size: 0.9rem; }
        .testimonial-card p.quote {
            font-family: var(--font-display); font-style: italic; font-size: 1.05rem;
            line-height: 1.6; color: var(--color-secondary-text); margin-bottom: 0;
            flex-grow: 1; /* İçeriği esnetir */
        }
        .testimonial-card p.quote::before { content: "“"; font-size: 2.5rem; color: var(--color-accent); display: block; margin-bottom: -0.8rem; opacity: 0.7; line-height: 1; }
        .testimonial-card p.quote::after { content: "”"; font-size: 2.5rem; color: var(--color-accent); display: block; margin-top: -0.8rem; text-align: right; opacity: 0.7; line-height: 1; }

        /* --- Booking CTA Section --- */
        #booking-cta {
            background: linear-gradient(rgba(10, 10, 10, 0.8), rgba(10, 10, 10, 0.9)),
                        url('https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1920&q=85') no-repeat center center/cover;
            background-attachment: fixed;
            text-align: center;
        }
        #booking-cta h2 { color: var(--color-primary-text); }
        #booking-cta p { color: var(--color-primary-text); opacity: 0.85; max-width: 600px; margin-left: auto; margin-right: auto;}

        /* --- Footer --- */
        footer {
            background-color: var(--color-surface);
            color: var(--color-secondary-text);
            padding: 5rem 0 1.5rem;
            border-top: 1px solid var(--color-border);
        }
        footer h4 { font-size: 1.3rem; color: var(--color-primary-text); margin-bottom: 1.5rem; position: relative; }
        footer h4::after {
            content: ''; position: absolute; bottom: -8px; left: 0;
            width: 35px; height: 2px; background-color: var(--color-accent);
        }
        footer p, footer li { font-size: 0.9rem; margin-bottom: 0.7rem; }
        footer a { color: var(--color-secondary-text); }
        footer a:hover { color: var(--color-accent); }
        footer .list-unstyled li a { padding: 0.1rem 0; display: inline-block; }
        footer .social-icons a {
            display: inline-flex; align-items: center; justify-content: center;
            width: 40px; height: 40px; border-radius: 50%;
            margin-right: 0.7rem; font-size: 1.1rem;
            color: var(--color-secondary-text);
            background-color: rgba(255,255,255,0.05);
            transition: var(--transition-fast);
        }
        footer .social-icons a:hover {
            color: var(--color-bg); background-color: var(--color-accent);
            transform: translateY(-2px);
        }
        footer hr { border-top: 1px solid var(--color-border); opacity: 0.5; margin: 2.5rem 0; }
        footer .copyright { font-size: 0.85rem; text-align: center; }
        footer .copyright a { color: var(--color-accent); opacity: 0.8; }
        footer .copyright a:hover { opacity: 1; }


        /* --- Responsive Ayarlamalar --- */
        @media (max-width: 991px) { /* Tablet ve altı */
            .navbar-nav .nav-link { margin: 0.5rem 0; text-align: center; }
            .navbar-nav .nav-link::after { left: 50%; transform: translateX(-50%); }
            .navbar-nav .btn-nav { margin-left: 0; margin-top: 0.8rem; display: block; text-align: center; }
            .hero-section { min-height: 80vh; padding-top: 6rem; }
            .section-padding { padding: 4rem 0; }
            .section-subtitle { margin-bottom: 3rem; }
            .service-card, .team-member, .testimonial-card { margin-bottom: 2rem; }
            .team-member img { height: 300px; }
            #about .about-img { margin-bottom: 2rem; }
            footer h4::after { left: 50%; transform: translateX(-50%); } /* Mobilde başlık çizgisi ortalansın */
            footer .text-md-start { text-align: center !important; }
        }

        @media (max-width: 767px) { /* Mobil */
            html { font-size: 15px; }
            .hero-section .btn-lg { display: block; margin-bottom: 1rem; width: 100%; max-width: 320px; margin-left:auto; margin-right:auto; }
            .hero-section .btn-lg:last-child { margin-bottom: 0; }
            .team-member img { height: 320px; } /* Daha büyük resimler için */
            .gallery-item { aspect-ratio: 4 / 3; } /* Mobil için farklı aspect ratio */
        }
         @media (max-width: 575px) {
            .gallery-grid .col-6 { /* Galeride mobilde 2 sütun */
                flex: 0 0 50%;
                max-width: 50%;
            }
         }

    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="fas fa-gem"></i> BUKLE BAYAN KUAFÖRÜ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#hero">Ana Sayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Hakkımızda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Hizmetler</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#team">Ekibimiz</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Yorumlar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">İletişim</a>
                    </li>
                    <li class="nav-item btn-nav">
                        <a href="#booking-cta" class="btn btn-accent btn-sm">Randevu Al</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="container" data-aos="fade-up">
            <h1 class="display-3">BUKLE BAYAN KUAFÖRÜ</h1>
            <p class="lead mb-4">Stilinizi zarafetle buluşturan, size özel bir deneyim. Hayalinizdeki görünüme kavuşmak için doğru adrestesiniz.</p>
            <a href="#services" class="btn btn-accent btn-lg me-md-2 mb-3 mb-md-0">Hizmetlerimizi Keşfedin</a>
            <a href="#booking-cta" class="btn btn-outline-accent btn-lg">Online Randevu</a>
        </div>
    </section>

    <main>
        <!-- About Section -->
        <section id="about" class="section-padding">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                        <div class="about-img">
                            <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Salon İç Mekanı" class="img-fluid rounded">
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left">
                        <h2 class="section-title text-start ps-0">Biz Kimiz? <span class="text-accent">Sanat ve Tutku</span></h2>
                        <p class="lead mb-3">Elysian Locks olarak, her müşterimizin benzersiz güzelliğini ortaya çıkarmayı misyon edindik. Deneyimli ekibimiz ve kaliteli ürünlerimizle, size sadece bir saç kesimi değil, unutulmaz bir deneyim sunuyoruz.</p>
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
                            <i class="fas fa-cut"></i>
                            <div>
                                <h4>Uzman Stilistler</h4>
                                <p>Sektördeki en son trendleri takip eden, yaratıcı ve deneyimli stilist kadromuz.</p>
                            </div>
                        </div>
                        <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
                           <i class="fas fa-spa"></i>
                            <div>
                                <h4>Premium Ürünler</h4>
                                <p>Saç ve cilt sağlığınızı önemsiyor, sadece en kaliteli ve seçkin markaların ürünlerini kullanıyoruz.</p>
                            </div>
                        </div>
                         <div class="icon-box" data-aos="fade-up" data-aos-delay="300">
                            <i class="far fa-gem"></i>
                            <div>
                                <h4>Kişiye Özel İlgi</h4>
                                <p>Her müşterimizin beklenti ve ihtiyaçlarına özel, kişiselleştirilmiş hizmet anlayışı.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="section-padding">
            <div class="container">
                <h2 class="section-title">İmza Hizmetlerimiz</h2>
                <p class="section-subtitle">Güzelliğinize değer katacak, size özel olarak tasarlanmış premium hizmetlerimizi keşfedin.</p>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas fa-magic"></i></div>
                            <h3>Artistlik Saç Kesimi</h3>
                            <p>Yüz şeklinize ve tarzınıza en uygun, modern ve imza kesimler. Uzmanlarımızla stilinizi yeniden tanımlayın.</p>
                            <span class="price">Başlangıç Fiyatı: ₺350</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas fa-palette"></i></div>
                            <h3>Profesyonel Renklendirme</h3>
                            <p>Ombre, sombre, balyaj ve en trend renklerle saçlarınıza canlılık katın. Kaliteli boyalarla kalıcı sonuçlar.</p>
                            <span class="price">Başlangıç Fiyatı: ₺700</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas fa-leaf"></i></div>
                            <h3>Saç Bakımı & Terapileri</h3>
                            <p>Yıpranmış saçlarınıza özel keratin bakımı, nem terapileri ve canlandırıcı kürlerle sağlıkla parlayan saçlar.</p>
                            <span class="price">Başlangıç Fiyatı: ₺400</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas fa-female"></i></div>
                            <h3>Gelin Saçı & Makyajı</h3>
                            <p>Hayatınızın en özel gününde, hayallerinizdeki gelin görünümüne profesyonel dokunuşlarla ulaşın.</p>
                             <span class="price">Paket Fiyatı Sorunuz</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas fa-hand-sparkles"></i></div>
                            <h3>Manikür & Pedikür</h3>
                            <p>El ve ayaklarınıza özel spa bakımları, kalıcı oje ve tırnak sanatıyla şıklığınızı tamamlayın.</p>
                            <span class="price">Başlangıç Fiyatı: ₺200</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                        <div class="service-card">
                            <div class="service-icon"><i class="fas fa-user-graduate"></i></div>
                            <h3>Kalıcı Makyaj</h3>
                            <p>Microblading, dudak renklendirme ve eyeliner uygulamalarıyla doğal ve kalıcı güzellik.</p>
                            <span class="price">Uygulamaya Göre Değişir</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section id="team" class="section-padding">
            <div class="container">
                <h2 class="section-title">Uzman Ekibimiz</h2>
                <p class="section-subtitle">Güzellik yolculuğunuzda size eşlik edecek, alanında tutkulu ve deneyimli sanatkarlarımız.</p>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in">
                        <div class="team-member">
                            <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=700&q=80" alt="Elif Arslan - Baş Stilist">
                            <div class="team-member-content">
                                <h4>Elif Arslan</h4>
                                <p class="role">Baş Stilist & Renk Uzmanı</p>
                                <div class="team-social">
                                    <a href="#" aria-label="Elif Arslan Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="#" aria-label="Elif Arslan Facebook"><i class="fab fa-facebook-f"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                        <div class="team-member">
                            <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=700&q=80" alt="Ayşe Güler - Makyaj Artisti">
                            <div class="team-member-content">
                                <h4>Ayşe Güler</h4>
                                <p class="role">Makyaj Artisti & Cilt Bakım Uzmanı</p>
                                <div class="team-social">
                                    <a href="#" aria-label="Ayşe Güler Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="#" aria-label="Ayşe Güler LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                        <div class="team-member">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=700&q=80" alt="Zeynep Yılmaz - Saç Terapisti">
                            <div class="team-member-content">
                                <h4>Zeynep Yılmaz</h4>
                                <p class="role">Saç Bakım Terapisti & Stilist</p>
                                <div class="team-social">
                                    <a href="#" aria-label="Zeynep Yılmaz Instagram"><i class="fab fa-instagram"></i></a>
                                    <a href="#" aria-label="Zeynep Yılmaz Twitter"><i class="fab fa-twitter"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="section-padding">
            <div class="container">
                <h2 class="section-title">İlham Veren Çalışmalarımız</h2>
                <p class="section-subtitle">Sanatımızın ve tutkumuzun yansıdığı, müşterilerimize özel tasarladığımız bazı görünümler.</p>
                <div class="row g-3 gallery-grid">
                    <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up">
                        <a href="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" data-bs-toggle="tooltip" title="Şık Bob Kesim">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 1">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="50">
                         <a href="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" data-bs-toggle="tooltip" title="Canlı Bakır Tonları">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1616394584738-fc6e612e71b9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 2">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="100">
                        <a href="https://images.unsplash.com/photo-1580890240482-5b3ef952993a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" data-bs-toggle="tooltip" title="Zarif Gelin Saçı">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1580890240482-5b3ef952993a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 3">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="150">
                        <a href="https://images.unsplash.com/photo-1599387759350-a78617095071?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" data-bs-toggle="tooltip" title="Modern Topuz Modeli">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1599387759350-a78617095071?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 4">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                     <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="200">
                        <a href="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" data-bs-toggle="tooltip" title="Profesyonel Makyaj">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 5">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="250">
                        <a href="https://images.unsplash.com/photo-1631071190499-514f61055098?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80" data-bs-toggle="tooltip" title="Sağlıklı Saç Bakımı">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1631071190499-514f61055098?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 6">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                     <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="300">
                        <a href="https://images.unsplash.com/photo-1597007909340-3341c69e878e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80" data-bs-toggle="tooltip" title="Doğal Ombre Geçişi">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1597007909340-3341c69e878e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 7">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-4 col-6" data-aos="zoom-in-up" data-aos-delay="350">
                        <a href="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=710&q=80" data-bs-toggle="tooltip" title="Özel Gün Makyajı">
                            <div class="gallery-item">
                                <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80" alt="Galeri Resmi 8">
                                <div class="overlay"><i class="fas fa-search-plus"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section id="testimonials" class="section-padding">
            <div class="container">
                <h2 class="section-title">Müşterilerimiz Ne Diyor?</h2>
                <p class="section-subtitle">Değerli misafirlerimizin Elysian Locks hakkındaki içten yorumları ve yaşadıkları eşsiz deneyimler.</p>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6" data-aos="fade-up">
                        <div class="testimonial-card">
                            <img src="https://randomuser.me/api/portraits/women/43.jpg" class="testimonial-img" alt="Müşteri Ayşe K.">
                            <h4>Ayşe K.</h4>
                            <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="quote">"Beklentilerimin çok ötesinde bir hizmet aldım. Saçlarıma resmen yeniden hayat verdiler. Ekip harika, salonun atmosferi muhteşem!"</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="testimonial-card">
                            <img src="https://randomuser.me/api/portraits/women/32.jpg" class="testimonial-img" alt="Müşteri Elif T.">
                            <h4>Elif T.</h4>
                             <div class="stars">
                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                            </div>
                            <p class="quote">"Gelin saçı ve makyajım için tercih ettim, sonuçtan inanılmaz memnun kaldım. Herkes çok ilgili ve profesyonel. Kesinlikle tavsiye ederim."</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="testimonial-card">
                            <img src="https://randomuser.me/api/portraits/women/65.jpg" class="testimonial-img" alt="Müşteri Zeynep A.">
                            <h4>Zeynep A.</h4>
                            <div class="stars">
                                 <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            </div>
                            <p class="quote">"Kullanılan ürünlerin kalitesi ve uzman dokunuşlar sayesinde saçlarım hiç bu kadar sağlıklı ve parlak görünmemişti. Elysian Locks bir numara!"</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Booking CTA Section -->
        <section id="booking-cta" class="section-padding">
            <div class="container" data-aos="zoom-in">
                <h2 class="mb-4">Hayalinizdeki Görünüme Bir Adım Daha Yaklaşın</h2>
                <p class="mb-5">Size özel bir deneyim için yerinizi ayırtın. Uzman ekibimizle tanışmak ve kendinizi şımartmak için hemen randevu alın.</p>
                <a href="tel:+902122345678" class="btn btn-accent btn-lg me-md-3 mb-3 mb-md-0"><i class="fas fa-phone-alt"></i> Hemen Arayın</a>
                <a href="https://wa.me/905xxxxxxxxx?text=Merhaba,%20randevu%20almak%20istiyorum." target="_blank" class="btn btn-outline-accent btn-lg"><i class="fab fa-whatsapp"></i> WhatsApp ile Randevu</a>
                <!-- Gerçek bir randevu sistemi için backend entegrasyonu veya 3. parti bir servis gerekir -->
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="row gy-4 text-center text-md-start">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <h4>Elysian Locks</h4>
                    <p class="pe-lg-3">Sanatın ve zarafetin buluştuğu, kişiye özel güzellik deneyimleri sunan elit saç tasarım stüdyosu. Kendinizi özel hissedin.</p>
                    <div class="mt-3 social-icons">
                        <a href="#" aria-label="Facebook" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter" target="_blank"><i class="fab fa-x-twitter"></i></a>
                        <a href="#" aria-label="Pinterest" target="_blank"><i class="fab fa-pinterest-p"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <h4>Hızlı Linkler</h4>
                     <ul class="list-unstyled">
                        <li><a href="#hero">Ana Sayfa</a></li>
                        <li><a href="#about">Hakkımızda</a></li>
                        <li><a href="#services">Hizmetler</a></li>
                        <li><a href="#team">Ekibimiz</a></li>
                        <li><a href="#gallery">Galeri</a></li>
                     </ul>
                </div>
                 <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h4>Çalışma Saatleri</h4>
                    <ul class="list-unstyled">
                        <li>Pazartesi - Cumartesi: 09:00 - 20:00</li>
                        <li>Pazar: Kapalı</li>
                        <li>(Özel randevular için lütfen iletişime geçin)</li>
                    </ul>
                </div>
                 <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <h4>Bize Ulaşın</h4>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-map-marker-alt me-2 text-accent"></i> Elit Cad. No:123, Lüks Plaza Kat:2, Beşiktaş/İstanbul</li>
                        <li><i class="fas fa-phone me-2 text-accent"></i> (0212) 234 56 78</li>
                        <li><i class="fas fa-envelope me-2 text-accent"></i> info@elysianlocks.com</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="copyright">
                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Elysian Locks. Tüm Hakları Saklıdır. | Tasarım: <a href="https://www.example.com" target="_blank" rel="noopener noreferrer">CWTCH Creative</a></p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <!-- AOS (Animate On Scroll) JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS Başlatma
        AOS.init({
            duration: 800, // Animasyon süresi
            once: true // Animasyonlar sadece bir kere çalışsın
        });

        // Navbar scroll efekti
        const navbar = document.getElementById('navbar');
        window.onscroll = function() {
            if (window.pageYOffset > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        };
        
        // Bootstrap Tooltip Başlatma (Galeri için)
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>
</html>
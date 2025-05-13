<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUKLE BAYAN KUAFÖRÜ - VIP Deneyimi</title> <!-- Daha açıklayıcı başlık -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --vip-darkest: #0a0a0a; /* Near black */
            --vip-dark: #1a1a1a;   /* Very dark grey */
            --vip-medium: #2c2c2c; /* Dark grey */
            --vip-light: #f8f9fa;  /* Off-white accent */
            --vip-grey: #adb5bd;   /* Lighter grey for secondary text */
            --vip-accent-subtle: #444; /* Subtle border/divider */
            --vip-gold-accent: #c5a47e; /* Muted Gold */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--vip-darkest);
            color: var(--vip-light);
            line-height: 1.7;
            font-weight: 400;
        }

        /* --- Navbar --- */
        .navbar {
            background-color: rgba(10, 10, 10, 0.85); /* Slightly transparent dark */
            backdrop-filter: blur(10px); /* Glassmorphism effect */
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(255, 255, 255, 0.05);
            padding: 1rem 0;
            transition: background-color 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--vip-light);
            font-size: 1.6rem;
            letter-spacing: 1px;
        }
        .navbar-brand .fa-cut { /* veya fa-scissors */
             color: var(--vip-gold-accent);
        }

        .navbar-nav .nav-link {
            color: var(--vip-grey);
            font-weight: 500;
            margin-left: 15px;
            transition: color 0.3s ease;
            position: relative; /* For potential underline effect */
            padding-bottom: 0.5rem; /* Space for underline */
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--vip-light);
        }

        /* Optional: Subtle underline for active/hovered nav links */
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--vip-gold-accent);
            transition: width 0.3s ease;
        }
        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }


        .navbar-toggler {
            border-color: rgba(248, 249, 250, 0.3);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28248, 249, 250, 0.7%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* --- Hero Section --- */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed; /* Creates parallax, test for performance */
            color: var(--vip-light);
            padding: 180px 0; /* Adjusted padding */
            text-align: center;
            margin-bottom: 80px;
        }

        .hero-section h1 {
            font-size: 3.5rem; /* Slightly adjusted */
            font-weight: 700;
            margin-bottom: 25px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.6);
            letter-spacing: 1px;
        }

        .hero-section p {
            font-size: 1.25rem; /* Slightly adjusted */
            font-weight: 300;
            margin-bottom: 50px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            opacity: 0.9;
        }

        /* --- Buttons --- */
        .btn-vip-primary {
            background-color: var(--vip-light);
            border: 2px solid var(--vip-light);
            color: var(--vip-darkest);
            padding: 14px 35px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(248, 249, 250, 0.1);
        }

        .btn-vip-primary:hover {
            background-color: transparent;
            color: var(--vip-light);
            box-shadow: 0 4px 15px rgba(248, 249, 250, 0.2);
            transform: translateY(-3px); /* Slightly more lift */
        }

        .btn-vip-outline {
            border: 2px solid var(--vip-light);
            color: var(--vip-light);
            background-color: transparent;
            padding: 14px 35px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .btn-vip-outline:hover {
            background-color: var(--vip-light);
            color: var(--vip-darkest);
            box-shadow: 0 4px 15px rgba(248, 249, 250, 0.2);
            transform: translateY(-3px); /* Slightly more lift */
        }


         /* --- Feature Cards --- */
        .feature-card-section { /* Added a wrapper class for potential background or spacing */
            padding: 60px 0; /* Spacing for this section */
        }
        .feature-card {
            background: var(--vip-dark);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            height: 100%;
            border: 1px solid var(--vip-accent-subtle);
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center; /* Ensures text is centered if not already */
        }

        .feature-card:hover {
            transform: translateY(-10px); /* More pronounced hover */
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.5);
            border-color: var(--vip-gold-accent); /* Gold border on hover */
        }

        .feature-icon {
            font-size: 3.2rem; /* Slightly larger icon */
            color: var(--vip-gold-accent); /* Gold for icons */
            margin-bottom: 25px;
        }
         .feature-card h3 {
             font-weight: 600;
             margin-bottom: 15px;
             color: var(--vip-light);
             font-size: 1.3rem;
         }
         .feature-card p {
             color: var(--vip-grey);
             font-size: 0.95rem;
         }

        /* --- Section Title --- */
        .section-title {
            position: relative;
            margin-bottom: 70px;
            color: var(--vip-light);
            text-align: center;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 2.2rem;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 80px; /* Slightly wider line */
            height: 3px;
            background: var(--vip-gold-accent); /* Gold accent for separator */
            margin: 25px auto 0;
        }

        /* --- Services Section --- */
        #services {
            padding: 80px 0;
            background-color: var(--vip-darkest);
        }

        .service-item {
            background-color: var(--vip-dark);
            padding: 25px; /* Increased padding */
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            border: 1px solid var(--vip-accent-subtle);
            height: 100%;
            display: flex;
            flex-direction: column;
            text-align: center;
        }

        .service-item:hover {
            transform: translateY(-8px); /* Consistent hover lift */
            box-shadow: 0 10px 30px rgba(0,0,0, 0.45);
            border-color: var(--vip-gold-accent); /* Gold border on hover */
        }

        .service-item img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2); /* Subtle shadow for images */
        }

        .service-item h4 {
            color: var(--vip-light);
            font-weight: 600;
            font-size: 1.15rem; /* Slightly larger */
            margin-top: auto; /* Pushes title to bottom if content above varies */
            padding-top: 10px; /* Space above title */
        }


        /* --- Testimonials Section --- */
        #testimonials {
            padding: 80px 0;
            background-color: var(--vip-dark);
        }
        .testimonial-card {
            background: var(--vip-medium);
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: var(--vip-grey);
            border: 1px solid var(--vip-accent-subtle);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
        }

        .testimonial-card:hover {
             transform: scale(1.03) translateY(-5px); /* Combined effect */
             box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }

        .testimonial-img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 25px;
            border: 4px solid var(--vip-gold-accent); /* Gold border for emphasis */
            box-shadow: 0 0 15px rgba(197, 164, 126, 0.3); /* Gold shadow */
        }

        .testimonial-card h4 {
            color: var(--vip-light);
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.2rem;
        }
        .testimonial-card .stars { /* Custom class for stars */
            color: var(--vip-gold-accent) !important;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        .testimonial-card p {
            font-style: italic;
            font-size: 0.95rem;
            line-height: 1.6;
        }


        /* --- Footer --- */
        footer {
            background-color: var(--vip-dark);
            color: var(--vip-grey);
            padding: 70px 0 30px;
            margin-top: 80px;
            border-top: 1px solid var(--vip-accent-subtle);
        }

        footer h4 {
            color: var(--vip-light);
            margin-bottom: 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            padding-bottom: 10px;
        }
        /* Underline for footer titles */
        footer h4::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--vip-gold-accent);
        }


        footer p, footer a, footer li { /* Ensure list items inherit color too */
            color: var(--vip-grey);
            font-size: 0.95rem;
            text-decoration: none;
            transition: color 0.3s ease;
        }
         footer a:hover {
             color: var(--vip-light);
         }
         footer .social-icons a {
            display: inline-block; /* Better for spacing */
            margin-right: 15px; /* Consistent spacing */
         }
         footer .social-icons a:last-child {
            margin-right: 0;
         }
         footer .social-icons a i {
             font-size: 1.4rem; /* Slightly larger icons */
             transition: color 0.3s ease, transform 0.3s ease;
         }
         footer .social-icons a:hover i {
             color: var(--vip-gold-accent);
             transform: scale(1.1);
         }

        footer hr {
            border-top: 1px solid var(--vip-accent-subtle);
        }
        footer .text-white { /* Bootstrap override, ensure it's used where needed */
            color: var(--vip-light) !important;
        }

        /* --- General Adjustments --- */
        h1, h2, h3, h4, h5, h6 {
            color: var(--vip-light);
        }

        a {
            color: var(--vip-light);
            text-decoration: none;
        }
        a:hover {
             color: var(--vip-grey); /* Default link hover */
        }

         /* Add smooth scroll */
        html {
            scroll-behavior: smooth;
        }

        /* Responsive Adjustments */
        @media (max-width: 991px) { /* Adjust breakpoint for navbar collapse */
            .navbar-nav .nav-link {
                margin-left: 0;
                padding: 0.8rem 0; /* More padding for touch */
            }
            .navbar-nav .nav-link::after { /* Disable underline on mobile collapsed menu if desired */
                 display: none;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 120px 0;
            }
            .hero-section h1 {
                font-size: 2.5rem; /* Further adjust for smaller screens */
            }
            .hero-section p {
                font-size: 1.1rem;
            }
            .btn-vip-primary, .btn-vip-outline {
                padding: 12px 25px;
                font-size: 0.9rem;
                width: 100%; /* Make buttons full width on small screens */
                margin-bottom: 15px;
            }
             .btn-vip-primary:last-of-type, .btn-vip-outline:last-of-type {
                margin-bottom: 0;
            }
            .hero-section .btn-group { /* If you group buttons */
                display: flex;
                flex-direction: column;
            }

            .section-title {
                font-size: 1.8rem;
                margin-bottom: 50px;
            }
            .feature-card {
                padding: 30px 20px;
                margin-bottom: 20px; /* Space between cards when stacked */
            }
            .service-item {
                 margin-bottom: 20px; /* Space between cards when stacked */
            }
            .service-item img {
                height: 180px;
            }
            .testimonial-card {
                 margin-bottom: 20px; /* Space between cards when stacked */
            }
            footer .col-lg-4, footer .col-md-6 { /* Ensure footer columns stack nicely */
                text-align: center;
                margin-bottom: 30px;
            }
            footer h4::after { /* Center footer title underlines */
                left: 50%;
                transform: translateX(-50%);
            }
            footer .social-icons {
                text-align: center; /* Center social icons on mobile */
            }
        }
         @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2.2rem;
            }
             .col-6 { /* Ensure service items stack to full width on xs screens */
                 flex: 0 0 100%;
                 max-width: 100%;
             }
        }

    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cut me-2"></i>BUKLE BAYAN KUAFÖRÜ
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
                        <a class="nav-link" href="randevu_ekle.php">Randevu Talebi</a>
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
            <h1 class="display-4 fw-bold mb-4">VIP Saç Sanatı Deneyimi</h1>
            <p class="lead mb-5">Kişiye özel hizmet anlayışı ve uzman dokunuşlarla stilinizi yeniden keşfedin.</p>
            <a href="randevu_ekle.php" class="btn btn-vip-primary btn-lg me-md-3 mb-3 mb-md-0">Online Randevu Alın</a>
            <a href="https://wa.me/+9055555555555?text=Merhaba,%20randevu%20almak%20istiyorum." class="btn btn-vip-outline btn-lg" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp ile Ulaşın
            </a>
        </div>
    </section>

    <section class="feature-card-section">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="far fa-calendar-alt"></i>
                        </div>
                        <h3>Kolay Randevu</h3>
                        <p>Size en uygun zamanı seçin, online sistemimizle randevunuzu saniyeler içinde oluşturun.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon">
                             <i class="fas fa-medal"></i>
                        </div>
                        <h3>Elit Kadro</h3>
                        <p>Trendleri takip eden, ödüllü ve deneyimli stilistlerimizle farkı hissedin.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                     <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h3>Premium Bakım</h3>
                        <p>Saç ve cilt sağlığınız için en seçkin markaların ürünlerini özenle kullanıyoruz.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="services-section">
        <div class="container">
            <h2 class="section-title">İmza Hizmetlerimiz</h2>
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1605497788044-5a32c7078486?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
                             class="img-fluid" alt="Özel Saç Kesimi">
                        <h4>Özel Saç Kesimi</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                     <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1595476108010-b4d1f102b1b1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=688&q=80"
                             class="img-fluid" alt="Profesyonel Renklendirme">
                        <h4>Profesyonel Renklendirme</h4>
                     </div>
                </div>
                <div class="col-md-3 col-6">
                     <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1621607512214-68297480165e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                             class="img-fluid" alt="Lüks Cilt Bakımı">
                        <h4>Lüks Cilt Bakımı</h4>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                     <div class="service-item">
                        <img src="https://images.unsplash.com/photo-1596704017255-ee7b0a1e0cd1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=687&q=80"
                             class="img-fluid" alt="Kalıcı Makyaj">
                        <h4>Kalıcı Makyaj</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonials" class="testimonials-section">
        <div class="container">
            <h2 class="section-title">Müşteri Deneyimleri</h2>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/43.jpg" class="testimonial-img" alt="Müşteri Ayşe K.">
                        <h4>Ayşe K.</h4>
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Beklentilerimin çok üzerinde bir hizmet aldım. Online randevu sistemi harika, salonun atmosferi ve çalışanların ilgisi muazzam."</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="testimonial-img" alt="Müşteri Mehmet T.">
                        <h4>Mehmet T.</h4>
                         <div class="stars mb-3">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Gerçek profesyonellerle çalışmak fark yaratıyor. Saç kesimimden çok memnun kaldım, artık başka yere gitmem."</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="testimonial-card">
                        <img src="https://randomuser.me/api/portraits/women/65.jpg" class="testimonial-img" alt="Müşteri Zeynep A.">
                        <h4>Zeynep A.</h4>
                        <div class="stars mb-3">
                             <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        </div>
                        <p>"Saçlarım hiç bu kadar canlı ve sağlıklı olmamıştı. Kullanılan ürünler gerçekten kaliteli. Teşekkürler BUKLE BAYAN KUAFÖRÜ!"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer id="contact">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                    <h4 class="mb-4">BUKLE BAYAN KUAFÖRÜ</h4>
                    <p class="pe-lg-3">Stilinizi lüks ve konforla buluşturan adres. Kişiye özel danışmanlık ve premium hizmetler.</p>
                    <div class="mt-4 social-icons">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="https://wa.me/+905434647965?text=Merhaba" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h4 class="mb-4">Hızlı Erişim</h4>
                     <ul class="list-unstyled">
                        <li class="mb-2"><a href="index.php">Ana Sayfa</a></li>
                        <li class="mb-2"><a href="randevu_ekle.php">Randevu ekle</a></li>
                        <li class="mb-2"><a href="#services">Hizmetler</a></li>
                        <li class="mb-2"><a href="#testimonials">Müşteri Yorumları</a></li>
                        <li class="mb-2"><a href="#contact">İletişim</a></li>
                     </ul>
                </div>
                 <div class="col-lg-4 col-md-12">
                    <h4 class="mb-4">İletişim & Konum</h4>
                    <p><i class="fas fa-map-marker-alt me-2 opacity-75"></i> Elit Cadde, No:25, Lüks Plaza, Beşiktaş/İstanbul</p>
                    <p><i class="fas fa-phone me-2 opacity-75"></i> (0432)210 13 50</p>
                    <p><i class="fas fa-envelope me-2 opacity-75"></i> buklebayan@gmail.com</p>
                    <p><i class="far fa-clock me-2 opacity-75"></i> H.içi: 09:00 - 20:00 | Cmt: 10:00 - 19:00</p>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0 small">© <script>document.write(new Date().getFullYear())</script> BUKLE BAYAN KUAFÖRÜ. Tüm Hakları Saklıdır. | Tasarım & Kodlama: CWTCH</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
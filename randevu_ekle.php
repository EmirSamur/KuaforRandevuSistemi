<?php
include 'baglanti.php'; // Bu dosyanın $conn PDO bağlantısını doğru şekilde kurduğundan emin olun

$success_message = null;
$error_message = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Boşlukları temizle ve verileri al
    $isim = trim($_POST["isim"] ?? '');
    $soyisim = trim($_POST["soyisim"] ?? '');
    $tarih = $_POST["tarih"] ?? '';
    $islem = trim($_POST["islem"] ?? ''); // Yapılacak işlemler ve detaylar

    // Sunucu tarafı temel doğrulama
    if (empty($isim) || empty($soyisim) || empty($tarih) || empty($islem)) {
        $error_message = "Lütfen tüm zorunlu alanları doldurun.";
    } else {
        try {
            // sp_randevu_ekle stored procedure'nüzün parametrelerini ve veri tiplerini kontrol edin.
            // 'islem' parametresinin yeterli uzunlukta (örn: TEXT veya VARCHAR(MAX)) olduğundan emin olun.
            $stmt = $conn->prepare("CALL sp_randevu_ekle(:isim, :soyisim, :tarih, :islem)");
            $stmt->bindParam(':isim', $isim, PDO::PARAM_STR);
            $stmt->bindParam(':soyisim', $soyisim, PDO::PARAM_STR);
            $stmt->bindParam(':tarih', $tarih, PDO::PARAM_STR); // Tarih formatı veritabanıyla uyumlu olmalı
            $stmt->bindParam(':islem', $islem, PDO::PARAM_STR); // Uzun metin için PDO::PARAM_LOB da düşünülebilir
            
            $stmt->execute();
            
            $success_message = 'Randevu başarıyla oluşturuldu! <a href="randevu_listele.php" class="alert-link">Randevu Listesini Görüntüle</a>';
            
            // Formu temizlemek için POST verilerini sıfırlayabiliriz (opsiyonel, aynı sayfada kalıyorsa)
            // $_POST = array(); // Eğer yönlendirme yapmıyorsanız ve formu boşaltmak istiyorsanız.
            
            // Başarı sonrası farklı bir sayfaya yönlendirme (Önerilir)
            // header("Location: randevu_listele.php?status=success_created");
            // exit;

        } catch(PDOException $e) {
            // Geliştirme ortamı için detaylı hata, canlı ortam için genel hata
            error_log("Veritabanı Hatası - Randevu Ekleme: " . $e->getMessage()); // Hataları loglamak önemlidir
            // $error_message = 'Randevu eklenirken bir hata oluştu: ' . $e->getMessage(); // Geliştirme için
            $error_message = "Randevu oluşturulurken bir sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin veya yönetici ile iletişime geçin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Randevu Oluştur - BUKLE BAYAN KUAFÖRÜ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #121212;
            --bg-card: #1c1c1c; /* Biraz daha açık kart arkaplanı */
            --primary-text: #e0e0e0;
            --secondary-text: #a0a0a0;
            --accent-color: #c0a062; /* Muted gold/bronze */
            --border-color: #383838; /* Biraz daha belirgin border */
            --input-bg: #282828; /* Biraz daha açık input arkaplanı */
            --success-bg: #1e4620; /* Biraz daha koyu yeşil */
            --success-text: #b2d8b5;
            --success-border: #2a5f2d;
            --danger-bg: #491e1e;  /* Biraz daha koyu kırmızı */
            --danger-text: #dca7a7;
            --danger-border: #6e2f2f;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--primary-text);
            line-height: 1.6;
            padding-top: 80px; /* Navbar yüksekliğine göre ayarlandı (fixed navbar için) */
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--bg-card); /* Navbar arkaplanı kartlarla aynı */
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.5); /* Daha belirgin navbar gölgesi */
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--accent-color) !important;
            font-size: 1.6rem; /* Biraz daha büyük */
            letter-spacing: 1px;
        }

        .navbar-nav .nav-link {
            color: var(--secondary-text);
            font-weight: 500;
            padding-left: 1rem;
            padding-right: 1rem;
            transition: color 0.3s ease, transform 0.2s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-text);
            transform: translateY(-1px); /* Hafif yukarı kayma efekti */
        }
         .navbar-nav .nav-link.active {
            color: var(--accent-color); /* Aktif linki altın rengi yap */
        }

        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.15);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28224, 224, 224, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }


        /* Main Content Container */
        .container.main-content {
             max-width: 780px; /* Biraz daha geniş form alanı */
             margin-top: 30px; 
             margin-bottom: 50px;
        }

        /* Card Styling */
        .card {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 10px; /* Daha yuvarlak köşeler */
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5); /* Daha yumuşak gölge */
            overflow: hidden; /* İçerik taşmasını engeller */
        }

        .card-header {
             background-color: rgba(0,0,0,0.25); /* Biraz daha belirgin başlık arkaplanı */
             border-bottom: 1px solid var(--border-color);
             padding: 1.5rem 1.75rem; /* Biraz daha fazla padding */
        }

         .card-header h2 {
             font-family: 'Playfair Display', serif;
             color: var(--primary-text);
             margin-bottom: 0;
             font-size: 2rem; /* Daha büyük başlık */
             font-weight: 700;
         }

        .card-body {
            padding: 2.25rem; /* Daha fazla padding */
        }

        /* Form Styling */
        .form-label {
            font-weight: 500;
            color: var(--secondary-text);
            margin-bottom: 0.6rem; /* Etiket ve input arası boşluk */
        }

        .form-control, .form-select, textarea.form-control {
            background-color: var(--input-bg);
            color: var(--primary-text);
            border: 1px solid var(--border-color);
            border-radius: 6px; /* Daha yuvarlak inputlar */
            padding: 0.85rem 1.1rem; /* Biraz daha padding */
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .form-control::placeholder,
        textarea.form-control::placeholder {
            color: rgba(224, 224, 224, 0.5) !important; /* Placeholder rengi biraz daha soluk */
            opacity: 1 !important;
        }
        .form-control:-ms-input-placeholder,
        textarea.form-control:-ms-input-placeholder {
            color: rgba(224, 224, 224, 0.5) !important;
        }
        .form-control::-ms-input-placeholder,
        textarea.form-control::-ms-input-placeholder {
            color: rgba(224, 224, 224, 0.5) !important;
        }

        .form-control:focus, textarea.form-control:focus {
            background-color: var(--input-bg);
            color: var(--primary-text);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(192, 160, 98, 0.3); /* Focus gölgesi */
            outline: none;
        }

        /* Tarayıcı otomatik doldurma stilleri */
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 40px var(--input-bg) inset !important; /* Daha büyük iç gölge */
            -webkit-text-fill-color: var(--primary-text) !important;
            caret-color: var(--primary-text); /* İmleç rengi */
            border-radius: 6px; /* Autofill için de border-radius */
        }

        input[type="date"] {
            position: relative;
            color-scheme: dark; /* Tarih seçici ikonunu koyu tema için ayarlar */
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.8) contrast(0.8); /* İkonu biraz daha belirgin yap */
            cursor: pointer;
            padding: 2px; /* İkona tıklama alanını artır */
        }

        .form-text.text-muted {
            color: var(--secondary-text) !important;
            font-size: 0.85em; /* Yardım metnini küçült */
        }

        /* Button Styling */
        .btn {
            padding: 0.85rem 1.75rem; /* Buton padding'i */
            border-radius: 6px; /* Buton köşe yuvarlaklığı */
            font-weight: 600; /* Buton yazı kalınlığı */
            transition: all 0.25s ease;
            text-transform: uppercase;
            letter-spacing: 0.75px; /* Harf arası boşluk */
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--bg-dark); /* Altın rengi üzerinde daha iyi kontrast için koyu arkaplan rengi */
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #a88a53; /* Accent'in koyu tonu */
            border-color: #a88a53;
            color: var(--bg-dark);
            box-shadow: 0 3px 10px rgba(192, 160, 98, 0.35); /* Hover gölgesi */
            transform: translateY(-2px); /* Hafif yukarı kalkma */
        }
         .btn-primary:active {
            transform: translateY(0); /* Tıklama anında eski yerine */
        }

        .btn-secondary {
            background-color: var(--input-bg);
            border-color: var(--border-color);
            color: var(--primary-text);
        }
        .btn-secondary:hover, .btn-secondary:focus {
            background-color: var(--border-color);
            border-color: #555; /* Daha koyu border */
            color: var(--primary-text); /* Yazı rengi değişmesin */
            box-shadow: 0 2px 8px rgba(100,100,100,0.2);
            transform: translateY(-2px);
        }
        .btn-secondary:active {
            transform: translateY(0);
        }
        
        /* Alert Styling */
        .alert {
            border-radius: 6px;
            padding: 1.1rem 1.35rem; /* Alert padding */
            margin-top: 1.75rem;
            border-width: 1px; /* Border kalınlığı */
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3); /* Alert gölgesi */
        }
        .alert-success {
            color: var(--success-text);
            background-color: var(--success-bg);
            border-color: var(--success-border);
        }
        .alert-success .alert-link {
            color: #d1ecf1; /* Daha açık link rengi */
            font-weight: bold;
        }
        .alert-danger {
            color: var(--danger-text);
            background-color: var(--danger-bg);
            border-color: var(--danger-border);
        }
         .alert-danger .alert-link {
            color: #f8d7da; /* Daha açık link rengi */
             font-weight: bold;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem 0; /* Daha fazla padding */
            margin-top: 3.5rem; /* Üstten daha fazla boşluk */
            color: var(--secondary-text);
            font-size: 0.9em;
            border-top: 1px solid var(--border-color);
            background-color: var(--bg-card); /* Footer arkaplanı */
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .card-header h2 {
                font-size: 1.6rem; /* Mobilde başlık küçült */
            }
            .card-body {
                padding: 1.5rem; /* Mobilde padding azalt */
            }
            .btn {
                width: 100%; /* Butonlar tam genişlik */
                margin-bottom: 0.5rem; /* Butonlar arası boşluk */
            }
            .d-flex.justify-content-end.gap-2 {
                flex-direction: column-reverse; /* Butonları alt alta ve "Kaydet" üste */
            }
             .d-flex.justify-content-end.gap-2 .btn-secondary {
                margin-bottom: 0.75rem;
            }
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">BUKLE BAYAN KUAFÖRÜ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Ana Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="randevu_ekle.php">Yeni Randevu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="randevu_listele.php">Randevu Listesi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-content">

        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; // HTML içerdiği için direkt echo ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-lg"> <!-- Daha belirgin gölge için shadow-lg -->
             <div class="card-header">
                <h2>Yeni Randevu Oluştur</h2>
             </div>
            <div class="card-body">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label for="isim" class="form-label">Müşteri İsim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="isim" name="isim" required placeholder="Örn: Ayşe" value="<?php echo htmlspecialchars($_POST['isim'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="soyisim" class="form-label">Müşteri Soyisim <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="soyisim" name="soyisim" required placeholder="Örn: Kaya" value="<?php echo htmlspecialchars($_POST['soyisim'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="tarih" class="form-label">Randevu Tarihi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="tarih" name="tarih" required min="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($_POST['tarih'] ?? ''); ?>">
                    </div>
                    <div class="mb-4">
                        <label for="islem" class="form-label">Yapılacak İşlem(ler) ve Detaylar <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="islem" name="islem" rows="4" required placeholder="Örn: Saç kesimi ve fön. Özel Not: Alerjim var, amonyaksız boya lütfen. Saat 14:30 civarı."><?php echo htmlspecialchars($_POST['islem'] ?? ''); ?></textarea>
                        <small class="form-text text-muted">İşlem detaylarını, tercih edilen saati ve varsa özel isteklerinizi (alerji, tercih edilen ürün vb.) buraya yazabilirsiniz.</small>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="randevu_listele.php" class="btn btn-secondary">İptal Et</a>
                        <button type="submit" class="btn btn-primary">Randevuyu Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            © <?php echo date("Y"); ?> BUKLE BAYAN KUAFÖRÜ Randevu Sistemi. Tüm Hakları Saklıdır.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
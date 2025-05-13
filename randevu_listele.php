<?php
session_start(); // Oturumu en başta başlatın

// Kullanıcının giriş yapıp yapmadığını kontrol edin, yapmadıysa giriş sayfasına yönlendirin
if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: giris.php"); // giris.php'nin giriş sayfanız olduğundan emin olun
    exit();
}

include 'baglanti.php'; // Bu dosyanın $conn PDO bağlantısını doğru şekilde kurduğundan emin olun

$randevular = []; // Boş bir dizi olarak başlatın
$error_message = null;
$success_message = $_GET['status'] ?? null; // Silme veya güncelleme sonrası başarı mesajı
$filtre_tarih_str = $_GET['filtre_tarih'] ?? null; // Seçilen filtre tarihini al (varsayılan null)

// Basit başarı mesajları
if ($success_message === 'deleted') {
    $success_message = "Randevu başarıyla silindi.";
} elseif ($success_message === 'updated') {
    $success_message = "Randevu başarıyla güncellendi.";
} elseif ($success_message === 'created') { // randevu_ekle.php'den gelirse
    $success_message = "Randevu başarıyla oluşturuldu.";
}


try {
    // Stored procedure veya view kullanmak daha iyi bir pratik olabilir:
    // Örn: CALL sp_randevulari_listele(:filtre_tarih_param);
    $sql = "SELECT randevu_id, musteri_isim, musteri_soyisim, randevu_tarih, yapilacak_islem FROM randevular";
    $params = [];

    if (!empty($filtre_tarih_str)) {
        // Tarih formatının YYYY-MM-DD olduğundan emin olun (HTML5 date input varsayılanı)
        // Güvenlik için tarih formatını doğrulamak daha da iyi olurdu (örn: DateTime::createFromFormat)
        $sql .= " WHERE DATE(randevu_tarih) = :filtre_tarih"; // Sadece tarih kısmını karşılaştır
        $params[':filtre_tarih'] = $filtre_tarih_str;
    }

    $sql .= " ORDER BY randevu_tarih DESC, randevu_id DESC"; // En yeni tarih ve ID'ye göre sırala

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $randevular = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Randevuları çekerken veritabanı hatası: " . $e->getMessage());
    $error_message = "Randevular yüklenirken bir sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Listesi - BUKLE BAYAN KUAFÖRÜ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #121212;
            --bg-card: #1c1c1c;
            --primary-text: #e0e0e0;
            --secondary-text: #a0a0a0;
            --accent-color: #c0a062;
            --border-color: #383838;
            --input-bg: #282828;
            --success-bg: #1e4620;
            --success-text: #b2d8b5;
            --success-border: #2a5f2d;
            --danger-bg: #491e1e;
            --danger-text: #dca7a7;
            --danger-border: #6e2f2f;
            --warning-bg: #4d3f1a; /* Daha koyu uyarı arkaplanı */
            --warning-text: #f5d88e;
            --warning-border: #7a6329;
            --table-stripe-bg: #232323; /* Biraz daha açık stripe */
            --filter-bg: #252525; /* Filtre bölümü için hafif farklı bir arkaplan */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--primary-text);
            line-height: 1.6;
            padding-top: 85px; /* Navbar yüksekliğine göre ayarlandı */
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.4); /* Daha belirgin gölge */
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--accent-color) !important;
            font-size: 1.6rem;
            letter-spacing: 1px;
        }
        .navbar-brand .fa-scissors {
             margin-right: 10px; /* İkon ve yazı arası boşluk */
             color: var(--accent-color);
        }
        .navbar-nav .nav-link {
            color: var(--secondary-text);
            font-weight: 500;
            padding-left: 1.1rem;
            padding-right: 1.1rem;
            transition: color 0.3s ease, transform 0.2s ease;
        }
        .navbar-nav .nav-link:hover {
            color: var(--primary-text);
            transform: translateY(-1px);
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
         .dropdown-menu-dark {
            background-color: var(--bg-card);
            border-color: var(--border-color);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .dropdown-item {
            color: var(--secondary-text);
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: var(--accent-color);
            color: var(--bg-dark);
        }
        .dropdown-item i {
            width: 20px; /* İkonlar için hizalama */
        }


        /* Main Content Container */
        .container.main-content {
             max-width: 1140px; /* Biraz daha genişletildi */
             margin-top: 30px;
             margin-bottom: 50px;
        }

        /* Page Title */
        h2.page-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary-text);
            margin-bottom: 1.2rem; /* Filtre alanına yakın olması için azaltıldı */
            font-size: 2.2rem; /* Biraz daha büyük */
            font-weight: 700;
            border-bottom: 2px solid var(--accent-color); /* Altın rengi çizgi */
            padding-bottom: 0.75rem;
            display: inline-block; /* Çizginin sadece yazı kadar olmasını sağlar */
        }

        /* Filter Section Styling */
        .filter-section {
            background-color: var(--filter-bg);
            padding: 1.25rem 1.75rem; /* Daha fazla padding */
            border-radius: 8px; /* Daha yuvarlak köşeler */
            margin-bottom: 2rem; /* Filtre ve tablo arası boşluk */
            border: 1px solid var(--border-color);
            box-shadow: 0 3px 8px rgba(0,0,0,0.25);
        }
        .filter-section .form-label {
            color: var(--secondary-text);
            font-weight: 500;
            margin-bottom: 0.25rem; /* Etiket ve input arası */
        }
        .filter-section .form-control, .filter-section .btn {
            height: calc(1.5em + .9rem + 2px); /* Buton ve input yüksekliğini eşitle */
            padding-top: .45rem;
            padding-bottom: .45rem;
            font-size: 0.9rem; /* Input ve buton yazı boyutu */
        }
        .filter-section .form-control {
            background-color: var(--input-bg);
            color: var(--primary-text);
            border-color: var(--border-color);
            border-radius: 5px;
        }
        .filter-section .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(192, 160, 98, 0.25);
            background-color: var(--input-bg); /* Focus'ta arkaplan değişmesin */
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.8) contrast(0.8);
            cursor: pointer;
        }
        input[type="date"] {
           color-scheme: dark;
        }
        .btn-filter {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: var(--bg-dark);
            font-weight: 600;
        }
        .btn-filter:hover {
            background-color: #a88a53;
            border-color: #a88a53;
            color: var(--bg-dark);
        }
        .btn-clear-filter {
            color: var(--primary-text);
            border-color: var(--border-color);
            background-color: var(--input-bg);
        }
        .btn-clear-filter:hover {
            background-color: var(--border-color);
            color: #fff;
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 8px; /* Tablo etrafındaki sarmalayıcıya radius */
            overflow: hidden; /* İçerik taşmasını engeller */
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.4);
            border: 1px solid var(--border-color); /* Dış border */
        }
        .table {
            background-color: var(--bg-card);
            color: var(--primary-text);
            margin-bottom: 0; /* table-responsive zaten margin alacak */
        }
        .table-dark {
            --bs-table-bg: var(--bg-card);
            --bs-table-border-color: var(--border-color);
            --bs-table-color: var(--primary-text);
            --bs-table-striped-bg: var(--table-stripe-bg);
            --bs-table-striped-color: var(--primary-text);
            --bs-table-hover-bg: #303030; /* Biraz daha açık hover */
            --bs-table-hover-color: var(--primary-text);
        }
        .table th {
            background-color: rgba(0,0,0,0.25); /* Başlık arkaplanı */
            color: var(--secondary-text);
            font-weight: 600; /* Daha kalın başlık yazısı */
            text-transform: uppercase;
            letter-spacing: 0.75px;
            font-size: 0.85em; /* Başlık yazı boyutu */
            border-bottom-width: 2px; /* Başlık alt çizgisi */
            border-top: none !important; /* Üstteki border'ı kaldır (responsive sarmalayıcıda var) */
            padding: 1rem 1.1rem;
        }
        .table th:first-child { border-top-left-radius: 7px; } /* Eğer table-responsive yoksa */
        .table th:last-child { border-top-right-radius: 7px; } /* Eğer table-responsive yoksa */

         .table td {
             border-top-color: var(--border-color);
             vertical-align: middle;
             padding: 1rem 1.1rem; /* Hücre padding'i */
             font-size: 0.95em;
         }
        .table td .yapilacak-islem-hucre {
            max-width: 300px; /* Daha geniş alan */
            white-space: pre-wrap; /* Satır sonlarını ve boşlukları koru */
            word-wrap: break-word;
            font-size: 0.9em; /* Biraz daha küçük işlem detayı */
            line-height: 1.5;
        }

        /* Button Styling (Consistent with theme) */
        .btn-action { /* Tablo içi aksiyon butonları için genel class */
            padding: 0.35rem 0.9rem;
            font-size: 0.8em;
            border-radius: 5px;
            font-weight: 500;
            transition: all 0.25s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-right: 6px;
        }
        .btn-action:last-child { margin-right: 0; }

        .btn-warning-dark {
            background-color: var(--warning-bg);
            border-color: var(--warning-border);
            color: var(--warning-text);
        }
        .btn-warning-dark:hover {
            background-color: #614f21;
            border-color: #8e7130;
            color: #fff;
            transform: translateY(-1px);
        }
        .btn-danger-dark {
            background-color: var(--danger-bg);
            border-color: var(--danger-border);
            color: var(--danger-text);
        }
        .btn-danger-dark:hover {
            background-color: #4d2323;
            border-color: #733737;
            color: #fff;
            transform: translateY(-1px);
        }

        /* Message Styling */
        .no-appointments-msg {
             background-color: var(--filter-bg); /* Filtre arkaplanıyla aynı */
             padding: 2.5rem; /* Daha fazla padding */
             border-radius: 8px;
             text-align: center;
             color: var(--secondary-text);
             border: 1px dashed var(--border-color);
             margin-top: 1rem; /* Üstte boşluk */
        }
        .no-appointments-msg i.fa-calendar-times { color: var(--accent-color); }

        .alert { /* Genel alert stilleri */
            border-radius: 6px;
            padding: 1.1rem 1.35rem;
            margin-bottom: 1.75rem; /* Alertler arası boşluk */
            border-width: 1px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        }
        .alert-success {
            color: var(--success-text);
            background-color: var(--success-bg);
            border-color: var(--success-border);
        }
        .alert-danger {
            color: var(--danger-text);
            background-color: var(--danger-bg);
            border-color: var(--danger-border);
        }


        /* Footer */
        .footer {
            text-align: center;
            padding: 2rem 0;
            margin-top: 3.5rem;
            color: var(--secondary-text);
            font-size: 0.9em;
            border-top: 1px solid var(--border-color);
            background-color: var(--bg-card);
        }

        /* Mobil için buton metinlerini gizle */
        @media (max-width: 767px) {
            .btn-action .btn-text {
                display: none;
            }
            .btn-action {
                padding: 0.5rem 0.7rem; /* İkon butonları için daha karemsi */
            }
            h2.page-title { font-size: 1.8rem; }
            .filter-section { padding: 1rem; }
            .filter-section .col-md-3, .filter-section .col-sm-4 { margin-bottom: 0.5rem; }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-cut"></i> BUKLE BAYAN KUAFÖRÜ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Ana Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="randevu_ekle.php">Yeni Randevu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="randevu_listele.php">Randevu Listesi</a>
                    </li>
                     <li class="nav-item d-none d-lg-block">
                         <span class="nav-link disabled text-muted">|</span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['kullanici_adi']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                            <!-- <li><a class="dropdown-item" href="profil.php"><i class="fas fa-user-edit me-2"></i>Profilim</a></li> -->
                            <!-- <li><hr class="dropdown-divider" style="border-color: var(--border-color);"></li> -->
                            <li><a class="dropdown-item" href="cikis.php"><i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h2 class="page-title mb-0">Mevcut Randevular</h2>
             <a href="randevu_ekle.php" class="btn btn-sm btn-success" style="background-color: var(--accent-color); border-color: var(--accent-color); color: var(--bg-dark); font-weight:600;">
                <i class="fas fa-plus-circle me-1"></i> Yeni Randevu Ekle
            </a>
        </div>


        <!-- TARİH FİLTRELEME FORMU -->
        <div class="filter-section">
            <form method="GET" action="randevu_listele.php" class="row gx-3 gy-2 align-items-end">
                <div class="col-md-4 col-lg-3">
                    <label for="filtre_tarih" class="form-label">Tarihe Göre Filtrele:</label>
                    <input type="date" class="form-control" id="filtre_tarih" name="filtre_tarih"
                           value="<?php echo htmlspecialchars($filtre_tarih_str ?? ''); ?>"
                           max="<?php echo date('Y-m-d', strtotime('+5 years')); ?>"
                           min="<?php echo date('Y-m-d', strtotime('-5 years')); ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-filter"><i class="fas fa-filter me-1"></i>Filtrele</button>
                </div>
                <?php if (!empty($filtre_tarih_str)): ?>
                <div class="col-auto">
                    <a href="randevu_listele.php" class="btn btn-clear-filter"><i class="fas fa-times me-1"></i>Temizle</a>
                </div>
                <?php endif; ?>
            </form>
        </div>
        <!-- FİLTRELEME FORMU BİTİŞİ -->

        <?php if ($success_message && ($success_message === 'Randevu başarıyla silindi.' || $success_message === 'Randevu başarıyla güncellendi.' || $success_message === "Randevu başarıyla oluşturuldu.")): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!$error_message && empty($randevular)): ?>
            <div class="no-appointments-msg">
                <p><i class="far fa-calendar-times fa-3x mb-3"></i></p>
                <?php if (!empty($filtre_tarih_str)): ?>
                    <h5 class="mb-2">Randevu Bulunamadı</h5>
                    <p class="mb-0"><strong><?php echo htmlspecialchars(date("d.m.Y", strtotime($filtre_tarih_str))); ?></strong> tarihinde kayıtlı randevu bulunmamaktadır.</p>
                    <a href="randevu_listele.php" class="btn btn-sm btn-outline-secondary mt-3"><i class="fas fa-list me-1"></i>Tüm Randevuları Göster</a>
                <?php else: ?>
                     <h5 class="mb-2">Henüz Randevu Yok</h5>
                    <p class="mb-0">Gösterilecek mevcut randevu bulunmamaktadır.</p>
                    <a href="randevu_ekle.php" class="btn btn-sm btn-outline-secondary mt-3"><i class="fas fa-plus me-1"></i>Yeni Randevu Ekle</a>
                <?php endif; ?>
            </div>
        <?php elseif (!empty($randevular)): ?>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 5%;">#</th>
                            <th scope="col" style="width: 15%;">Müşteri Adı</th>
                            <th scope="col" style="width: 15%;">Soyadı</th>
                            <th scope="col" style="width: 15%;">Randevu Tarihi</th>
                            <th scope="col">Yapılacak İşlem</th>
                            <th scope="col" class="text-center" style="width: 20%;">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($randevular as $key => $randevu): ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1; ?></th>
                                <td><?php echo htmlspecialchars($randevu['musteri_isim']); ?></td>
                                <td><?php echo htmlspecialchars($randevu['musteri_soyisim']); ?></td>
                                <td><?php echo htmlspecialchars(date("d.m.Y", strtotime($randevu['randevu_tarih']))); ?></td>
                                <td><div class="yapilacak-islem-hucre"><?php echo nl2br(htmlspecialchars($randevu['yapilacak_islem'])); ?></div></td>
                                <td class="text-center">
                                    <a href="randevu_guncelle.php?id=<?php echo htmlspecialchars($randevu['randevu_id']); ?>" class="btn btn-action btn-warning-dark" title="Güncelle">
                                        <i class="fas fa-edit"></i> <span class="btn-text d-none d-md-inline">Güncelle</span>
                                    </a>
                                    <a href="randevu_sil.php?id=<?php echo htmlspecialchars($randevu['randevu_id']); ?>" class="btn btn-action btn-danger-dark" title="Sil" onclick="return confirm('Bu randevuyu kalıcı olarak silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!')">
                                        <i class="fas fa-trash-alt"></i> <span class="btn-text d-none d-md-inline">Sil</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

     <footer class="footer">
        <div class="container">
            © <?php echo date("Y"); ?> BUKLE BAYAN KUAFÖRÜ Randevu Sistemi. Tüm Hakları Saklıdır.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
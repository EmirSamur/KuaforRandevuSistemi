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
$filtre_tarih_str = $_GET['filtre_tarih'] ?? null; // Seçilen filtre tarihini al (varsayılan null)

try {
    $sql = "SELECT randevu_id, musteri_isim, musteri_soyisim, randevu_tarih, yapilacak_islem FROM randevular";
    $params = [];

    if (!empty($filtre_tarih_str)) {
        // Tarih formatını doğrulamak iyi bir pratiktir, ancak input type="date" genellikle Y-m-d formatında gönderir
        // Veritabanınızdaki randevu_tarih sütununun DATE tipinde olduğunu varsayıyoruz
        $sql .= " WHERE randevu_tarih = :filtre_tarih";
        $params[':filtre_tarih'] = $filtre_tarih_str;
    }

    $sql .= " ORDER BY randevu_tarih DESC, randevu_id DESC"; // Tarihe ve sonra ID'ye göre sırala

    $stmt = $conn->prepare($sql);
    $stmt->execute($params); // Parametrelerle çalıştır

    $randevular = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log("Randevuları çekerken veritabanı hatası: " . $e->getMessage());
    $error_message = "Randevular yüklenirken bir sorun oluştu. Lütfen daha sonra tekrar deneyin.";
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Listesi - BUKLE BAYAN KUAFÖRÜ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #121212;
            --bg-card: #1f1f1f;
            --primary-text: #e0e0e0;
            --secondary-text: #a0a0a0;
            --accent-color: #c0a062;
            --border-color: #333333;
            --input-bg: #2a2a2a;
            --success-bg: #1a3a1a;
            --success-text: #a3d9a3;
            --success-border: #2a5a2a;
            --danger-bg: #3a1a1a;
            --danger-text: #d9a3a3;
            --danger-border: #5a2a2a;
            --warning-bg: #4d3f1a;
            --warning-text: #f5d88e;
            --warning-border: #7a6329;
            --table-stripe-bg: #252525;
            --filter-bg: #282828; /* Filtre bölümü için hafif farklı bir arkaplan */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--primary-text);
            line-height: 1.6;
            padding-top: 80px;
        }

        /* Navbar Styling */
        .navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding-top: 0.8rem;
            padding-bottom: 0.8rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--accent-color) !important;
            font-size: 1.5rem;
            letter-spacing: 1px;
        }
        .navbar-brand .fa-scissors {
             margin-right: 8px;
             color: var(--accent-color);
        }
        .navbar-nav .nav-link {
            color: var(--secondary-text);
            font-weight: 500;
            padding-left: 1rem;
            padding-right: 1rem;
            transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary-text);
        }
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.1);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28224, 224, 224, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Main Content Container */
        .container.main-content {
             max-width: 1100px;
             margin-top: 25px; /* Navbar altı boşluk + filtre alanı için */
             margin-bottom: 40px;
        }

        /* Page Title */
        h2.page-title {
            font-family: 'Playfair Display', serif;
            color: var(--primary-text);
            margin-bottom: 1.0rem; /* Filtre alanına yakın olması için azaltıldı */
            font-size: 2rem;
            font-weight: 700;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        /* Filter Section Styling */
        .filter-section {
            background-color: var(--filter-bg);
            padding: 1rem 1.5rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .filter-section .form-label {
            color: var(--secondary-text);
            font-weight: 500;
        }
        .filter-section .form-control, .filter-section .btn {
            height: calc(1.5em + .75rem + 2px); /* Buton ve input yüksekliğini eşitle */
            padding-top: .375rem;
            padding-bottom: .375rem;
        }
        .filter-section .form-control {
            background-color: var(--input-bg);
            color: var(--primary-text);
            border-color: var(--border-color);
        }
        .filter-section .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(192, 160, 98, 0.25);
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.8); /* Takvim ikonunu görünür yap */
        }
        input[type="date"] {
           color-scheme: dark; /* Tarih seçici ikonunu koyu tema için ayarlar */
        }
        .btn-filter { /* Filtrele butonu için özel renk */
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #000; /* Altın rengi üzerinde siyah metin */
        }
        .btn-filter:hover {
            background-color: #a88a53;
            border-color: #a88a53;
            color: #000;
        }
        .btn-clear-filter {
            color: var(--primary-text);
            border-color: var(--border-color);
        }
        .btn-clear-filter:hover {
            background-color: var(--border-color);
            color: #fff;
        }

        /* Table Styling */
        .table {
            background-color: var(--bg-card);
            color: var(--primary-text);
            border: 1px solid var(--border-color);
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            margin-bottom: 0;
        }
        .table-dark {
            --bs-table-bg: var(--bg-card);
            --bs-table-border-color: var(--border-color);
            --bs-table-color: var(--primary-text);
            --bs-table-striped-bg: var(--table-stripe-bg);
            --bs-table-striped-color: var(--primary-text);
            --bs-table-hover-bg: #323232;
            --bs-table-hover-color: var(--primary-text);
        }
        .table th {
            background-color: rgba(0,0,0,0.2);
            color: var(--secondary-text);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.9em;
            border-bottom-width: 1px;
            padding: 0.9rem 1rem;
        }
         .table td {
             border-top-color: var(--border-color);
             vertical-align: middle;
             padding: 0.9rem 1rem;
         }
        .table td .yapilacak-islem-hucre { /* Uzun metinler için */
            max-width: 280px; /* İhtiyaca göre ayarlayın */
            white-space: normal; /* Satır sonlarını koru */
            word-wrap: break-word; /* Uzun kelimeleri kır */
        }

        /* Button Styling (Consistent with theme) */
        .btn {
            padding: 0.3rem 0.8rem;
            font-size: 0.85em;
            border-radius: 4px;
            font-weight: 500;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-right: 5px;
        }
        .btn:last-child {
            margin-right: 0;
        }
        .btn-warning-dark {
            background-color: var(--warning-bg);
            border-color: var(--warning-border);
            color: var(--warning-text);
        }
        .btn-warning-dark:hover {
            background-color: #614f21;
            border-color: #8e7130;
            color: #fff;
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
        }

        /* Message Styling */
        .no-appointments-msg {
             background-color: var(--bg-card);
             padding: 2rem;
             border-radius: 5px;
             text-align: center;
             color: var(--secondary-text);
             border: 1px dashed var(--border-color);
        }
        .alert-danger {
            color: var(--danger-text);
            background-color: var(--danger-bg);
            border-color: var(--danger-border);
            margin-bottom: 1.5rem;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 3rem;
            color: var(--secondary-text);
            font-size: 0.9em;
            border-top: 1px solid var(--border-color);
        }
        .table-responsive {
            border-radius: 5px;
            border: 1px solid var(--border-color);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-scissors"></i>BUKLE BAYAN KUAFÖRÜ
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Ana Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="randevu_ekle.php">Yeni Randevu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="randevu_listele.php">Randevu Listesi</a>
                    </li>
                     <li class="nav-item">
                         <span class="nav-link disabled text-muted d-none d-lg-inline">|</span>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           <i class="fas fa-user-circle me-1"></i> <?php echo htmlspecialchars($_SESSION['kullanici_adi']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdownUser">
                            <li><a class="dropdown-item" href="cikis.php"><i class="fas fa-sign-out-alt me-2"></i>Çıkış Yap</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        <h2 class="page-title">Mevcut Randevular</h2>

        <!-- TARİH FİLTRELEME FORMU -->
        <div class="filter-section">
            <form method="GET" action="randevu_listele.php" class="row gx-2 gy-2 align-items-center">
                <div class="col-auto">
                    <label for="filtre_tarih" class="form-label mb-0">Tarihe Göre Filtrele:</label>
                </div>
                <div class="col-md-3 col-sm-4 col-6">
                    <input type="date" class="form-control form-control-sm" id="filtre_tarih" name="filtre_tarih"
                           value="<?php echo htmlspecialchars($filtre_tarih_str ?? ''); ?>"
                           max="<?php echo date('Y-m-d', strtotime('+5 years')); /* Gelecekte çok uzak tarihleri engelle */ ?>"
                           min="<?php echo date('Y-m-d', strtotime('-5 years')); /* Geçmişte çok uzak tarihleri engelle */ ?>">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-filter"><i class="fas fa-filter me-1"></i>Filtrele</button>
                </div>
                <?php if (!empty($filtre_tarih_str)): ?>
                <div class="col-auto">
                    <a href="randevu_listele.php" class="btn btn-sm btn-clear-filter"><i class="fas fa-times me-1"></i>Filtreyi Temizle</a>
                </div>
                <?php endif; ?>
            </form>
        </div>
        <!-- FİLTRELEME FORMU BİTİŞİ -->


        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if (!$error_message && empty($randevular)): ?>
            <div class="no-appointments-msg">
                <p><i class="far fa-calendar-times fa-2x mb-3"></i></p>
                <?php if (!empty($filtre_tarih_str)): ?>
                    <p class="mb-0"><strong><?php echo htmlspecialchars(date("d.m.Y", strtotime($filtre_tarih_str))); ?></strong> tarihinde kayıtlı randevu bulunmamaktadır.</p>
                    <a href="randevu_listele.php" class="btn btn-sm btn-outline-secondary mt-3">Tüm Randevuları Göster</a>
                <?php else: ?>
                    <p class="mb-0">Gösterilecek mevcut randevu bulunmamaktadır.</p>
                    <a href="randevu_ekle.php" class="btn btn-sm btn-outline-secondary mt-3">Yeni Randevu Ekle</a>
                <?php endif; ?>
            </div>
        <?php elseif (!empty($randevular)): ?>
            <div class="table-responsive shadow-sm">
                <table class="table table-dark table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Müşteri Adı</th>
                            <th scope="col">Soyadı</th>
                            <th scope="col">Randevu Tarihi</th>
                            <th scope="col">Yapılacak İşlem</th>
                            <th scope="col" class="text-center">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($randevular as $key => $randevu): ?>
                            <tr>
                                <th scope="row"><?php echo $key + 1; // Sıra numarası için key + 1 (filtre durumunda da çalışır) ?></th>
                                <td><?php echo htmlspecialchars($randevu['musteri_isim']); ?></td>
                                <td><?php echo htmlspecialchars($randevu['musteri_soyisim']); ?></td>
                                <td><?php echo htmlspecialchars(date("d.m.Y", strtotime($randevu['randevu_tarih']))); ?></td>
                                <td><div class="yapilacak-islem-hucre"><?php echo nl2br(htmlspecialchars($randevu['yapilacak_islem'])); ?></div></td>
                                <td class="text-center">
                                    <a href="randevu_guncelle.php?id=<?php echo htmlspecialchars($randevu['randevu_id']); ?>" class="btn btn-sm btn-warning-dark" title="Güncelle">
                                        <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Güncelle</span>
                                    </a>
                                    <a href="randevu_sil.php?id=<?php echo htmlspecialchars($randevu['randevu_id']); ?>" class="btn btn-sm btn-danger-dark" title="Sil" onclick="return confirm('Bu randevuyu kalıcı olarak silmek istediğinizden emin misiniz?')">
                                        <i class="fas fa-trash-alt"></i> <span class="d-none d-md-inline">Sil</span>
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
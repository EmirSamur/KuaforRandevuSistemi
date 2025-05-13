<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: giris.php");
    exit();
}

include 'baglanti.php'; // Include database connection

$randevu = null;
$error_message = null;
$success_message = null;
$randevu_id = null;

// --- Handle GET request: Fetch appointment data ---
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $randevu_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate ID

    if ($randevu_id === false || $randevu_id <= 0) {
        $error_message = "Geçersiz Randevu ID'si belirtildi.";
        // Optional: Redirect or display error and exit
        // header("Location: randevu_listele.php?status=invalid_id");
        // exit();
    } else {
        try {
            $stmt = $conn->prepare("SELECT * FROM randevular WHERE randevu_id = :id");
            $stmt->bindParam(':id', $randevu_id, PDO::PARAM_INT);
            $stmt->execute();
            $randevu = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$randevu) {
                $error_message = "Belirtilen ID'ye sahip randevu bulunamadı.";
                $randevu_id = null; // Clear invalid ID
            }
        } catch(PDOException $e) {
            error_log("DB Error fetching appointment for update: " . $e->getMessage());
            $error_message = "Randevu bilgileri getirilirken bir sunucu hatası oluştu.";
            $randevu_id = null; // Clear ID on error
        }
    }
}
// --- Handle POST request: Update appointment data ---
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $isim = trim(filter_input(INPUT_POST, 'isim', FILTER_SANITIZE_STRING));
    $soyisim = trim(filter_input(INPUT_POST, 'soyisim', FILTER_SANITIZE_STRING));
    $tarih = $_POST["tarih"] ?? ''; // Basic retrieval, more validation needed if strict format required
    $islem = trim(filter_input(INPUT_POST, 'islem', FILTER_SANITIZE_STRING));

    // Basic validation
    if ($id === false || $id <= 0 || empty($isim) || empty($soyisim) || empty($tarih) || empty($islem)) {
        $error_message = "Lütfen tüm alanları kontrol edip tekrar deneyin.";
        // Re-fetch data for the form if validation fails
        $randevu_id = $id; // Keep the ID to potentially refill the form
        if ($randevu_id) {
             try { // Re-fetch original data to display in form despite error
                 $stmt = $conn->prepare("SELECT * FROM randevular WHERE randevu_id = :id");
                 $stmt->bindParam(':id', $randevu_id, PDO::PARAM_INT);
                 $stmt->execute();
                 $randevu = $stmt->fetch(PDO::FETCH_ASSOC);
                  if (!$randevu) { $randevu_id = null; } // Handle case where ID becomes invalid between POST and fetch
             } catch(PDOException $e) { /* Ignore fetch error here, primary error is validation */ }
        }

    } else {
        try {
            // Assuming sp_randevu_guncelle is correct
            $stmt = $conn->prepare("CALL sp_randevu_guncelle(:id, :isim, :soyisim, :tarih, :islem)");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':isim', $isim, PDO::PARAM_STR);
            $stmt->bindParam(':soyisim', $soyisim, PDO::PARAM_STR);
            $stmt->bindParam(':tarih', $tarih, PDO::PARAM_STR);
            $stmt->bindParam(':islem', $islem, PDO::PARAM_STR);
            $stmt->execute();

            // Success: Redirect is often better UX after update
            $_SESSION['flash_message'] = [
                'type' => 'success',
                'text' => 'Randevu başarıyla güncellendi!'
            ];
            header("Location: randevu_listele.php");
            exit();

            // OR: Show message on the same page (less common for updates)
            // $success_message = 'Randevu başarıyla güncellendi! <a href="randevu_listele.php" class="alert-link">Randevu Listesi</a>';
            // // Re-fetch the *updated* data to display in the form
            // $stmt = $conn->prepare("SELECT * FROM randevular WHERE randevu_id = :id");
            // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            // $stmt->execute();
            // $randevu = $stmt->fetch(PDO::FETCH_ASSOC);
            // $randevu_id = $id;


        } catch(PDOException $e) {
            error_log("DB Error updating appointment: " . $e->getMessage());
            $error_message = "Randevu güncellenirken bir sunucu hatası oluştu.";
            // Re-fetch original data if update failed
            $randevu_id = $id;
             if ($randevu_id) {
                  try {
                      $stmt = $conn->prepare("SELECT * FROM randevular WHERE randevu_id = :id");
                      $stmt->bindParam(':id', $randevu_id, PDO::PARAM_INT);
                      $stmt->execute();
                      $randevu = $stmt->fetch(PDO::FETCH_ASSOC);
                      if (!$randevu) { $randevu_id = null; }
                  } catch(PDOException $ex) { /* Ignore */ }
             }
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['id'])) {
     $error_message = "Güncellenecek randevu ID'si belirtilmedi.";
     // Redirect if no ID on initial GET
     // header("Location: randevu_listele.php?status=no_id");
     // exit();
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Güncelle - VIP Kuaför Yönetimi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Paste the EXACT SAME :root and other styles from randevu_ekle.php or randevu_listele.php here */
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
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--primary-text);
            line-height: 1.6;
            padding-top: 80px; /* Navbar height */
        }

        .navbar {
            background-color: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            position: fixed; top: 0; width: 100%; z-index: 1030;
            padding-top: 0.8rem; padding-bottom: 0.8rem;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif; font-weight: 700;
            color: var(--accent-color) !important; font-size: 1.5rem; letter-spacing: 1px;
        }
        .navbar-brand .fa-scissors { margin-right: 8px; color: var(--accent-color); }
        .navbar-nav .nav-link {
            color: var(--secondary-text); font-weight: 500; padding-left: 1rem; padding-right: 1rem; transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--primary-text); }
        .navbar-toggler { border-color: rgba(255, 255, 255, 0.1); }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28224, 224, 224, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }

        .container.main-content { max-width: 760px; margin-top: 40px; margin-bottom: 40px; }
        .card {
            background-color: var(--bg-card); border: 1px solid var(--border-color);
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); overflow: hidden;
        }
        .card-header { background-color: rgba(0,0,0,0.2); border-bottom: 1px solid var(--border-color); padding: 1.25rem 1.5rem; }
        .card-header h2 { font-family: 'Playfair Display', serif; color: var(--primary-text); margin-bottom: 0; font-size: 1.8rem; font-weight: 700; }
        .card-body { padding: 2rem; }

        .form-label { font-weight: 500; color: var(--secondary-text); margin-bottom: 0.5rem; }
        .form-control, .form-select {
            background-color: var(--input-bg); color: var(--primary-text); border: 1px solid var(--border-color);
            border-radius: 4px; padding: 0.75rem 1rem; transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-control:-webkit-autofill, .form-control:-webkit-autofill:hover, .form-control:-webkit-autofill:focus, .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px var(--input-bg) inset !important; -webkit-text-fill-color: var(--primary-text) !important; caret-color: var(--primary-text);
        }
        .form-control:focus {
            background-color: var(--input-bg); color: var(--primary-text); border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(192, 160, 98, 0.25); outline: none;
        }
        input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(0.8); cursor: pointer; }
        input[type="date"] { color-scheme: dark; }

        .btn { padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 500; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-primary { background-color: var(--accent-color); border-color: var(--accent-color); color: #fff; }
        .btn-primary:hover, .btn-primary:focus { background-color: #a88a53; border-color: #a88a53; color: #fff; box-shadow: 0 2px 8px rgba(192, 160, 98, 0.3); }
        .btn-secondary { background-color: var(--input-bg); border-color: var(--border-color); color: var(--primary-text); }
        .btn-secondary:hover, .btn-secondary:focus { background-color: var(--border-color); border-color: #444; color: #fff; }

        .alert { border-radius: 4px; padding: 1rem 1.25rem; margin-top: 1.5rem; border: 1px solid transparent; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); }
        .alert-success { color: var(--success-text); background-color: var(--success-bg); border-color: var(--success-border); }
        .alert-success .alert-link { color: #c8e6c9; font-weight: bold; }
        .alert-danger { color: var(--danger-text); background-color: var(--danger-bg); border-color: var(--danger-border); }
        .alert-danger .alert-link { color: #ffcdd2; font-weight: bold; }

        .footer { text-align: center; padding: 1.5rem 0; margin-top: 3rem; color: var(--secondary-text); font-size: 0.9em; border-top: 1px solid var(--border-color); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
         <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-scissors"></i>BUKLE BAYAN KUAFÖRÜ</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Ana Panel</a></li>
                    <li class="nav-item"><a class="nav-link" href="randevu_ekle.php">Yeni Randevu</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="randevu_listele.php">Randevu Listesi</a></li>
                    <li class="nav-item"><span class="nav-link disabled text-muted d-none d-lg-inline">|</span></li>
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

        <!-- Alert Messages Display -->
        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>


        <?php if ($randevu_id && $randevu): // Only show form if we have a valid appointment to edit ?>
            <div class="card shadow-sm">
                 <div class="card-header">
                    <h2>Randevu Bilgilerini Güncelle</h2>
                 </div>
                <div class="card-body">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($randevu['randevu_id']); ?>">

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="isim" class="form-label">Müşteri İsim</label>
                                <input type="text" class="form-control" id="isim" name="isim" required
                                       value="<?php echo htmlspecialchars($randevu['musteri_isim']); ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="soyisim" class="form-label">Müşteri Soyisim</label>
                                <input type="text" class="form-control" id="soyisim" name="soyisim" required
                                       value="<?php echo htmlspecialchars($randevu['musteri_soyisim']); ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="tarih" class="form-label">Randevu Tarihi</label>
                            <input type="date" class="form-control" id="tarih" name="tarih" required
                                   value="<?php echo htmlspecialchars($randevu['randevu_tarih']); ?>" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                        <div class="mb-4">
                            <label for="islem" class="form-label">Yapılacak İşlem(ler)</label>
                            <textarea class="form-control" id="islem" name="islem" rows="4" required><?php echo htmlspecialchars($randevu['yapilacak_islem']); ?></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="randevu_listele.php" class="btn btn-secondary">İptal</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Güncelle</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php elseif (!$error_message): // If ID was missing initially or not found, show link back ?>
             <div class="alert alert-warning" role="alert">
                Güncellenecek geçerli bir randevu bulunamadı veya ID belirtilmedi.
             </div>
             <a href="randevu_listele.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Randevu Listesine Dön</a>
        <?php endif; ?>

    </div>

    <footer class="footer">
        <div class="container">
            © <?php echo date("Y"); ?> VIP Kuaför Randevu Sistemi. Tüm Hakları Saklıdır.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
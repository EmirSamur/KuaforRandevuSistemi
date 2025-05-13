<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: giris.php");
    exit();
}

include 'baglanti.php';

$randevu_id = null;
$confirmation_needed = false;
$error_message = null;
$randevu_details = null; // Optional: To show what's being deleted

// --- Validate ID parameter ---
if (isset($_GET['id'])) {
    $randevu_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($randevu_id === false || $randevu_id <= 0) {
        $error_message = "Geçersiz Randevu ID'si.";
        $randevu_id = null; // Invalidate
    }
} else {
    $error_message = "Silinecek randevu ID'si belirtilmedi.";
}

// --- Check for Confirmation & Perform Deletion ---
if ($randevu_id && isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
    try {
        // Assuming sp_randevu_sil is correct
        $stmt = $conn->prepare("CALL sp_randevu_sil(:id)");
        $stmt->bindParam(':id', $randevu_id, PDO::PARAM_INT);
        $stmt->execute();

        // Deletion successful: Set flash message and redirect
        $_SESSION['flash_message'] = [
            'type' => 'success',
            'text' => "Randevu (ID: {$randevu_id}) başarıyla silindi!"
        ];
        header("Location: randevu_listele.php");
        exit();

    } catch(PDOException $e) {
        error_log("DB Error deleting appointment ID {$randevu_id}: " . $e->getMessage());
        // Set error message and let the page render the confirmation/error section again
        $error_message = "Randevu silinirken bir sunucu hatası oluştu. Lütfen tekrar deneyin.";
        // Keep $confirmation_needed as false since deletion failed
    }
}
// --- Prepare for Confirmation Screen (if ID is valid and not confirmed yet) ---
elseif ($randevu_id && !$error_message) {
    $confirmation_needed = true;
    // Optional: Fetch details to display in confirmation message
    try {
        $stmt = $conn->prepare("SELECT musteri_isim, musteri_soyisim, randevu_tarih FROM randevular WHERE randevu_id = :id");
        $stmt->bindParam(':id', $randevu_id, PDO::PARAM_INT);
        $stmt->execute();
        $randevu_details = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$randevu_details) {
            // Appointment might have been deleted by someone else between clicks
             $error_message = "Silinmek istenen randevu bulunamadı. Liste güncellenmiş olabilir.";
             $confirmation_needed = false;
        }
    } catch (PDOException $e) {
        // Error fetching details, proceed without them
        error_log("DB Error fetching details for delete confirmation ID {$randevu_id}: " . $e->getMessage());
        $randevu_details = null; // Ensure it's null on error
    }
}

?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevu Silme Onayı - VIP Kuaför Yönetimi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Paste the EXACT SAME :root and other styles from the other themed pages here */
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
            background-color: var(--bg-card); border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3); position: fixed; top: 0; width: 100%; z-index: 1030;
            padding-top: 0.8rem; padding-bottom: 0.8rem;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif; font-weight: 700; color: var(--accent-color) !important;
            font-size: 1.5rem; letter-spacing: 1px;
        }
         .navbar-brand .fa-scissors { margin-right: 8px; color: var(--accent-color); }
        .navbar-nav .nav-link {
            color: var(--secondary-text); font-weight: 500; padding-left: 1rem; padding-right: 1rem; transition: color 0.3s ease;
        }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: var(--primary-text); }
        .navbar-toggler { border-color: rgba(255, 255, 255, 0.1); }
        .navbar-toggler-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28224, 224, 224, 0.8%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e"); }

        .container.main-content { max-width: 600px; margin-top: 40px; margin-bottom: 40px; }
         .card {
            background-color: var(--bg-card); border: 1px solid var(--border-color);
            border-radius: 8px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); overflow: hidden;
        }
        .card-body { padding: 2.5rem; text-align: center; }
        .card-title { font-family: 'Playfair Display', serif; font-size: 1.7rem; margin-bottom: 1rem; }
        .card-text { color: var(--secondary-text); margin-bottom: 1.5rem; font-size: 1.1rem; }
        .card-text strong { color: var(--primary-text); }
        .confirmation-icon { font-size: 3rem; color: var(--danger-text); margin-bottom: 1rem; }

        .btn { padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 500; transition: all 0.3s ease; text-transform: uppercase; letter-spacing: 0.5px; }
        /* Use the specific dark danger button from listele page */
        .btn-danger-dark {
            background-color: var(--danger-bg); border-color: var(--danger-border); color: var(--danger-text);
        }
        .btn-danger-dark:hover { background-color: #4d2323; border-color: #733737; color: #fff; }
         .btn-secondary { background-color: var(--input-bg); border-color: var(--border-color); color: var(--primary-text); }
        .btn-secondary:hover, .btn-secondary:focus { background-color: var(--border-color); border-color: #444; color: #fff; }


        .alert { border-radius: 4px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; border: 1px solid transparent; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); }
        .alert-danger { color: var(--danger-text); background-color: var(--danger-bg); border-color: var(--danger-border); }
        .alert-warning { color: #ffd54f; background-color: #4d3f1a; border-color: #7a6329; } /* Dark warning */

        .footer { text-align: center; padding: 1.5rem 0; margin-top: 3rem; color: var(--secondary-text); font-size: 0.9em; border-top: 1px solid var(--border-color); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <!-- Navbar content copied from randevu_guncelle.php -->
         <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-scissors"></i>VIP KUAFÖR</a>
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

        <?php if ($error_message): ?>
            <div class="alert <?php echo ($randevu_id === null || strpos($error_message, 'belirtilmedi') !== false || strpos($error_message, 'Geçersiz') !== false) ? 'alert-warning' : 'alert-danger'; ?>" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>


        <?php if ($confirmation_needed): ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="confirmation-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h5 class="card-title">Randevu Silme Onayı</h5>
                    <p class="card-text">
                        Aşağıdaki randevuyu kalıcı olarak silmek istediğinizden emin misiniz?
                        <?php if ($randevu_details): ?>
                            <br>Müşteri: <strong><?php echo htmlspecialchars($randevu_details['musteri_isim'] . ' ' . $randevu_details['musteri_soyisim']); ?></strong>
                            <br>Tarih: <strong><?php echo htmlspecialchars(date("d.m.Y", strtotime($randevu_details['randevu_tarih']))); ?></strong>
                        <?php else: ?>
                            <br>Randevu ID: <strong><?php echo htmlspecialchars($randevu_id); ?></strong>
                        <?php endif; ?>
                        <br>Bu işlem geri alınamaz.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="randevu_listele.php" class="btn btn-secondary">
                           <i class="fas fa-times me-1"></i> Hayır, İptal Et
                        </a>
                         <a href="randevu_sil.php?id=<?php echo htmlspecialchars($randevu_id); ?>&confirm=yes" class="btn btn-danger-dark">
                            <i class="fas fa-trash-alt me-1"></i> Evet, Sil
                         </a>
                    </div>
                </div>
            </div>

        <?php elseif (!$confirmation_needed): // If no confirmation needed (e.g., error occurred or ID was invalid initially) ?>
             <div class="text-center mt-4">
                 <a href="randevu_listele.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Randevu Listesine Dön</a>
            </div>
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
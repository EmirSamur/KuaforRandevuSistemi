<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Oturum başlatma her zaman en başta olmalı
session_start();

// Eğer kullanıcı zaten giriş yapmışsa, onu ana sayfaya yönlendir
if (isset($_SESSION['kullanici_adi'])) {
    header("Location: randevu_listele.php");
    exit(); // Yönlendirmeden sonra betiği durdurmak önemlidir
}

// Veritabanı bağlantı dosyasını dahil et
// Bu dosyanın doğru yolda olduğundan emin olun
include 'baglanti.php'; 

// Hata mesajını başlangıçta boş olarak ayarla
$hata_mesaji = null;

// Sadece POST isteği geldiğinde işlem yap
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Gelen verileri temizle ve boş olup olmadığını kontrol et
    // ?? operatörü, değişken yoksa boş string atar, bu da hatayı önler
    $kullanici_adi = trim($_POST["kullanici_adi"] ?? '');
    $sifre = $_POST["sifre"] ?? '';

    // Temel doğrulama
    if (empty($kullanici_adi) || empty($sifre)) {
         $hata_mesaji = "Kullanıcı adı ve şifre alanları boş bırakılamaz.";
    } else {
        try {
            // *** ÖNEMLİ DEĞİŞİKLİK: Doğrudan SQL sorgusu yerine saklı yordamı çağırıyoruz. ***
            // Proje isterlerine uygun olan yöntem budur.
            $stmt = $conn->prepare("CALL sp_kullanici_getir_by_username(:kullanici_adi)");
            
            // Parametreyi bağla
            $stmt->bindParam(':kullanici_adi', $kullanici_adi, PDO::PARAM_STR);
            
            // Yordamı çalıştır
            $stmt->execute();
            
            // Saklı yordamdan dönen sonucu al
            $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kullanıcının varlığını ve şifrenin doğruluğunu kontrol et
            // password_verify(), PHP'nin hashlenmiş şifreleri güvenli bir şekilde doğrulaması için kullanılır.
            if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
                
                // Güvenlik için giriş yapıldığında session ID'yi yenile (session fixation saldırılarını önler)
                session_regenerate_id(true);
                
                // Kullanıcı bilgilerini session'a kaydet
                $_SESSION['user_id'] = $kullanici['id'];
                $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];
                
                // Ana uygulama sayfasına yönlendir
                header("Location: randevu_listele.php");
                exit(); // Yönlendirmeden sonra betiği durdur
                
            } else {
                // Kullanıcı adı var mı yok mu gibi detay vermeden, genel bir hata mesajı ver.
                // Bu, "kullanıcı adı enumerasyon" saldırılarını zorlaştırır.
                $hata_mesaji = "Sağlanan bilgilerle eşleşen bir hesap bulunamadı.";
            }

        } catch (PDOException $e) {
            // Geliştirme aşamasında hatayı log dosyasına yazmak en iyisidir.
            error_log("Giriş Veritabanı Hatası: " . $e->getMessage()); 
            
            // Kullanıcıya her zaman genel bir hata mesajı göster
            $hata_mesaji = "VERİTABANI HATASI: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - VIP Kuaför Yönetimi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* CSS kodunuzda bir değişiklik yapılmasına gerek yok, olduğu gibi kalabilir. */
        :root {
            --bg-dark: #121212;
            --bg-card: #1f1f1f;
            --primary-text: #e0e0e0;
            --secondary-text: #a0a0a0;
            --accent-color: #c0a062; /* Muted gold/bronze */
            --border-color: #333333;
            --input-bg: #2a2a2a;
            --danger-bg: #3a1a1a;
            --danger-text: #d9a3a3;
            --danger-border: #5a2a2a;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--primary-text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background-color: var(--bg-card);
            padding: 35px 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header .icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .login-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--primary-text);
            margin-bottom: 5px;
        }
         .login-header p {
             color: var(--secondary-text);
             font-size: 0.95rem;
         }

        .form-floating label {
            color: var(--secondary-text);
        }

        .form-control {
            background-color: var(--input-bg);
            color: var(--primary-text);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.9rem 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            height: auto;
        }
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px var(--input-bg) inset !important;
            -webkit-text-fill-color: var(--primary-text) !important;
            caret-color: var(--primary-text);
        }

        .form-control:focus {
            background-color: var(--input-bg);
            color: var(--primary-text);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(192, 160, 98, 0.25);
            outline: none;
        }

         .form-floating > .form-control:focus ~ label,
         .form-floating > .form-control:not(:placeholder-shown) ~ label {
             color: var(--accent-color);
             opacity: 1;
             transform: scale(.85) translateY(-.5rem) translateX(.15rem);
         }
         .form-floating > .form-control:-webkit-autofill ~ label {
             color: var(--accent-color);
              opacity: 1;
              transform: scale(.85) translateY(-.5rem) translateX(.15rem);
         }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 4px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #a88a53;
            border-color: #a88a53;
            color: #fff;
            box-shadow: 0 2px 8px rgba(192, 160, 98, 0.3);
        }

        .alert-danger {
            color: var(--danger-text);
            background-color: var(--danger-bg);
            border-color: var(--danger-border);
            padding: 0.8rem 1rem;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .extra-links {
            text-align: center;
            margin-top: 25px;
            font-size: 0.9rem;
        }

        .extra-links a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .extra-links a:hover {
            color: #d4b88a;
            text-decoration: underline;
        }
        .extra-links span {
            color: var(--secondary-text);
        }

    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <div class="icon">
                <i class="fas fa-cut"></i>
            </div>
            <h2>Yönetim Paneli Girişi</h2>
            <p>Devam etmek için lütfen giriş yapın.</p>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>

            <?php if ($hata_mesaji): ?>
                <div class="alert alert-danger" role="alert">
                   <i class="fas fa-exclamation-circle me-2"></i>
                   <?php echo htmlspecialchars($hata_mesaji); ?>
                </div>
            <?php endif; ?>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" placeholder="Kullanıcı Adınız" required value="<?php echo isset($_POST['kullanici_adi']) ? htmlspecialchars($_POST['kullanici_adi']) : ''; ?>">
                <label for="kullanici_adi">Kullanıcı Adı</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifreniz" required>
                <label for="sifre">Şifre</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-1"></i> Giriş Yap
            </button>

            <div class="extra-links">
                 <span>Hesabınız yok mu?</span> <a href="kaydol.php">Hemen Kaydolun</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
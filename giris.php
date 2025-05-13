<?php
// Should be the very first thing
session_start();

// If user is already logged in, redirect them away from login page
if (isset($_SESSION['kullanici_adi'])) {
    header("Location: randevu_listele.php"); // Or index.php or wherever your main dashboard is
    exit();
}


include 'baglanti.php'; // Veritabanı bağlantınızı içerir

$hata_mesaji = null; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use trim and handle potential missing keys gracefully
    $kullanici_adi = trim($_POST["kullanici_adi"] ?? '');
    $sifre = $_POST["sifre"] ?? ''; // Don't trim password initially

    if (empty($kullanici_adi) || empty($sifre)) {
         $hata_mesaji = "Kullanıcı adı ve şifre alanları boş bırakılamaz.";
    } else {
        try {
            $stmt = $conn->prepare("SELECT id, kullanici_adi, sifre FROM kullanicilar WHERE kullanici_adi = :kullanici_adi LIMIT 1");
            $stmt->bindParam(':kullanici_adi', $kullanici_adi, PDO::PARAM_STR);
            $stmt->execute();
            $kullanici = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify user exists and password is correct
            if ($kullanici && password_verify($sifre, $kullanici['sifre'])) {
                // Regenerate session ID upon login for security
                session_regenerate_id(true);
                // Store user identifier in session
                $_SESSION['user_id'] = $kullanici['id']; // Store ID as well if needed
                $_SESSION['kullanici_adi'] = $kullanici['kullanici_adi'];
                // Redirect to the main application page
                header("Location: randevu_listele.php");
                exit();
            } else {
                // Generic error message for security (don't reveal if username exists)
                $hata_mesaji = "Sağlanan bilgilerle eşleşen bir hesap bulunamadı.";
            }

        } catch (PDOException $e) {
            error_log("Login DB Error: " . $e->getMessage()); // Log the detailed error
            // Generic error message for the user
            $hata_mesaji = "Giriş işlemi sırasında bir sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.";
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
        /* Paste the VIP Dark Theme CSS Variables and Base Styles */
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
            /* Add success/warning if needed for other messages */
        }

        html, body {
            height: 100%; /* Ensure body takes full height */
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--bg-dark);
            color: var(--primary-text);
            line-height: 1.6;
            display: flex;
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            min-height: 100vh; /* Fallback for older browsers/flex issues */
            padding: 20px; /* Add some padding for smaller screens */
        }

        .login-container {
            width: 100%;
            max-width: 420px; /* Slightly wider for better spacing */
            background-color: var(--bg-card);
            padding: 35px 40px; /* More padding */
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5); /* Stronger shadow for depth */
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
            color: var(--secondary-text); /* Style floating label placeholder */
        }

        .form-control { /* General form control styling */
            background-color: var(--input-bg);
            color: var(--primary-text);
            border: 1px solid var(--border-color);
            border-radius: 4px;
            padding: 0.9rem 1rem; /* Adjust padding */
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            height: auto; /* Override default height if needed */
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

        /* Specific adjustment for floating labels */
         .form-floating > .form-control:focus ~ label,
         .form-floating > .form-control:not(:placeholder-shown) ~ label {
             color: var(--accent-color); /* Color of label when floating */
             opacity: 1;
             transform: scale(.85) translateY(-.5rem) translateX(.15rem);
         }
         .form-floating > .form-control:-webkit-autofill ~ label {
             color: var(--accent-color); /* Ensure autofill also triggers label color */
              opacity: 1;
              transform: scale(.85) translateY(-.5rem) translateX(.15rem);
         }


        .btn-primary { /* Primary button styling */
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff; /* White text on accent */
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 4px;
            transition: all 0.3s ease;
            width: 100%; /* Make button full width */
            margin-top: 10px; /* Space above button */
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: #a88a53; /* Darker shade of accent */
            border-color: #a88a53;
            color: #fff;
            box-shadow: 0 2px 8px rgba(192, 160, 98, 0.3);
        }

        .alert-danger { /* Custom danger alert */
            color: var(--danger-text);
            background-color: var(--danger-bg);
            border-color: var(--danger-border);
            padding: 0.8rem 1rem;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        .alert-danger .fa-exclamation-circle {
            margin-right: 8px;
            font-size: 1.1rem;
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
            color: #d4b88a; /* Lighter accent on hover */
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
                <i class="fas fa-cut"></i> <!-- Or fa-user-lock, fa-key -->
            </div>
            <h2>Yönetim Paneli Girişi</h2>
            <p>Devam etmek için lütfen giriş yapın.</p>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <?php if ($hata_mesaji): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                   <i class="fas fa-exclamation-circle flex-shrink-0 me-2"></i>
                   <div><?php echo htmlspecialchars($hata_mesaji); ?></div>
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
                 <!-- Add forgot password link if you have that functionality -->
                 <!-- <br><a href="sifre_sifirla.php">Şifremi Unuttum</a> -->
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
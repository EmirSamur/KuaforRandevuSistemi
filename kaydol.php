<?php
// Should be the very first thing
session_start();

// If user is already logged in, redirect them away from signup page
if (isset($_SESSION['kullanici_adi'])) {
    header("Location: randevu_listele.php"); // Or index.php
    exit();
}

include 'baglanti.php'; // Veritabanı bağlantınızı içerir

$hata_mesaji = null; // Initialize error message
$form_data = []; // To repopulate form on error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data, store for repopulation
    $form_data['ad'] = trim(filter_input(INPUT_POST, 'ad', FILTER_SANITIZE_STRING));
    $form_data['soyad'] = trim(filter_input(INPUT_POST, 'soyad', FILTER_SANITIZE_STRING));
    $form_data['kullanici_adi'] = trim(filter_input(INPUT_POST, 'kullanici_adi', FILTER_SANITIZE_STRING));
    $form_data['email'] = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $sifre = $_POST["sifre"] ?? ''; // Get raw password
    $sifre_tekrar = $_POST["sifre_tekrar"] ?? '';

    // --- Validation ---
    if (empty($form_data['ad']) || empty($form_data['soyad']) || empty($form_data['kullanici_adi']) || empty($form_data['email'])) {
         $hata_mesaji = "Lütfen tüm alanları doldurun.";
    } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
         $hata_mesaji = "Lütfen geçerli bir e-posta adresi girin.";
    } elseif (strlen($sifre) < 8) { // Add minimum password length check
         $hata_mesaji = "Şifre en az 8 karakter uzunluğunda olmalıdır.";
    } elseif ($sifre !== $sifre_tekrar) {
        $hata_mesaji = "Girilen şifreler birbiriyle eşleşmiyor.";
    } else {
        // All basic validation passed, proceed to database interaction

        // Hash the password securely
        $hashed_sifre = password_hash($sifre, PASSWORD_DEFAULT);

        try {
            // Check if username or email already exists (more robust than catching generic error)
            $checkStmt = $conn->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = :kullanici_adi OR email = :email LIMIT 1");
            $checkStmt->bindParam(':kullanici_adi', $form_data['kullanici_adi'], PDO::PARAM_STR);
            $checkStmt->bindParam(':email', $form_data['email'], PDO::PARAM_STR);
            $checkStmt->execute();

            if ($checkStmt->fetch()) {
                 $hata_mesaji = "Bu kullanıcı adı veya e-posta adresi zaten kullanımda.";
            } else {
                 // Username and email are unique, proceed with insertion
                $stmt = $conn->prepare("INSERT INTO kullanicilar (ad, soyad, kullanici_adi, email, sifre) VALUES (:ad, :soyad, :kullanici_adi, :email, :sifre)");
                $stmt->bindParam(':ad', $form_data['ad'], PDO::PARAM_STR);
                $stmt->bindParam(':soyad', $form_data['soyad'], PDO::PARAM_STR);
                $stmt->bindParam(':kullanici_adi', $form_data['kullanici_adi'], PDO::PARAM_STR);
                $stmt->bindParam(':email', $form_data['email'], PDO::PARAM_STR);
                $stmt->bindParam(':sifre', $hashed_sifre, PDO::PARAM_STR);
                $stmt->execute();

                // Get the ID of the newly inserted user
                $new_user_id = $conn->lastInsertId();

                // Automatically log the user in
                session_regenerate_id(true); // Prevent session fixation
                $_SESSION['user_id'] = $new_user_id;
                $_SESSION['kullanici_adi'] = $form_data['kullanici_adi'];

                // Redirect to the main application page
                header("Location: randevu_listele.php?status=registered"); // Add status for potential welcome message
                exit();
            }

        } catch (PDOException $e) {
            error_log("Registration DB Error: " . $e->getMessage() . " (Code: " . $e->getCode() . ")"); // Log detailed error
             // Catch specific duplicate entry error just in case the preliminary check fails or isn't atomic
            if ($e->getCode() == '23000' || $e->getCode() == 23000) {
                $hata_mesaji = "Bu kullanıcı adı veya e-posta adresi zaten kullanımda.";
            } else {
                // Generic error for other DB issues
                $hata_mesaji = "Kayıt işlemi sırasında bir sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kaydol - VIP Kuaför Yönetimi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Paste the EXACT SAME :root and base styles from giris.php */
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
            line-height: 1.6;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px 0; /* Add vertical padding for scroll */
        }

        .register-container {
            width: 100%;
            max-width: 500px; /* Wider for more fields */
            background-color: var(--bg-card);
            padding: 35px 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
            margin: 20px 0; /* Add margin top/bottom */
        }

        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .register-header .icon {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 10px;
        }

        .register-header h2 {
            font-family: 'Playfair Display', serif;
            font-size: 1.9rem;
            font-weight: 700;
            color: var(--primary-text);
            margin-bottom: 5px;
        }
         .register-header p {
             color: var(--secondary-text);
             font-size: 0.95rem;
         }

        /* --- Form Control Styling (Same as Login) --- */
        .form-floating label { color: var(--secondary-text); }
        .form-control {
            background-color: var(--input-bg); color: var(--primary-text);
            border: 1px solid var(--border-color); border-radius: 4px;
            padding: 0.9rem 1rem; transition: border-color 0.2s ease, box-shadow 0.2s ease;
            height: auto;
        }
        .form-control:-webkit-autofill,
        .form-control:-webkit-autofill:hover,
        .form-control:-webkit-autofill:focus,
        .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px var(--input-bg) inset !important;
            -webkit-text-fill-color: var(--primary-text) !important; caret-color: var(--primary-text);
        }
        .form-control:focus {
            background-color: var(--input-bg); color: var(--primary-text);
            border-color: var(--accent-color); box-shadow: 0 0 0 0.2rem rgba(192, 160, 98, 0.25);
            outline: none;
        }
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
             color: var(--accent-color); opacity: 1;
             transform: scale(.85) translateY(-.5rem) translateX(.15rem);
        }
         .form-floating > .form-control:-webkit-autofill ~ label {
             color: var(--accent-color); opacity: 1;
              transform: scale(.85) translateY(-.5rem) translateX(.15rem);
         }
        /* --- End Form Control --- */

        /* --- Button Styling (Same as Login) --- */
        .btn-primary {
            background-color: var(--accent-color); border-color: var(--accent-color); color: #fff;
            padding: 0.75rem 1.5rem; font-weight: 500; text-transform: uppercase;
            letter-spacing: 0.5px; border-radius: 4px; transition: all 0.3s ease;
            width: 100%; margin-top: 10px;
        }
        .btn-primary:hover, .btn-primary:focus {
            background-color: #a88a53; border-color: #a88a53; color: #fff;
            box-shadow: 0 2px 8px rgba(192, 160, 98, 0.3);
        }
        /* --- End Button --- */

        /* --- Alert Styling (Same as Login) --- */
        .alert-danger {
            color: var(--danger-text); background-color: var(--danger-bg);
            border-color: var(--danger-border); padding: 0.8rem 1rem;
            border-radius: 4px; margin-bottom: 20px; font-size: 0.9rem;
            display: flex; align-items: center;
        }
        .alert-danger .fa-exclamation-circle { margin-right: 8px; font-size: 1.1rem; }
        /* --- End Alert --- */

        /* --- Links Styling (Same as Login) --- */
        .extra-links { text-align: center; margin-top: 25px; font-size: 0.9rem; }
        .extra-links a { color: var(--accent-color); text-decoration: none; font-weight: 500; transition: color 0.2s ease; }
        .extra-links a:hover { color: #d4b88a; text-decoration: underline; }
        .extra-links span { color: var(--secondary-text); }
        /* --- End Links --- */

    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Yeni Hesap Oluştur</h2>
            <p>Sisteme erişmek için bilgilerinizi girin.</p>
        </div>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

            <?php if ($hata_mesaji): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                   <i class="fas fa-exclamation-circle flex-shrink-0 me-2"></i>
                   <div><?php echo htmlspecialchars($hata_mesaji); ?></div>
                </div>
            <?php endif; ?>

             <div class="row g-2 mb-3">
                <div class="col-md">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="ad" name="ad" placeholder="Adınız" required value="<?php echo htmlspecialchars($form_data['ad'] ?? ''); ?>">
                        <label for="ad">Ad</label>
                    </div>
                </div>
                <div class="col-md">
                     <div class="form-floating">
                        <input type="text" class="form-control" id="soyad" name="soyad" placeholder="Soyadınız" required value="<?php echo htmlspecialchars($form_data['soyad'] ?? ''); ?>">
                        <label for="soyad">Soyad</label>
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" placeholder="Kullanıcı Adı" required value="<?php echo htmlspecialchars($form_data['kullanici_adi'] ?? ''); ?>">
                <label for="kullanici_adi">Kullanıcı Adı</label>
            </div>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="E-posta Adresiniz" required value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>">
                <label for="email">E-posta</label>
            </div>

            <div class="row g-2 mb-4">
                 <div class="col-md">
                    <div class="form-floating">
                        <input type="password" class="form-control" id="sifre" name="sifre" placeholder="Şifre (min. 8 karakter)" required>
                        <label for="sifre">Şifre</label>
                    </div>
                 </div>
                 <div class="col-md">
                     <div class="form-floating">
                        <input type="password" class="form-control" id="sifre_tekrar" name="sifre_tekrar" placeholder="Şifre Tekrar" required>
                        <label for="sifre_tekrar">Şifre Tekrar</label>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-circle me-1"></i> Kaydol
            </button>

            <div class="extra-links">
                 <span>Zaten bir hesabınız var mı?</span> <a href="giris.php">Giriş Yapın</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
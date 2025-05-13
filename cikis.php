<?php
/**
 * cikis.php - Kullanıcı Oturumunu Sonlandırma Script'i
 *
 * Bu script, mevcut kullanıcı oturumunu güvenli bir şekilde sonlandırır
 * ve kullanıcıyı giriş sayfasına yönlendirir.
 */

// 1. Oturum yönetimini başlat
// Bu, oturum değişkenlerine erişmek ve onları yok etmek için gereklidir.
// Sayfanın *en başında*, hiçbir çıktıdan önce çağrılmalıdır.
session_start();

// 2. Tüm oturum değişkenlerini temizle
// $_SESSION süper global dizisindeki tüm anahtarları kaldırır.
// Örneğin, $_SESSION['kullanici_adi'], $_SESSION['user_id'] vb. silinir.
session_unset();

// 3. Oturumu tamamen yok et
// Sunucudaki oturum dosyasını ve ilgili verileri siler.
// Ayrıca, genellikle tarayıcıdaki oturum çerezini de geçersiz kılar (ancak
// çerezin tamamen silinmesi tarayıcıya bağlıdır).
session_destroy();

// 4. Kullanıcıyı giriş sayfasına yönlendir
// Çıkış işlemi tamamlandıktan sonra kullanıcıyı tekrar giriş yapabileceği
// sayfaya göndeririz.
// "?status=loggedout" parametresi, giriş sayfasında isteğe bağlı olarak
// "Başarıyla çıkış yapıldı" mesajı göstermek için kullanılabilir.
header("Location: giris.php?status=loggedout");

// 5. Yönlendirmeden sonra script'in çalışmasını durdur
// header() yönlendirmesinin hemen ardından exit() veya die() kullanmak,
// script'in geri kalanının gereksiz yere çalışmasını önlemek için önemlidir.
exit();
?>
<?php
// Veritabanı bağlantısını dahil et
include 'database/connection.php';

// Silinecek kullanıcının id'sini al
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Kullanıcıyı silme sorgusunu hazırla
    $sql = "DELETE FROM users WHERE id = :id";

    // Sorguyu hazırla ve çalıştır
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        // Başarılı bir şekilde silindiyse kullanıcı listesi sayfasına yönlendir
        header('Location: kullanici_listesi.php');
        exit;
    } else {
        // Silme işlemi başarısızsa hata mesajını göster
        echo "Kullanıcı silinirken bir hata oluştu.";
    }
} else {
    // ID belirtilmediyse hata mesajı göster
    echo "Geçersiz kullanıcı ID.";
}
?>

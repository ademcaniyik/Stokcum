# Stokcum - Envanter Yönetim Sistemi

Stokcum, depo ve envanter yönetimini kolaylaştırmak için geliştirilmiş bir sistemdir. Bu sistem ile ürünlerin takibini yapabilir, sipariş verebilir ve kullanıcı seviyesine özel farklı görünümler sunabilirsiniz.

## Özellikler

### Kullanıcı Girişi ve Yetkilendirme
- Farklı kullanıcı rolleri için yetkilendirme mekanizması.
- Kullanıcının yetkisi olmayan yerlere erişimin engellenmesi.

### Ürün Yönetimi
- Ürün ekleme, güncelleme ve silme işlemleri.
- Ürün barkodu, kategori, tedarikçi ve diğer bilgilerin yönetimi.

### Stok Takibi
- Stok giriş ve çıkış işlemlerinin kaydedilmesi.
- Mevcut stok seviyelerinin anlık takibi.

### Tedarikçi Yönetimi
- Tedarikçi bilgilerinin kaydedilmesi ve yönetimi.

### Sipariş Yönetimi
- Gelen ve giden siparişlerin yönetimi ve takibi.
- Sipariş oluşturma ve geçmiş siparişleri görüntüleme.

### Raporlama
- Stok durumu, satış raporları ve envanter hareketleri gibi bilgilerin raporlanması.
- Raporların PDF formatında çıktı alınabilmesi.

### Bildirim Sistemi
- Kritik stok seviyelerine ulaşıldığında kullanıcıların bilgilendirilmesi.

## Teknolojik Altyapı
- **Programlama Dili:** PHP
- **Veritabanı Yönetim Sistemi:** MySQL (phpMyAdmin ile yönetilmektedir)
- **Web Teknolojileri:** HTML, CSS, JavaScript, PHP
- **Framework:** Laravel veya CodeIgniter (gerekli olması durumunda)

## Kurulum ve Kullanım

### 1. Projeyi İndirin
Projeyi bilgisayarınıza indirin ve gerekli dosyaları ayıklayın.

### 2. Veritabanı Kurulumu
phpMyAdmin kullanarak MySQL veritabanınızı kurun:
1. phpMyAdmin'e gidin ve yeni bir veritabanı oluşturun.
2. Proje ile birlikte gelen veritabanı dosyasını (örneğin, `database.sql`) phpMyAdmin aracılığıyla içe aktarın.
3. Veritabanı tabloları ve başlangıç verileri bu dosyada bulunacaktır.

### 3. Veritabanı Bağlantısı
`connection.php` dosyasındaki veritabanı bağlantı bilgilerini kendi bilgilerinizle değiştirin. Örneğin:
<?php
$servername = "localhost";
$username = "kullanici_adi";
$password = "sifre";
$dbname = "veritabani_adi";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
# Statik İçerikleri Düzenleyin

1. **index.php** dosyasındaki kategori resimleri ve logonuzu düzenleyin.

2. **Ürün Ekleme ve Güncelleme:**
   - Ürün ekleme ve güncelleme işlemleri için **urun-duzenle.php** dosyasını kullanın. Bu sayfaya soldaki sidebar menüsünden erişebilirsiniz.

3. **Kullanıcı Girişi:**
   - İlk defa giriş yapacak kullanıcılar için, admin düzeyinde giriş bilgileri:
     - Kullanıcı Adı: admin
     - Şifre: ademcan

## Modüller

### Ürün Yönetimi
- Ürün ekleme, güncelleme ve silme işlemleri.
- Ürünlerin kategori ve tedarikçi bilgileri ile birlikte yönetimi.

### Stok Takibi
- Anlık stok durumunun takibi.
- Stok giriş ve çıkış işlemlerinin kaydedilmesi.

### Sipariş Yönetimi
- Yeni sipariş oluşturma.
- Aktif ve geçmiş siparişlerin takibi.

### Tedarikçi Yönetimi
- Tedarikçi ekleme, güncelleme ve silme işlemleri.

### Raporlama
- Ürün, satış ve sipariş raporları oluşturma.
- Raporların PDF formatında çıktı alınabilmesi.

### Bildirim Sistemi
- Kritik stok seviyelerine ulaşıldığında kullanıcıların bilgilendirilmesi.

## Ekran Görüntüleri

### Giriş Ekranı
Kullanıcıların sisteme giriş yapabilecekleri basit bir login ekranı.

### Dashboard
Kullanıcıları karşılayan ana ekran. Stok, satış ve sipariş bilgilerini özetler.

### Ürünler
Ürün görüntüleme, düzenleme ve ekleme sayfaları.

### Satışlar
Satış yapma, düzenleme ve satış raporları sayfaları.

### Siparişler
Sipariş oluşturma, aktif ve geçmiş siparişleri görüntüleme sayfaları.

### Tedarikçiler
Tedarikçi görüntüleme ve düzenleme sayfaları.

### Stok
Stok görüntüleme ve düzenleme sayfaları.

### Kullanıcı İşlemleri
Kullanıcı ekleme, düzenleme ve yetkilendirme işlemleri.

### Bildirimler
Kullanıcılara kritik stok seviyelerinde bildirim gönderme.

## Veritabanı Yapısı

- **Kullanıcılar:** Kullanıcı bilgileri ve yetki seviyeleri.
- **Ürünler:** Ürün bilgileri, kategoriler ve tedarikçiler.
- **Stok:** Stok giriş ve çıkış işlemleri.
- **Siparişler:** Sipariş bilgileri ve durumları.
- **Satışlar:** Satış bilgileri ve gelirler.

## Lisans

Bu proje MIT lisansı ile lisanslanmıştır. Daha fazla bilgi için LICENSE dosyasını inceleyin.

<?php
include "sidebar.php";
include 'database/connection.php';

$categories = [];
try {
    $stmt = $conn->prepare("SELECT id, name FROM categories");
    $stmt->execute();
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($categories)) {
        echo "Kategoriler bulunamadı.";
    }
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
$suppliers = [];
try {
    $stmt = $conn->prepare("SELECT id, supplier_name FROM suppliers");
    $stmt->execute();
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($suppliers)) {
        echo "Tedarikçiler bulunamadı.";
    }
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="assets/font-awesome.min.css" rel="stylesheet">
    <link href="assets/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
    <style>
        .custom-form-group {
            display: flex;
            align-items: center;
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel</title>

    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Ürün Ekle</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Ürünler</a></li>
                                <li class="active">Ürün Listesi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-content">
                <div class="row">
                    <!-- Ürün Ekleme Bölümü -->
                    <div class="col-lg-12"  >
                        <div class="card alert">
                            <div class="card-header">
                                <h4>Ürün Ekle</h4>
                            </div>
                            <div class="card-body">
                                <div class="menu-upload-form">
                                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ürün Adı</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="urun_ad" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ürün Miktar</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="urun_miktar" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ürün Alış Fiyat</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="urun_alis_fiyat" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ürün Satış Fiyat</label>
                                            <div class="col-sm-10">
                                                <input type="number" name="urun_satis_fiyat" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group custom-form-group">
                                            <label class="col-sm-2 control-label">Ürün Kategorisi</label>
                                            <div class="col-sm-10">
                                                <select name="kategori_id" class="form-control">
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Tedarikçi</label>
                                            <div class="col-sm-10">
                                                <select name="tedarikci_id" class="form-control">
                                                    <?php foreach ($suppliers as $supplier): ?>
                                                        <option value="<?= htmlspecialchars($supplier['id']) ?>"><?= htmlspecialchars($supplier['supplier_name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ürün Barkodu</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="urun_barkod" id="urun_barkod" class="form-control">
                                                <small id="barkod_hata_mesaji" style="color:red;"></small> <!-- Hata mesajı için küçük bir element ekleyelim -->
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Ürün Resmi</label>
                                            <div class="col-sm-10">
                                                <div class="form-control file-input dark-browse-input-box">
                                                    <input type="file" name="urun_resim" accept="image/*">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" name="ekle" class="btn btn-lg btn-primary">Ekle</button>
                                            </div>
                                        </div>
                                    </form><br>
                                    <?php
                                    // Ürün ekleme işlemi
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ekle'])) {
                                        // Diğer form alanlarını aldıktan sonra
                                        // Formdan gelen verileri al
                                        $urun_ad = $_POST['urun_ad'];
                                        $urun_miktar = $_POST['urun_miktar'];
                                        $urun_alis_fiyat = $_POST['urun_alis_fiyat'];
                                        $urun_satis_fiyat = $_POST['urun_satis_fiyat'];
                                        $kategori_id = $_POST['kategori_id'];
                                        $urun_barkod = $_POST['urun_barkod'];
                                        $tedarikci_id = $_POST['tedarikci_id'];
                                        $date = date('Y-m-d H:i:s');

                                        // Ürün adını kullanarak dosya adını oluştur
                                        $dosyaAdi = strtolower(str_replace(' ', '_', $urun_ad)); // Boşlukları alt tire ile değiştir
                                        $dosyaAdi = preg_replace('/[^A-Za-z0-9_\-]/', '', $dosyaAdi); // Özel karakterleri kaldır
                                        $dosyaAdi = $dosyaAdi . '.jpg'; // veya .png veya .jpeg olarak değiştir

                                        // Resmi yükleme ve yeni adla kaydetme
                                        $resim_yolu = "yuklenen_resimler/" . $dosyaAdi;
                                        move_uploaded_file($_FILES["urun_resim"]["tmp_name"], $resim_yolu);

                                        try {
                                            // Veritabanına ürünü ekleme işlemi
                                            $sql = "INSERT INTO products (product_barkod, name, quantity, buy_price, sale_price, categorie_id, date, product_img_url, supplier_id) 
                        VALUES (:product_barkod, :name, :quantity, :buy_price, :sale_price, :categorie_id, :date, :product_img_url, :supplier_id)";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':product_barkod', $urun_barkod);
                                            $stmt->bindParam(':supplier_id', $tedarikci_id);
                                            $stmt->bindParam(':name', $urun_ad);
                                            $stmt->bindParam(':quantity', $urun_miktar);
                                            $stmt->bindParam(':buy_price', $urun_alis_fiyat);
                                            $stmt->bindParam(':sale_price', $urun_satis_fiyat);
                                            $stmt->bindParam(':categorie_id', $kategori_id);
                                            $stmt->bindParam(':date', $date);

                                            // Dosya adını ve yolu veritabanına kaydet
                                            $stmt->bindParam(':product_img_url', $dosyaAdi);

                                            $stmt->execute();

                                            echo "Ürün başarıyla eklendi.";

                                        } catch (Exception $e) {
                                            // Hata durumunda yapılacak işlemler
                                            echo "Hata: " . $e->getMessage();
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Ürün Silme Bölümü -->
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4>Ürün Sil</h4>
                            </div>
                            <div class="card-body">
                                <div class="menu-upload-form">
                                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                        <div class="form-group custom-form-group">
                                            <label class="col-sm-2 control-label">Ürün Kategorisi</label>
                                            <div class="col-sm-10">
                                                <select name="kategori_id_listele" class="form-control">
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-lg btn-primary" name="listele">Listele</button>
                                            </div>
                                        </div>
                                    </form><br>

                                    <?php
                                    // Ürünleri listeleme işlemi
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['listele'])) {
                                        $kategori_id = $_POST['kategori_id_listele'];

                                        try {
                                            // Veritabanından ürünleri getirme işlemi
                                            $sql = "SELECT id, product_barkod, name, quantity, buy_price, sale_price, categorie_id, date FROM products WHERE categorie_id = :kategori_id";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':kategori_id', $kategori_id);
                                            $stmt->execute();
                                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            if (count($results) > 0) {
                                                foreach ($results as $row) {
                                                    $productBarkod = htmlspecialchars($row["product_barkod"]);
                                                    $productName = htmlspecialchars($row["name"]);
                                                    $quantity = htmlspecialchars($row["quantity"]);
                                                    $buyPrice = isset($row["buy_price"]) ? htmlspecialchars($row["buy_price"]) : 'N/A';
                                                    $salePrice = isset($row["sale_price"]) ? htmlspecialchars($row["sale_price"]) : 'N/A';
                                                    $categorieId = htmlspecialchars($row["categorie_id"]);
                                                    $date = isset($row["date"]) ? htmlspecialchars($row["date"]) : 'N/A';
                                                    $productId = htmlspecialchars($row["id"]);

                                                    // Ürün resminin dosya yolunu oluştur
                                                    $productImageUrl = "yuklenen_resimler/" . $productName . '.jpg';

                                                    // Resmin varlığını kontrol et
                                                    if (file_exists($productImageUrl)) {
                                                        // Ürünleri tablo içinde listele
                                                        echo '<div class="col-lg-4 col-6">';
                                                        echo '<div class="menu-item menu-grid-item">';
                                                        echo '<img src="' . $productImageUrl . '" alt="' . $productName . '" width="250" height="250">';
                                                        echo "<h6 class='mb-06'>" . $productName . "</h6>"; // Ürün ismini <h6> etiketleri arasında yazdır
                                                        echo '<div class="row align-items-center mt-4">';
                                                        echo '<form method="POST" action="">';
                                                        echo '<input type="hidden" name="urun_id_sil" value="' . $productId . '">';
                                                        echo '<button type="submit" class="btn btn-danger btn-flat btn-md" name="sil">Sil</button>';
                                                        echo '</form>';
                                                        echo '</div>';
                                                        echo '<br></div>';
                                                        echo '</div>';
                                                    } else {
                                                        echo "";
                                                    }
                                                }
                                            } else {
                                                echo "<tr><td colspan='8'>Veri bulunamadı</td></tr>";
                                            }
                                        } catch (Exception $e) {
                                            echo "Listeleme hatası: " . $e->getMessage();
                                        }
                                    }

                                    // Silme işlemi
                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sil"])) {
                                        $urun_id_sil = isset($_POST["urun_id_sil"]) ? $_POST["urun_id_sil"] : '';

                                        try {
                                            // Silme işlemi SQL sorgusu
                                            $sql_sil = "DELETE FROM products WHERE id = :urun_id";
                                            $stmt_sil = $conn->prepare($sql_sil);
                                            $stmt_sil->bindParam(':urun_id', $urun_id_sil);
                                            $stmt_sil->execute();

                                            echo "Ürün başarıyla silindi!";
                                        } catch (Exception $e) {
                                            echo "Silme hatası: " . $e->getMessage();
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ürün Güncelleme Bölümü -->
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4>Ürün Güncelle</h4>
                            </div>
                            <div class="card-body">
                                <div class="menu-upload-form">
                                    <form class="form-horizontal" action="#" method="post" enctype="multipart/form-data">
                                        <div class="form-group custom-form-group">
                                            <label class="col-sm-2 control-label">Ürün Kategorisi</label>
                                            <div class="col-sm-10">
                                                <select name="kategori_id_guncelle" class="form-control">
                                                    <?php foreach ($categories as $category): ?>
                                                        <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-lg btn-primary" name="listele_guncelle">Listele</button>
                                            </div>
                                        </div>
                                    </form><br>
                                    <?php
                                    // Fetch suppliers to populate the dropdown
                                    try {
                                        $sql = "SELECT id, supplier_name FROM suppliers";
                                        $stmt = $conn->prepare($sql);
                                        $stmt->execute();
                                        $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    } catch (Exception $e) {
                                        echo "Tedarikçi listesi hatası: " . $e->getMessage();
                                    }

                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['listele_guncelle'])) {
                                        $kategori_id = $_POST['kategori_id_guncelle'];

                                        try {
                                            $sql = "SELECT p.id, p.product_barkod, p.name, p.quantity, p.buy_price, p.sale_price, p.categorie_id, p.product_img_url, p.supplier_id FROM products p WHERE p.categorie_id = :kategori_id";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':kategori_id', $kategori_id);
                                            $stmt->execute();
                                            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            if (count($results) > 0) {
                                                foreach ($results as $row) {
                                                    $productId = htmlspecialchars($row["id"]);
                                                    $productBarkod = htmlspecialchars($row["product_barkod"]);
                                                    $productName = htmlspecialchars($row["name"]);
                                                    $quantity = htmlspecialchars($row["quantity"]);
                                                    $buyPrice = htmlspecialchars($row["buy_price"]);
                                                    $salePrice = htmlspecialchars($row["sale_price"]);
                                                    $categorieId = htmlspecialchars($row["categorie_id"]);
                                                    $productImgUrl = htmlspecialchars($row["product_img_url"]);
                                                    $supplierId = htmlspecialchars($row["supplier_id"]);

                                                    echo '<div class="col-lg-12">';
                                                    echo '<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Ürün Barkod</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<input type="text" name="urun_barkod_guncelle" class="form-control" value="'.$productBarkod.'">';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Ürün Adı</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<input type="text" name="urun_ad_guncelle" class="form-control" value="'.$productName.'">';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Ürün Miktar</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<input type="text" name="urun_miktar_guncelle" class="form-control" value="'.$quantity.'">';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Alış Fiyatı</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<input type="text" name="urun_alis_fiyat_guncelle" class="form-control" value="'.$buyPrice.'">';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Satış Fiyatı</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<input type="text" name="urun_satis_fiyat_guncelle" class="form-control" value="'.$salePrice.'">';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Ürün Resim</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<input type="file" name="urun_resim_guncelle" class="form-control">';
                                                    echo '<input type="hidden" name="current_img_url" value="'.$productImgUrl.'">';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Kategori</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<select name="kategori_id_guncelleme" class="form-control">';
                                                    foreach ($categories as $category) {
                                                        $selected = ($category['id'] == $categorieId) ? 'selected' : '';
                                                        echo '<option value="'.htmlspecialchars($category['id']).'" '.$selected.'>'.htmlspecialchars($category['name']).'</option>';
                                                    }
                                                    echo '</select>';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<label class="col-sm-2 control-label">Tedarikçi</label>';
                                                    echo '<div class="col-sm-10">';
                                                    echo '<select name="supplier_id_guncelleme" class="form-control">';
                                                    foreach ($suppliers as $supplier) {
                                                        $selected = ($supplier['id'] == $supplierId) ? 'selected' : '';
                                                        echo '<option value="'.htmlspecialchars($supplier['id']).'" '.$selected.'>'.htmlspecialchars($supplier['supplier_name']).'</option>';
                                                    }
                                                    echo '</select>';
                                                    echo '</div></div>';
                                                    echo '<div class="form-group">';
                                                    echo '<div class="col-sm-offset-2 col-sm-10">';
                                                    echo '<input type="hidden" name="urun_id_guncelle" value="'.$productId.'">';
                                                    echo '<button type="submit" class="btn btn-lg btn-primary" name="guncelle">Güncelle</button>';
                                                    echo '</div></div>';
                                                    echo '</form>';
                                                    echo '</div>';
                                                }
                                            } else {
                                                echo "Güncellenecek veri bulunamadı.";
                                            }
                                        } catch (Exception $e) {
                                            echo "Listeleme hatası: " . $e->getMessage();
                                        }
                                    }

                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["guncelle"])) {
                                        $urun_id = $_POST["urun_id_guncelle"];
                                        $urun_barkod = $_POST["urun_barkod_guncelle"];
                                        $urun_ad = $_POST["urun_ad_guncelle"];
                                        $urun_miktar = $_POST["urun_miktar_guncelle"];
                                        $urun_alis_fiyat = $_POST["urun_alis_fiyat_guncelle"];
                                        $urun_satis_fiyat = $_POST["urun_satis_fiyat_guncelle"];
                                        $kategori_id = $_POST["kategori_id_guncelleme"];
                                        $supplier_id = $_POST["supplier_id_guncelleme"];

                                        // Dosya yükleme işlemi
                                        if ($_FILES["urun_resim_guncelle"]["error"] == UPLOAD_ERR_OK) {
                                            $tmp_name = $_FILES["urun_resim_guncelle"]["tmp_name"];
                                            $name = basename($_FILES["urun_resim_guncelle"]["name"]);
                                            $uploads_dir = 'yuklenen_resimler';
                                            move_uploaded_file($tmp_name, "$uploads_dir/$name");
                                            $urun_resim_yolu = "$uploads_dir/$name";
                                        } else {
                                            $urun_resim_yolu = $_POST["current_img_url"];
                                        }

                                        try {
                                            // Ürün tablosunu güncelle
                                            $sql = "UPDATE products SET product_barkod = :barkod, name = :name, quantity = :quantity, buy_price = :buy_price, sale_price = :sale_price, product_img_url = :product_img_url, categorie_id = :categorie_id, supplier_id = :supplier_id WHERE id = :id";
                                            $stmt = $conn->prepare($sql);
                                            $stmt->bindParam(':barkod', $urun_barkod);
                                            $stmt->bindParam(':name', $urun_ad);
                                            $stmt->bindParam(':quantity', $urun_miktar);
                                            $stmt->bindParam(':buy_price', $urun_alis_fiyat);
                                            $stmt->bindParam(':sale_price', $urun_satis_fiyat);
                                            $stmt->bindParam(':product_img_url', $urun_resim_yolu);
                                            $stmt->bindParam(':categorie_id', $kategori_id);
                                            $stmt->bindParam(':supplier_id', $supplier_id);
                                            $stmt->bindParam(':id', $urun_id);

                                            $stmt->execute();

                                            echo "Ürün başarıyla güncellendi!";
                                        } catch (Exception $e) {
                                            echo "Güncelleme hatası: " . $e->getMessage();
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Input alanındaki değeri değiştikçe kontrol etmek için bir fonksiyon tanımlayalım
            document.getElementById("urun_barkod").addEventListener("input", function() {
                var barkod = this.value; // Input alanındaki değeri al
                var hata_mesaji = document.getElementById("barkod_hata_mesaji"); // Hata mesajını temsil eden elementi al

                // Barkodun 8 haneli olup olmadığını ve sadece rakamlardan oluştuğunu kontrol et
                if (barkod.length !== 8 || isNaN(barkod)) {
                    hata_mesaji.textContent = "Barkod 8 haneli ve sayısal olmalıdır."; // Hata mesajını göster
                } else {
                    hata_mesaji.textContent = ""; // Hata mesajını temizle
                }
            });
        </script>

        <!-- jquery vendor -->
        <script src="assets/js/lib/jquery.min.js"></script>
        <script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
        <!-- nano scroller -->
        <script src="assets/js/lib/menubar/sidebar.js"></script>
        <script src="assets/js/lib/preloader/pace.min.js"></script>
        <!-- sidebar -->
        <script src="assets/js/lib/bootstrap.min.js"></script>
        <!-- bootstrap -->
        <script src="assets/js/lib/mmc-common.js"></script>
        <script src="assets/js/lib/mmc-chat.js"></script>
        <script src="assets/js/scripts.js"></script>
        <!-- script init-->
</body>
</html>
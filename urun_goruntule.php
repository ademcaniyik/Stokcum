<?php
include('database/connection.php');

// SQL sorgusu: products tablosunu categories tablosuyla birleştirerek kategori adını alın
$sql = "SELECT p.id, p.product_barkod, p.name, p.quantity, p.buy_price, p.sale_price, p.date, c.name as category_name, s.supplier_name 
        FROM products p 
        JOIN categories c ON p.categorie_id = c.id
        JOIN suppliers s ON p.supplier_id = s.id"; // suppliers tablosunu da birleştir
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en" class="dark">
<?php include "sidebar.php"; ?>
<head>
    <style>
        input[type="text"] {
            color: #000000; /* Silik metin rengi */
        }
        .sag-sifirlama {
            margin-right: 0;
            padding-right: 0;
        }
        #dosyaSecilmemis {
            display: none; /* Başlangıçta gizlenmiş */
        }
    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ürün Görüntüleme</title>

    <!-- Styles -->
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
                            <h1>Ürün Listesi</h1>
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
            <div id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header pr">
                                <h4>Tüm Ürünler</h4>
                                <div class="search-action">
                                    <!-- Arama giriş alanları buraya gelecek -->
                                </div>
                                <div class="card-header-right-icon">
                                    <!-- Kart başlık simgeleri buraya gelecek -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table product-data-table m-t-20">
                                        <thead>
                                        <tr>
                                            <th>Ürün Barkod</th>
                                            <th>Ürün Adı</th>
                                            <th>Ürün Miktarı</th>
                                            <th>Alış Fiyatı</th>
                                            <th>Satış Fiyatı</th>
                                            <th>Kategori</th>
                                            <th>Tedarikçi</th>
                                            <th>Eklenme tarihi</th>
                                            <th>Resim</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                <?php
                                // Veritabanından ürünleri çekme ve listeleme işlemi
                                if (count($results) > 0) {
                                    foreach ($results as $row) {
                                        $productBarkod = htmlspecialchars($row["product_barkod"]);
                                        $productName = htmlspecialchars($row["name"]);
                                        $quantity = htmlspecialchars($row["quantity"]);
                                        $buyPrice = isset($row["buy_price"]) ? htmlspecialchars($row["buy_price"]) : 'N/A';
                                        $salePrice = isset($row["sale_price"]) ? htmlspecialchars($row["sale_price"]) : 'N/A';
                                        $categoryName = htmlspecialchars($row["category_name"]);
                                        $supplierName = htmlspecialchars($row["supplier_name"]); // Yeni eklenen tedarikçi adı
                                        $date = isset($row["date"]) ? htmlspecialchars($row["date"]) : 'N/A';
                                        $productId = htmlspecialchars($row["id"]);

                                        // Ürün adından uygun bir dosya adı oluştur
                                        $imageName = strtolower(str_replace(' ', '_', $productName)); // Boşlukları alt tire ile değiştir
                                        $imageName = preg_replace('/[^A-Za-z0-9_\-]/', '', $imageName); // Özel karakterleri kaldır
                                        $imageName = $imageName . '.jpg'; // veya .png veya .jpeg olarak değiştir

                                        // Ürünün resim yolunu belirle
                                        $productImageUrl = "yuklenen_resimler/" . $imageName;

                                        // Resmin varlığını kontrol et
                                        if (file_exists($productImageUrl)) {
                                            // Ürünleri tablo içinde listele
                                            echo "<tr>";
                                            echo "<td>{$productBarkod}</td>";
                                            echo "<td>{$productName}</td>";
                                            echo "<td>{$quantity}</td>";
                                            echo "<td>{$buyPrice}</td>";
                                            echo "</td>";
                                            echo "<td>{$salePrice}</td>";
                                            echo "<td>{$categoryName}</td>";
                                            echo "<td>{$supplierName}</td>"; // Yeni eklenen tedarikçi adı sütunu
                                            echo "<td>{$date}</td>";
                                            echo '<td><img src="' . $productImageUrl . '" alt="' . $productName . '" width="250" height="250"></td>';
                                            echo "</tr>";
                                        } else {
                                            // Resim yoksa
                                            // Ürün bilgilerini tablo içinde listele
                                            echo "<tr>";
                                            echo "<td>{$productBarkod}</td>";
                                            echo "<td>{$productName}</td>";
                                            echo "<td>{$quantity}</td>";
                                            echo "<td>{$buyPrice}</td>";
                                            echo "<td>{$salePrice}</td>";
                                            echo "<td>{$categoryName}</td>";
                                            echo "<td>{$supplierName}</td>"; // Yeni eklenen tedarikçi adı sütunu
                                            echo "<td>{$date}</td>";
                                            echo '<td><img src="yuklenen_resimler/default_product.jpg" alt="Varsayılan Resim" width="250" height="250"></td>';
                                            echo "</tr>";
                                        }
                                    }
                                } else {
                                    // Ürün yoksa
                                    echo "<tr><td colspan='9'>Ürün bulunamadı.</td></tr>";
                                }
                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="assets/js/lib/rating1/jRate.min.js"></script>
<!-- scripit init-->
<script src="assets/js/lib/rating1/jRate.init.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>

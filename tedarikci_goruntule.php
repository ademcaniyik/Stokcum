<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: giris.php');
    exit;
}

$user = $_SESSION['user'];
?>
<?php
include "database/connection.php";
$sql = "SELECT supplier_name, supplier_location, email, suppliers_pp FROM suppliers";
$stmt = $conn->prepare($sql);
$stmt->execute();
$suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
include "sidebar.php";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link href="assets/css/lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="assets/css/lib/weather-icons.css" rel="stylesheet" />
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
                            <h1>Tedarikçiler</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Tedarikçi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content">
                <div class="row">
                    <?php foreach ($suppliers as $supplier) : ?>
                        <div class="col-lg-6">
                            <div class="card alert">
                                <div class="card-body">
                                    <div class="user-profile">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <?php
                                                // Tedarikçi adı ile uygun bir dosya adı oluştur
                                                $supplierName = htmlspecialchars($supplier['supplier_name']);
                                                $imageName = strtolower(str_replace(' ', '_', $supplierName)); // Boşlukları alt tire ile değiştir
                                                $imageName = preg_replace('/[^A-Za-z0-9_\-]/', '', $imageName); // Özel karakterleri kaldır
                                                $imageName = $imageName . '.png'; // veya .jpg veya .jpeg olarak değiştir

                                                // Tedarikçi resim yolunu belirle
                                                $supplierImageUrl = "yuklenen_resimler/" . $imageName;

                                                // Resmin varlığını kontrol et
                                                if (file_exists($supplierImageUrl)) {
                                                    echo '<img class="img-responsive" src="' . $supplierImageUrl . '" alt="' . $supplierName . '" width="250" height="250">';
                                                } else {
                                                    echo '<img class="img-responsive" src="yuklenen_resimler/default_supplier.jpg" alt="Varsayılan Resim" width="250" height="250">';
                                                }
                                                ?>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="user-profile-name"><?php echo $supplierName; ?></div>
                                                <div class="user-Location"><i class="ti-location-pin"></i> <?php echo htmlspecialchars($supplier['supplier_location']); ?></div>
                                                <div class="user-job-title">Tedarikçi</div>
                                                <div class="custom-tab user-profile-tab">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Hakkında</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div role="tabpanel" class="tab-pane active" id="1">
                                                            <div class="contact-information">
                                                                <h4>İletişim bilgileri</h4>
                                                                <div class="address-content">
                                                                    <span class="contact-title">Email:</span>
                                                                    <span class="mail-address"><?php echo htmlspecialchars($supplier['email']); ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>

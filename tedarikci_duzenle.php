<?php
include 'sidebar.php';
include 'database/connection.php';

$suppliers = [];
try {
    $stmt = $conn->prepare("SELECT * FROM suppliers");
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
                                <h1>Tedarikçi Ekle</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 p-l-0 title-margin-left">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Tedarikçiler</a></li>
                                    <li class="active">Tedarikçiler Listesi</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Tedarikçi Ekle</h4>
                                </div>
                                <div class="card-body">
                                    <div class="menu-upload-form">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi adı</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="tedarikci_ad" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi email</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="tedarikci_email" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi konumu</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="tedarikci_konum" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi Resmi</label>
                                                <div class="col-sm-10">
                                                    <div class="form-control file-input dark-browse-input-box">
                                                        <input type="file" name="tedarikci_resim" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="tedarikci_ekle" class="btn btn-lg btn-primary">Ekle</button>
                                                </div>
                                            </div>
                                        </form><br>
                                        <?php
                                        // Tedarikçi ekleme işlemi
                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tedarikci_ekle'])) {
                                            // Diğer form alanlarını aldıktan sonra
                                            // Formdan gelen verileri al
                                            $tedarikci_ad = $_POST['tedarikci_ad'];
                                            $tedarikci_email = $_POST['tedarikci_email'];
                                            $tedarikci_konum = $_POST['tedarikci_konum'];

                                            // Tedarikçi adını kullanarak dosya adını oluştur
                                            $dosyaAdi = strtolower(str_replace(' ', '_', $tedarikci_ad)); // Boşlukları alt tire ile değiştir
                                            $dosyaAdi = preg_replace('/[^A-Za-z0-9_\-]/', '', $dosyaAdi); // Özel karakterleri kaldır
                                            $dosyaAdi = $dosyaAdi . '.png'; // .png uzantısı ekle

                                            // Resmi yükleme ve yeni adla kaydetme
                                            $dosyaYolu = "yuklenen_resimler/" . $dosyaAdi;
                                            move_uploaded_file($_FILES["tedarikci_resim"]["tmp_name"], $dosyaYolu);

                                            try {
                                                // Veritabanına tedarikçiyi ekleme işlemi
                                                $sql = "INSERT INTO suppliers (supplier_name, email, supplier_location, suppliers_pp) VALUES (:supplier_name, :supplier_email, :supplier_location, :suppliers_pp)";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->bindParam(':supplier_name', $tedarikci_ad);
                                                $stmt->bindParam(':supplier_email', $tedarikci_email);
                                                $stmt->bindParam(':supplier_location', $tedarikci_konum);
                                                $stmt->bindParam(':suppliers_pp', $dosyaAdi);
                                                $stmt->execute();
                                                echo "Tedarikçi başarıyla eklendi.";
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
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Tedarikçi Sil</h4>
                                </div>
                                <div class="card-body">
                                    <div class="menu-upload-form">
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="form-group custom-form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi Seçin</label>
                                                <div class="col-sm-10">
                                                    <select name="tedarikci_id_sil" class="form-control">
                                                        <?php foreach ($suppliers as $supplier): ?>
                                                            <option value="<?= htmlspecialchars($supplier['id']) ?>"><?= htmlspecialchars($supplier['supplier_name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-lg btn-danger" name="sil">Sil</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sil"])) {
                                            $tedarikci_id_sil = isset($_POST["tedarikci_id_sil"]) ? $_POST["tedarikci_id_sil"] : '';

                                            try {
                                                // Silmeden önce ilgili 'orders' tablosundaki kayıtları sil
                                                $sql_delete_orders = "DELETE FROM orders WHERE supplier_id = :tedarikci_id";
                                                $stmt_delete_orders = $conn->prepare($sql_delete_orders);
                                                $stmt_delete_orders->bindParam(':tedarikci_id', $tedarikci_id_sil);
                                                $stmt_delete_orders->execute();

                                                // Daha sonra 'suppliers' tablosundaki kaydı sil
                                                $sql_delete_supplier = "DELETE FROM suppliers WHERE id = :tedarikci_id";
                                                $stmt_delete_supplier = $conn->prepare($sql_delete_supplier);
                                                $stmt_delete_supplier->bindParam(':tedarikci_id', $tedarikci_id_sil);
                                                $stmt_delete_supplier->execute();

                                                echo "Tedarikçi ve ilgili siparişler başarıyla silindi!";
                                            } catch (Exception $e) {
                                                echo "Silme hatası: " . $e->getMessage();
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="card-header">
                                    <h4>Tedarikçi Güncelle</h4>
                                </div>
                                <div class="card-body">
                                    <div class="menu-upload-form">
                                        <form class="form-horizontal" action="" method="post">
                                            <div class="form-group custom-form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi Seçin</label>
                                                <div class="col-sm-10">
                                                    <select name="selected_supplier_id" class="form-control">
                                                        <?php foreach ($suppliers as $supplier): ?>
                                                            <option value="<?= htmlspecialchars($supplier['id']) ?>"><?= htmlspecialchars($supplier['supplier_name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-lg btn-primary" name="select_supplier">Seç</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["select_supplier"])) {
    $selected_supplier_id = isset($_POST["selected_supplier_id"]) ? $_POST["selected_supplier_id"] : '';

    // Seçilen tedarikçinin bilgilerini veritabanından al
    $selectedSupplier = null;
    foreach ($suppliers as $supplier) {
        if ($supplier['id'] == $selected_supplier_id) {
            $selectedSupplier = $supplier;
            break;
        }
    }

    if ($selectedSupplier) {
        ?>
                                        <form class="form-horizontal" action="" method="post">
                                            <input type="hidden" name="selected_supplier_id" value="<?= $selectedSupplier['id'] ?>">
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi Adı</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="supplier_name" class="form-control" value="<?= htmlspecialchars($selectedSupplier['supplier_name']) ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Tedarikçi Konumu</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="supplier_location" class="form-control" value="<?= htmlspecialchars($selectedSupplier['supplier_location']) ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($selectedSupplier['email']) ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" class="btn btn-lg btn-primary" name="update_supplier">Kaydet</button>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                        } else {
                                            echo "Seçilen tedarikçi bulunamadı!";
                                        }
                                        }

                                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_supplier"])) {
                                            $selected_supplier_id = isset($_POST["selected_supplier_id"]) ? $_POST["selected_supplier_id"] : '';
                                            $supplier_name = isset($_POST["supplier_name"]) ? $_POST["supplier_name"] : '';
                                            $supplier_location = isset($_POST["supplier_location"]) ? $_POST["supplier_location"] : '';
                                            $email = isset($_POST["email"]) ? $_POST["email"] : '';

                                            // Güncelleme sorgusu
                                            $sql_update_supplier = "UPDATE suppliers SET supplier_name = :supplier_name, supplier_location = :supplier_location, email = :email WHERE id = :selected_supplier_id";
                                            $stmt_update_supplier = $conn->prepare($sql_update_supplier);
                                            $stmt_update_supplier->bindParam(':supplier_name', $supplier_name);
                                            $stmt_update_supplier->bindParam(':supplier_location', $supplier_location);
                                            $stmt_update_supplier->bindParam(':email', $email);
                                            $stmt_update_supplier->bindParam(':selected_supplier_id', $selected_supplier_id);

                                            if ($stmt_update_supplier->execute()) {
                                                echo "Tedarikçi bilgileri başarıyla güncellendi!";
                                            } else {
                                                echo "Tedarikçi güncelleme hatası: " . $stmt_update_supplier->errorInfo()[2];
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
    <script src="assets/js/scripts.js"></script>
    <!-- script init-->
    </body>

</html>

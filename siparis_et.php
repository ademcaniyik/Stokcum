<?php
include 'database/connection.php';

// Ürünleri veritabanından çekme
$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$products = $stmt->fetchAll();

// Form gönderildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sipariş tarihini al
    $order_date = date('Y-m-d H:i:s');

    // Siparişleri işleme
    foreach ($products as $product) {
        // Kullanıcıdan gelen sipariş miktarı
        $quantity = $_POST["quantity_$product[id]"];

        // Sipariş miktarı boş değilse ve sıfırdan büyükse
        if (!empty($quantity) && $quantity > 0) {
            $product_id = $product['id'];
            $supplier_id = $product['supplier_id'];

            // Siparişi veritabanına ekleme ve order_stat değerini 1 yapma
            $stmt = $conn->prepare("INSERT INTO orders (order_quanitity, product_id, supplier_id, order_stat, order_date) VALUES (:quantity, :product_id, :supplier_id, 1, :order_date)");
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':product_id', $product_id);
            $stmt->bindParam(':supplier_id', $supplier_id);
            $stmt->bindParam(':order_date', $order_date);
            $stmt->execute();
        }
    }

    // Siparişler veritabanına eklendikten sonra, order_list.php sayfasını yeni bir sekmede açma
    echo '<script>window.open("order_list.php", "_blank");</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stokcum- Depo</title>
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .row-red {
            background-color: #f8d7da !important;
        }
        .row-yellow {
            background-color: #fff3cd !important;
        }
        .row-green {
            background-color: #d4edda !important;
        }
        input[type="number"] {
            background-color: #FFFFFF;
            color: #000000;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 15px; /* To ensure spacing between the table and the button */
        }
        .btn-right {
            float: right;
            margin-right: 10px;
            padding: 6px 12px; /* Adjust padding for a shorter button */
        }
    </style>
</head>
<body>
<?php include "sidebar.php" ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Depo</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Depo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4>Depo </h4>
                            </div>
                            <div class="invoice-edit">
                                <div class="invoicelist-body">
                                    <div class="table-container">
                                        <form method="post">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Barkod</th>
                                                    <th>Ürün Adı</th>
                                                    <th>Miktar</th
                                                    <th>Sipariş Miktarı</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($products as $product): ?>
                                                    <tr class="<?php echo ($product['quantity'] < 5) ? 'row-red' : (($product['quantity'] >= 5 && $product['quantity'] <= 20) ? 'row-yellow' : 'row-green'); ?>">
                                                        <td><?php echo $product['product_barkod']; ?></td>
                                                        <td><?php echo $product['name']; ?></td>
                                                        <td><?php echo ($product['quantity'] == 0) ? 'Tükendi' : $product['quantity']; ?></td>
                                                        <td><input type="number" name="quantity_<?php echo $product['id']; ?>" min="0"></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                    </div>
                                    <button type="submit" class="btn-right">Sipariş Et</button>
                                    </form>
                                </div>
                            </div>
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

<?php
include 'database/connection.php';
try {
    // Kategori isimlerini çekmek için categories tablosundan verileri al
    $stmt_categories = $conn->prepare("SELECT id, name FROM categories");
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    // Ürünleri çekmek için products tablosundan verileri al
    $stmt_products = $conn->prepare("SELECT p.id, p.name, p.quantity, p.buy_price, p.sale_price, p.categorie_id, p.date, p.product_barkod, c.name as category_name 
                                    FROM products p 
                                    JOIN categories c ON p.categorie_id = c.id");
    $stmt_products->execute();
    $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Stokcum- Ürünler</title>

    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php
include "sidebar.php"
?>
<body class="sidebar-hide">
<div class="content-wrap">
    <body class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Ürünler</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Ürünler</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>

            <!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4>Ürünler </h4>
                            </div>
                            <div class="invoice-edit">
                                <div class="invoicelist-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Barkod</th>
                                                <th>Ürün Adı</th>
                                                <th>Miktar</th>
                                                <th>Alış Fiyatı</th>
                                                <th>Satış Fiyatı</th>
                                                <th>Kategori</th>
                                                <th>Tarih</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($products as $product): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($product['product_barkod']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                    <td><?php echo $product['quantity']; ?></td>
                                                    <td><?php echo $product['buy_price']; ?></td>
                                                    <td><?php echo $product['sale_price']; ?></td>
                                                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                                    <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($product['date']))); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="invoice-edit">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="control-bar alert-rating">
                                <label></label>
                                <div class="pull-right dib">
                                    <a class="bg-success" href="javascript:window.print()">Yazdır</a>
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

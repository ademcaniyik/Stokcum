<?php
include 'database/connection.php';
try {
    $stmt = $conn->prepare("SELECT p.id, p.name, p.quantity, p.buy_price, p.sale_price, p.categorie_id, p.date, p.product_barkod, s.qty, s.price, s.date as sale_date 
                            FROM products p 
                            JOIN sales s ON p.id = s.product_id");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <title>Stokcum- Satış takip</title>

    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<?php
include "sidebar.php"
?>
<body class="sidebar-hide">
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Anasayfa</h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anasayfa</a></li>
                                <li class="active">Satış raporlama</li>
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
                                <h4>Satış Raporlama </h4>
                            </div>
                                <!--.row-->
                                <div class="invoicelist-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead >
                                            <tr>
                                                <th class="w10pr">Barkod</th>
                                                <th class="w10pr">Ad</th>
                                                <th class="w10pr">Tarih</th>
                                                <th class="w10pr">Adet</th>
                                                <th class="w12pr">Birim fiyat</th>
                                                <th class="w10pr">Satış tutarı</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($products as $product): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($product['product_barkod']); ?></td>
                                                    <td><?php echo $product['name']; ?></td>
                                                    <td class="" ><?php echo htmlspecialchars(date('Y-m-d H:i:s', strtotime($product['sale_date']))); ?></td>
                                                    <td class="w10pr" ><?php echo $product['qty']; ?></td>
                                                    <td class="w12pr" ><?php echo $product['price']; ?></td>
                                                    <td class="w10pr" ><?php echo $product['qty'] * $product['price']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="invoicelist-footer">
                                    <table>
                                        <tr>
                                            <td><strong>Toplam:</strong></td>
                                            <td id="total_price"></td>
                                        </tr>
                                    </table>
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
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tbody = document.querySelector("tbody");

        tbody.addEventListener("input", function(event) {
            var row = event.target.closest("tr");
            var quantityCell = row.querySelector(".w10pr");
            var priceCell = row.querySelector(".w12pr");
            var totalPriceCell = row.querySelector(".w10pr:last-child");

            if (quantityCell && priceCell && totalPriceCell) {
                var quantity = parseFloat(quantityCell.textContent);
                var price = parseFloat(priceCell.textContent);

                totalPriceCell.textContent = (quantity * price).toFixed(2);
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var tbody = document.querySelector("tbody");
        var totalPriceCell = document.getElementById("total_price");

        // Toplam fiyatı hesaplamak için bir fonksiyon oluşturalım
        function calculateTotalPrice() {
            var total = 0;
            var rows = tbody.querySelectorAll("tr");

            rows.forEach(function(row) {
                var priceCell = row.querySelector(".w10pr:last-child");

                if (priceCell) {
                    total += parseFloat(priceCell.textContent);
                }
            });

            // Toplam fiyatı "Toplam" satırındaki hücreye yazalım
            totalPriceCell.textContent = total.toFixed(2);
        }

        // Sayfa yüklendiğinde ve her bir düzenleme yapıldığında toplam fiyatı hesaplayalım
        document.addEventListener("input", calculateTotalPrice);
        calculateTotalPrice(); // Sayfa yüklendiğinde toplam fiyatı hemen hesaplayalım
    });
</script>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/lib/invoice-edit.js"></script>
<script src="assets/js/scripts.js"></script>
</body>
</html>
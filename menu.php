<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('location:giris.php');
}
$user = $_SESSION['user'];

include 'database/connection.php';

// Veritabanından ürün miktarlarını çek
try {
    $stmt_products = $conn->prepare("SELECT name, quantity FROM products");
    $stmt_products->execute();
    $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}

// JSON formatında verileri hazırlayın
$product_names = array();
$product_quantities = array();
foreach ($products as $product) {
    $product_names[] = $product['name'];
    $product_quantities[] = $product['quantity'];
}

$product_names_json = json_encode($product_names);
$product_quantities_json = json_encode($product_quantities);

// Veritabanından siparişleri çek, sadece order_stat değeri 1 olanları al
try {
    $stmt_orders = $conn->prepare("
        SELECT products.name as product_name, SUM(orders.order_quanitity) as total_quantity
        FROM orders
        INNER JOIN products ON orders.product_id = products.id
        WHERE orders.order_stat = 1
        GROUP BY products.name
    ");
    $stmt_orders->execute();
    $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}

// JSON formatında verileri hazırlayın
$order_product_names = array();
$order_quantities = array();
foreach ($orders as $order) {
    $order_product_names[] = $order['product_name'];
    $order_quantities[] = $order['total_quantity'];
}

$order_product_names_json = json_encode($order_product_names);
$order_quantities_json = json_encode($order_quantities);

// Veritabanından satış verilerini çek
try {
    $stmt_sales = $conn->prepare("
        SELECT DATE(date) as sale_date, SUM(qty) as total_qty, SUM(qty * price) as total_revenue
        FROM sales
        GROUP BY DATE(date)
        ORDER BY sale_date
    ");
    $stmt_sales->execute();
    $sales = $stmt_sales->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Hata: " . $e->getMessage();
}

// JSON formatında verileri hazırlayın
$sale_dates = array();
$sale_quantities = array();
$sale_revenues = array();
foreach ($sales as $sale) {
    $sale_dates[] = $sale['sale_date'];
    $sale_quantities[] = $sale['total_qty'];
    $sale_revenues[] = $sale['total_revenue'];
}

$sale_dates_json = json_encode($sale_dates);
$sale_quantities_json = json_encode($sale_quantities);
$sale_revenues_json = json_encode($sale_revenues);

try {
    $stmt_recent_sales = $conn->prepare("
        SELECT sales.id, products.name as product_name, sales.qty, sales.price, sales.date
        FROM sales
        INNER JOIN products ON sales.product_id = products.id
        ORDER BY sales.date DESC
        LIMIT 3
    ");
    $stmt_recent_sales->execute();
    $recent_sales = $stmt_recent_sales->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Stokcum Takip</title>
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="assets/css/lib/weather-icons.css" rel="stylesheet" />
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php include "sidebar.php" ?>
<!-- /# sidebar -->
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <h1>Merhaba <span>hoşgeldiniz!</span></h1>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Anamenü</a></li>
                                <li class="active">Anasayfa</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- /# column -->
            </div>
            <!-- /# row -->
            <div id="main-content">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card alert">
                            <div class="card-header">
                                <h4 class="f-s-14">Ürün Doluluğu</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="stockChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card alert">
                            <div class="card-header">
                                <h4 class="f-s-14">Sipariş Durumu</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="orderChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4 class="f-s-14">Toplam Satış Miktarı</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="salesQtyChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card alert">
                            <div class="card-header">
                                <h4 class="f-s-14">Toplam Gelir</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="salesRevenueChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card alert">
                            <div class="card-header">
                                <h4 class="f-s-14">Son satışlar</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Ürün</th>
                                        <th>Miktar</th>
                                        <th>Fiyat</th>
                                        <th>Tarih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($recent_sales as $sale): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($sale['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($sale['qty']); ?></td>
                                            <td><?php echo htmlspecialchars($sale['price']); ?></td>
                                            <td><?php echo htmlspecialchars($sale['date']); ?></td>
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
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxStock = document.getElementById('stockChart').getContext('2d');

        var productNames = <?php echo $product_names_json; ?>;
        var productQuantities = <?php echo $product_quantities_json; ?>;

        var stockChart = new Chart(ctxStock, {
            type: 'pie',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Stok Durumu',
                    data: productQuantities,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' adet';
                            }
                        }
                    }
                }
            }
        });

        var ctxOrder = document.getElementById('orderChart').getContext('2d');

        var orderProductNames = <?php echo $order_product_names_json; ?>;
        var orderQuantities = <?php echo $order_quantities_json; ?>;

        var orderChart = new Chart(ctxOrder, {
            type: 'bar',
            data: {
                labels: orderProductNames,
                datasets: [{
                    label: 'Sipariş Miktarı',
                    data: orderQuantities,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxSalesQty = document.getElementById('salesQtyChart').getContext('2d');

        var saleDates = <?php echo $sale_dates_json; ?>;
        var saleQuantities = <?php echo $sale_quantities_json; ?>;

        var salesQtyChart = new Chart(ctxSalesQty, {
            type: 'line',
            data: {
                labels: saleDates,
                datasets: [{
                    label: 'Toplam Satış Miktarı',
                    data: saleQuantities,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        var ctxSalesRevenue = document.getElementById('salesRevenueChart').getContext('2d');

        var saleRevenues = <?php echo $sale_revenues_json; ?>;

        var salesRevenueChart = new Chart(ctxSalesRevenue, {
            type: 'line',
            data: {
                labels: saleDates,
                datasets: [{
                    label: 'Toplam Gelir',
                    data: saleRevenues,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
</body>
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
</html>
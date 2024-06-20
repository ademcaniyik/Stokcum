<?php
include('database/connection.php');

// SQL sorgusu: products tablosunu categories tablosuyla birleştirerek kategori adını alın
$sql = "SELECT p.id, p.product_barkod, p.name, p.quantity, p.buy_price, p.sale_price, p.date, p.product_img, c.name as category_name 
        FROM products p 
        JOIN categories c ON p.categorie_id = c.id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stokcum</title>
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/datatable/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/lib/datatable/buttons.bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title"></div>
                    </div>
                </div>
                <div class="col-lg-4 p-l-0 title-margin-left">
                    <div class="page-header">
                        <div class="page-title">
                            <ol class="breadcrumb text-right">
                                <li><a href="#">Satışlar</a></li>
                                <li class="active">Satış Yap</li>
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
                                <h4>Satış Tablosu</h4>
                                <div class="card-header-right-icon">
                                    <ul>
                                        <li class="doc-link"><a href="#"><i class="ti-search"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="bootstrap-data-table-panel">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Barkod</th>
                                            <th>Ad</th>
                                            <th>Adet</th>
                                            <th>Alış Fiyatı</th>
                                            <th>Satış Fiyatı</th>
                                            <th>Tarih</th>
                                            <th>Kategori</th>
                                            <th>İşlem</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($results as $row): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['product_barkod']); ?></td>
                                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                                <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                                <td><?php echo htmlspecialchars($row['buy_price']); ?></td>
                                                <td><?php echo htmlspecialchars($row['sale_price']); ?></td>
                                                <td><?php echo htmlspecialchars($row['date']); ?></td>
                                                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                                                <td>
                                                    <input type="number" class="sale-quantity" data-id="<?php echo $row['id']; ?>" min="1" max="<?php echo $row['quantity']; ?>" value="1">
                                                    <button class="btn btn-primary sale-button">Sat</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="search">
    <button type="button" class="close">×</button>
    <form>
        <input type="search" value="" placeholder="type keyword(s) here" />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/data-table/datatables.min.js"></script>
<script src="assets/js/lib/data-table/datatables-init.js"></script>
<script src="assets/js/scripts.js"></script>
<script>
    $(document).ready(function() {
        $('.sale-button').click(function() {
            var row = $(this).closest('tr');
            var quantityInput = row.find('.sale-quantity');
            var id = quantityInput.data('id');
            var quantity = quantityInput.val();

            if (quantity > 0) {
                $.ajax({
                    url: 'sell_product.php',
                    method: 'POST',
                    data: { id: id, quantity: quantity },
                    success: function(response) {
                        if (response == 'success') {
                            alert('Satış işlemi başarılı');
                            location.reload();
                        } else {
                            alert('Satış işlemi başarısız');
                        }
                    }
                });
            } else {
                alert('Geçerli bir adet girin');
            }
        });
    });
</script>
</body>
</html>

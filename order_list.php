<?php
include 'database/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];

    try {
        // Siparişin product_id, order_quantity ve order_date değerlerini al
        $stmt_select = $conn->prepare("SELECT product_id, order_quanitity, order_date FROM orders WHERE order_id = :order_id");
        $stmt_select->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        $stmt_select->execute();
        $order = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            $product_id = $order['product_id'];
            $order_quantity = $order['order_quanitity'];
            $order_date = $order['order_date'];

            // Products tablosundaki quantity değerini arttır
            $stmt_update = $conn->prepare("UPDATE products SET quantity = quantity + :order_quantity WHERE id = :product_id");
            $stmt_update->bindParam(':order_quantity', $order_quantity, PDO::PARAM_INT);
            $stmt_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt_update->execute();

            // Orders tablosundaki order_stat değerini 0 yap
            $stmt_update_order = $conn->prepare("UPDATE orders SET order_stat = 0 WHERE order_id = :order_id");
            $stmt_update_order->bindParam(':order_id', $order_id, PDO::PARAM_INT);
            if ($stmt_update_order->execute()) {
                echo 'success';
            } else {
                echo 'failure';
            }
        } else {
            echo 'failure';
        }
    } catch (Exception $e) {
        echo 'Hata: ' . $e->getMessage();
    }
    exit;
}

try {
    // Orders tablosundan tüm verileri, products ve suppliers tablolarıyla birleştirerek seç ve sadece order_stat değeri 1 olanları al
    $stmt_orders = $conn->prepare("
        SELECT orders.order_id, orders.order_quanitity, orders.order_date, products.name as product_name, suppliers.supplier_name 
        FROM orders
        INNER JOIN products ON orders.product_id = products.id
        INNER JOIN suppliers ON orders.supplier_id = suppliers.id
        WHERE orders.order_stat = 1
    ");
    $stmt_orders->execute();
    $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Stokcum- Depo</title>
    <link href="assets/css/lib/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/lib/themify-icons.css" rel="stylesheet">
    <link href="assets/css/lib/menubar/sidebar.css" rel="stylesheet">
    <link href="assets/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/lib/unix.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include "sidebar.php" ?>
<div class="container">
    <h2>Siparişler</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Sipariş</th>
            <th>Miktar</th>
            <th>Ürün adı</th>
            <th>Tedarikçi adı</th>
            <th>İşlem</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_id']; ?></td>
                <td><?php echo $order['order_quanitity']; ?></td>
                <td><?php echo $order['product_name']; ?></td>
                <td><?php echo $order['supplier_name']; ?></td>
                <td><?php echo $order['order_date']; ?></td> <!-- Sipariş tarihi eklendi -->
                <td>
                    <button class="btn btn-success btn-complete" data-id="<?php echo $order['order_id']; ?>">Tamamlandı</button>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/scripts.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-complete').click(function() {
            var orderId = $(this).data('id');
            if (confirm('Bu siparişi tamamlandığını onaylıyor musunuz?')) {
                $.ajax({
                    url: '', // Aynı dosyaya POST isteği yap
                    method: 'POST',
                    data: { order_id: orderId },
                    success: function(response) {
                        if (response == 'success') {
                            alert('Sipariş tamamlandı.');
                            location.reload();
                        } else {
                            alert('Hata: Sipariş tamamlanamadı.');
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>

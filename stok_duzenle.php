<?php
include 'database/connection.php';

$products = []; // Ürünlerin listesini tutacak boş bir dizi oluşturuyoruz

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['productId'];
    $updatedQuantity = $_POST['updatedQuantity'];

    try {
        $stmt = $conn->prepare('UPDATE products SET quantity = :quantity WHERE id = :id');
        $stmt->bindParam(':quantity', $updatedQuantity);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Başarılı yanıt gönder
        http_response_code(200);
        // Sayfayı yeniden yükle
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        // Hata durumunda yanıt gönder
        http_response_code(500);
    }
} else {
    // Geçersiz istek yanıtı gönder
    http_response_code(400);
}

// Ürünleri veritabanından çek
try {
    $stmt = $conn->prepare("SELECT id, name, quantity, product_barkod FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Veritabanından ürün bilgilerini alıp $products değişkenine atıyoruz
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
<?php include "sidebar.php" ?>
<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card alert">
                        <div class="card-header">
                            <h4>Stok Yönetimi</h4>
                        </div>
                        <div class="invoice-edit">
                            <div class="invoicelist-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="w10pr">Barkodu</th>
                                            <th class="w10pr">Adı</th>
                                            <th class="w10pr">Stok adedini düzenle</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($products as $product): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($product['product_barkod']); ?></td>
                                                <td><?php echo $product['name']; ?></td>
                                                <td>
                                                    <form action="" method="post">
                                                        <input type="hidden" name="productId" value="<?php echo $product['id']; ?>">
                                                        <input type="number" name="updatedQuantity" value="<?php echo $product['quantity']; ?>">
                                                        <button type="submit" class="btn btn-success">Güncelle</button>
                                                    </form>
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
            </div>
        </div>
    </div>
</div>

<script src="assets/js/lib/jquery.min.js"></script>
<script src="assets/js/lib/jquery.nanoscroller.min.js"></script>
<script src="assets/js/lib/menubar/sidebar.js"></script>
<script src="assets/js/lib/preloader/pace.min.js"></script>
<script src="assets/js/lib/bootstrap.min.js"></script>
<script src="assets/js/lib/invoice-edit.js"></script>
<script src="assets/js/scripts.js"></script>

</body>

</html>

<?php
include('database/connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    // Mevcut ürünü getir
    $stmt = $conn->prepare("SELECT quantity, sale_price FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product && $product['quantity'] >= $quantity) {
        // Stok güncelle
        $newQuantity = $product['quantity'] - $quantity;
        $updateStmt = $conn->prepare("UPDATE products SET quantity = ? WHERE id = ?");
        $updateStmt->execute([$newQuantity, $id]);

        // Satış bilgilerini ekle
        $saleStmt = $conn->prepare("INSERT INTO sales (product_id, qty, price, date) VALUES (?, ?, ?, NOW())");
        $saleStmt->execute([$id, $quantity, $product['sale_price'] * $quantity]);

        echo 'success';
    } else {
        echo 'fail';
    }
}
?>

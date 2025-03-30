<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $transaction_type = $_POST['transaction_type'];

    $sql = "SELECT stock FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($current_stock);
    $stmt->fetch();

    if ($transaction_type == 'stock_in') {
        $new_stock = $current_stock + $quantity;
    } elseif ($transaction_type == 'stock_out') {
        $new_stock = $current_stock - $quantity;
        if ($new_stock < 0) {
            echo "Not enough stock!";
            exit();
        }
    }

    // Update stock
    $sql = "UPDATE products SET stock = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_stock, $product_id);
    $stmt->execute();

    // Record transaction
    $sql = "INSERT INTO transactions (product_id, quantity, transaction_type) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $product_id, $quantity, $transaction_type);
    $stmt->execute();

    echo "Stock updated successfully!";
}
?>

<form method="POST">
    <label>Product ID:</label><input type="number" name="product_id" required>
    <label>Quantity:</label><input type="number" name="quantity" required>
    <label>Transaction Type:</label>
    <select name="transaction_type">
        <option value="stock_in">Stock In</option>
        <option value="stock_out">Stock Out</option>
    </select>
    <button type="submit">Update Stock</button>
</form>

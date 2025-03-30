<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "INSERT INTO products (name, description, price) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssd", $name, $description, $price);
    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<form method="POST">
    <label>Product Name:</label><input type="text" name="name" required>
    <label>Description:</label><textarea name="description"></textarea>
    <label>Price:</label><input type="number" name="price" required>
    <button type="submit">Add Product</button>
</form>

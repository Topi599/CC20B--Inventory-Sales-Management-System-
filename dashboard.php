<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

echo "Welcome, " . $_SESSION['username'];
?>

<a href="add product.php">Add Product</a>
<a href="manage_stock.php">Manage Stock</a>
<a href="logout.php">Logout</a>


<?php
$sql = "SELECT id, name, stock FROM products";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Product: " . $row['name'] . " | Stock: " . $row['stock'] . "<br>";
    }
}
?>

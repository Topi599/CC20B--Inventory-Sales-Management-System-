<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashed_password);
        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Passwords do not match.";
    }
}
?>

<form method="POST">
    <label>Username:</label><input type="text" name="username" required>
    <label>Password:</label><input type="password" name="password" required>
    <label>Confirm Password:</label><input type="password" name="confirm_password" required>
    <button type="submit">Sign Up</button>
</form>

<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $db_username, $db_password);
    $stmt->fetch();

    if ($db_username && password_verify($password, $db_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Invalid credentials.";
    }

    $stmt->close();
}
?>

<form method="POST">
    <label>Username:</label><input type="text" name="username" required>
    <label>Password:</label><input type="password" name="password" required>
    <button type="submit">Login</button>
    <button type="submit"><a href='sign up.php'>Sign Up</a></button>
</form>

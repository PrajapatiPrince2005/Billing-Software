<?php
session_start();
include 'db.php'; // your DB connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query admin table (make sure you have an 'admins' table)
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($admin = $result->fetch_assoc()) {
        // Match plain password or use password_verify() if hashed
        if ($password === $admin['password']) {
            $_SESSION['admin'] = $admin['username'];
            header("Location: index.php");
            exit;
        }
    }

    // On failure
    echo "<script>alert('❌ Invalid username or password'); window.location.href='login.php';</script>";
}
?>

<?php
require_once 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user_details WHERE userGmail = '$email' AND userPassword = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = strtolower($row['role']);
        echo "<script>alert('Login successful!'); window.location.href = 'Display.php';</script>";
    } else {
        // Login failed
        echo "<script>alert('Invalid email or password.'); window.location.href = 'login.php';</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'login.php';</script>";
} 
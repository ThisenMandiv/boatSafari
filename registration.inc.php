<?php
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $checkQuery = "SELECT * FROM user_details WHERE userGmail = '$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email.'); window.location.href = 'registration.php';</script>";
    } else {
        $sql = "INSERT INTO user_details (userName, userGmail, userPassword, role) VALUES ('$name', '$email', '$password', 'customer')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href = 'login.php';</script>";
        } else {
            echo "<script>alert('Error: {$conn->error}'); window.location.href = 'registration.php';</script>";
        }
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'registration.php';</script>";
} 
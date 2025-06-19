<?php

// Include Db Connection
require_once 'connection.php'; // Make sure connection.php is in the correct path

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve data from the POST request
    $id = $_POST['id'];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Update data in the database
    
    $sql = "UPDATE user_details SET userName='$name',
     userGmail='$email', userPassword='$password' WHERE id = '$id'";

    // check if update was successful
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');</script>";
        echo "<script>window.location.href = 'Display.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the request method is not POST (e.g., direct access)
    echo "Invalid request method.";
}

?>
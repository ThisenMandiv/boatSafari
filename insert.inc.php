<?php
//include connection php file
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //validation
    $checkQuery = "SELECT * FROM user_details WHERE  userGmail = '$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use a different email.');</script>";
        echo "<script>window.location.href = 'insert.php';</script>";
        
    }else{

    // insert data in to the datatbase
    $sql = "INSERT INTO user_details (userName, userGmail, userPassword, role) VALUES ('$name', '$email', '$password', 'customer')";


    // Check if the insert was successful



    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
        echo "<script>window.location.href = 'Display.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
}
// Close the database connection
$conn->close();

?>
<?php
$servername = "localhost";
$username = "root";
$password = ""; // Empty string for no password
$dbname = "useracc";
$port = 3308;

// createconnection
$conn = new mysqli($servername, $username, $password, $dbname, $port); 

// createCheck connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo "";
}
?>
<?php
require_once 'connection.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the existing data for the user
    $sql = "SELECT * FROM user_details WHERE id = '$id'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['userName'];
        $email = $row['userGmail']; 
        $password = $row['userPassword'];

        // Display the form with existing data
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Update User Details</title>";
        echo "<link rel='stylesheet' href='./css/insert.css'>";
        echo "</head>";
        echo "<body>";
        echo "<form action='./update.inc.php' method='post'>";
        echo "<input type='hidden' name='id' value='" . $id . "'>";

echo "<label for='name'>User Name:</label><br>";
echo "<input type='text' id='fname' name='name' value ='". $name ."'><br>";

echo "<label for='gmail'>User Gmail:</label><br>";
echo "<input type='email' id='email' name='email'value ='". $email ."'><br>";

echo "<label for='password'>Password:</label><br>";
echo "<input type='text' id='password' name='password'value ='". $password ."'><br>";

echo "<button type='submit'>submit</button>";

echo "</form>";

echo "</body>";
echo "</html>";

    } else {
        echo "No user found with this ID.";
        
    }
} else {
    echo "ID not provided.";
    exit;
}

?>
<?php
//insert DB connection file
require_once 'connection.php';

//retrieve data from the database
$sql = "SELECT * FROM user_details";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
  
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"]. "</td>";
        echo "<td>" . $row["userName"]. "</td>";
        echo "<td>" . $row["userGmail"]. "</td>";
        echo "<td>" . $row["userPassword"]. "</td>";
        echo "<td>";
        echo "<button onClick=\"redirectToUpdateForm(". $row["id"] .")\" class='update-btn'>Update</button> ";
        echo "</td>";
        echo "<td>";
        echo "<form action='delete.php' method='post' style='display:inline;' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>";
        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
        echo "<button type='submit' class='delete-btn'>Delete</button>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";
           
    }
  
} else {
    echo "No data available";
}
$conn->close();

?>
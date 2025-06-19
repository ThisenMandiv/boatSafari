<?php
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Boat</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Add New Boat</h1>
            <form action="boats_process.php" method="post">
                <label for="boat_name">Boat Name:</label><br>
                <input type="text" id="boat_name" name="boat_name" required><br><br>
                <label for="capacity">Capacity:</label><br>
                <input type="number" id="capacity" name="capacity" required min="1"><br><br>
                <label for="status">Status:</label><br>
                <select id="status" name="status">
                    <option value="Available">Available</option>
                    <option value="Under Maintenance">Under Maintenance</option>
                    <option value="Out on Safari">Out on Safari</option>
                </select><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description"></textarea><br><br>
                <button type="submit" name="add_boat">Add Boat</button>
            </form>
        </div>
    </div>
</body>
</html> 
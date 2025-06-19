<?php
include '../navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Safari</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Add New Safari</h1>
            <form action="safaris_process.php" method="post">
                <label for="safari_name">Safari Name:</label><br>
                <input type="text" id="safari_name" name="safari_name" required><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description"></textarea><br><br>
                <label for="duration">Duration:</label><br>
                <input type="text" id="duration" name="duration" required placeholder="e.g. 2 hours, Half-day"><br><br>
                <label for="price_per_person">Price per Person:</label><br>
                <input type="number" id="price_per_person" name="price_per_person" step="0.01" required><br><br>
                <label for="max_passengers">Max Passengers:</label><br>
                <input type="number" id="max_passengers" name="max_passengers"><br><br>
                <label for="active_status">Status:</label><br>
                <select id="active_status" name="active_status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select><br><br>
                <button type="submit" name="add_safari">Add Safari</button>
            </form>
        </div>
    </div>
</body>
</html> 
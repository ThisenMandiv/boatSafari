<?php
require_once '../connection.php';
include '../navbar.php';
if (!isset($_GET['id'])) {
    echo "<script>alert('No safari selected.'); window.location.href='safaris_list.php';</script>";
    exit;
}
$safari_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM safaris WHERE safari_id = ?");
$stmt->bind_param("i", $safari_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo "<script>alert('Safari not found.'); window.location.href='safaris_list.php';</script>";
    exit;
}
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Safari</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Edit Safari</h1>
            <form action="safaris_process.php" method="post">
                <input type="hidden" name="safari_id" value="<?php echo htmlspecialchars($row['safari_id']); ?>">
                <label for="safari_name">Safari Name:</label><br>
                <input type="text" id="safari_name" name="safari_name" value="<?php echo htmlspecialchars($row['safari_name']); ?>" required><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description"><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>
                <label for="duration">Duration:</label><br>
                <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($row['duration']); ?>" required><br><br>
                <label for="price_per_person">Price per Person:</label><br>
                <input type="number" id="price_per_person" name="price_per_person" step="0.01" value="<?php echo htmlspecialchars($row['price_per_person']); ?>" required><br><br>
                <label for="max_passengers">Max Passengers:</label><br>
                <input type="number" id="max_passengers" name="max_passengers" value="<?php echo htmlspecialchars($row['max_passengers']); ?>"><br><br>
                <label for="active_status">Status:</label><br>
                <select id="active_status" name="active_status">
                    <option value="1" <?php if($row['active_status']==1) echo 'selected'; ?>>Active</option>
                    <option value="0" <?php if($row['active_status']==0) echo 'selected'; ?>>Inactive</option>
                </select><br><br>
                <button type="submit" name="edit_safari">Update Safari</button>
            </form>
        </div>
    </div>
</body>
</html> 
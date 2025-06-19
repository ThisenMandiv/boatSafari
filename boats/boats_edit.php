<?php
require_once '../connection.php';
include '../navbar.php';
if (!isset($_GET['id'])) {
    echo "<script>alert('No boat selected.'); window.location.href='boats_list.php';</script>";
    exit;
}
$boat_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM boats WHERE boat_id = ?");
$stmt->bind_param("i", $boat_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo "<script>alert('Boat not found.'); window.location.href='boats_list.php';</script>";
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
    <title>Edit Boat</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Edit Boat</h1>
            <form action="boats_process.php" method="post">
                <input type="hidden" name="boat_id" value="<?php echo htmlspecialchars($row['boat_id']); ?>">
                <label for="boat_name">Boat Name:</label><br>
                <input type="text" id="boat_name" name="boat_name" value="<?php echo htmlspecialchars($row['boat_name']); ?>" required><br><br>
                <label for="capacity">Capacity:</label><br>
                <input type="number" id="capacity" name="capacity" value="<?php echo htmlspecialchars($row['capacity']); ?>" required min="1"><br><br>
                <label for="status">Status:</label><br>
                <select id="status" name="status">
                    <option value="Available" <?php if($row['status']==='Available') echo 'selected'; ?>>Available</option>
                    <option value="Under Maintenance" <?php if($row['status']==='Under Maintenance') echo 'selected'; ?>>Under Maintenance</option>
                    <option value="Out on Safari" <?php if($row['status']==='Out on Safari') echo 'selected'; ?>>Out on Safari</option>
                </select><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description"><?php echo htmlspecialchars($row['description']); ?></textarea><br><br>
                <button type="submit" name="edit_boat">Update Boat</button>
            </form>
        </div>
    </div>
</body>
</html> 
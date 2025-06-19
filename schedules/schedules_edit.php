<?php
require_once '../connection.php';
include '../navbar.php';
if (!isset($_GET['id'])) {
    echo "<script>alert('No schedule selected.'); window.location.href='schedules_list.php';</script>";
    exit;
}
$schedule_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM schedules WHERE schedule_id = ?");
$stmt->bind_param("i", $schedule_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo "<script>alert('Schedule not found.'); window.location.href='schedules_list.php';</script>";
    exit;
}
$row = $result->fetch_assoc();
$stmt->close();
// Fetch boats
$boats = $conn->query("SELECT boat_id, boat_name FROM boats WHERE status='Available' OR boat_id=" . intval($row['boat_id']));
// Fetch safaris
$safaris = $conn->query("SELECT safari_id, safari_name, duration FROM safaris WHERE active_status=1 OR safari_id=" . intval($row['safari_id']));
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Schedule</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Edit Schedule</h1>
            <form action="schedules_process.php" method="post">
                <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($row['schedule_id']); ?>">
                <label for="boat_id">Boat:</label><br>
                <select id="boat_id" name="boat_id" required>
                    <option value="">Select Boat</option>
                    <?php while($boat = $boats->fetch_assoc()): ?>
                        <option value="<?php echo $boat['boat_id']; ?>" <?php if($row['boat_id']==$boat['boat_id']) echo 'selected'; ?>><?php echo htmlspecialchars($boat['boat_name']); ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="safari_id">Safari:</label><br>
                <select id="safari_id" name="safari_id" required>
                    <option value="">Select Safari</option>
                    <?php while($safari = $safaris->fetch_assoc()): ?>
                        <option value="<?php echo $safari['safari_id']; ?>" <?php if($row['safari_id']==$safari['safari_id']) echo 'selected'; ?>><?php echo htmlspecialchars($safari['safari_name']); ?> (<?php echo htmlspecialchars($safari['duration']); ?>)</option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="schedule_date">Date:</label><br>
                <input type="date" id="schedule_date" name="schedule_date" value="<?php echo htmlspecialchars($row['schedule_date']); ?>" required><br><br>
                <label for="start_time">Start Time:</label><br>
                <input type="time" id="start_time" name="start_time" value="<?php echo htmlspecialchars($row['start_time']); ?>" required><br><br>
                <label for="end_time">End Time:</label><br>
                <input type="time" id="end_time" name="end_time" value="<?php echo htmlspecialchars($row['end_time']); ?>" required><br><br>
                <label for="available_capacity">Available Capacity:</label><br>
                <input type="number" id="available_capacity" name="available_capacity" min="1" value="<?php echo htmlspecialchars($row['available_capacity']); ?>" required><br><br>
                <label for="status">Status:</label><br>
                <select id="status" name="status">
                    <option value="Scheduled" <?php if($row['status']==='Scheduled') echo 'selected'; ?>>Scheduled</option>
                    <option value="Completed" <?php if($row['status']==='Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Cancelled" <?php if($row['status']==='Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select><br><br>
                <button type="submit" name="edit_schedule">Update Schedule</button>
            </form>
        </div>
    </div>
</body>
</html> 
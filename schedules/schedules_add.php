<?php
require_once '../connection.php';
include '../navbar.php';
// Fetch boats
$boats = $conn->query("SELECT boat_id, boat_name FROM boats WHERE status='Available'");
// Fetch safaris
$safaris = $conn->query("SELECT safari_id, safari_name, duration FROM safaris WHERE active_status=1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Schedule</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Add New Schedule</h1>
            <form action="schedules_process.php" method="post">
                <label for="boat_id">Boat:</label><br>
                <select id="boat_id" name="boat_id" required>
                    <option value="">Select Boat</option>
                    <?php while($boat = $boats->fetch_assoc()): ?>
                        <option value="<?php echo $boat['boat_id']; ?>"><?php echo htmlspecialchars($boat['boat_name']); ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="safari_id">Safari:</label><br>
                <select id="safari_id" name="safari_id" required>
                    <option value="">Select Safari</option>
                    <?php while($safari = $safaris->fetch_assoc()): ?>
                        <option value="<?php echo $safari['safari_id']; ?>"><?php echo htmlspecialchars($safari['safari_name']); ?> (<?php echo htmlspecialchars($safari['duration']); ?>)</option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="schedule_date">Date:</label><br>
                <input type="date" id="schedule_date" name="schedule_date" required><br><br>
                <label for="start_time">Start Time:</label><br>
                <input type="time" id="start_time" name="start_time" required><br><br>
                <label for="end_time">End Time:</label><br>
                <input type="time" id="end_time" name="end_time" required><br><br>
                <label for="available_capacity">Available Capacity:</label><br>
                <input type="number" id="available_capacity" name="available_capacity" min="1" required><br><br>
                <label for="status">Status:</label><br>
                <select id="status" name="status">
                    <option value="Scheduled">Scheduled</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select><br><br>
                <button type="submit" name="add_schedule">Add Schedule</button>
            </form>
        </div>
    </div>
</body>
</html> 
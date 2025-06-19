<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'superadmin', 'staff'])) {
    echo "<script>alert('Access denied. Admin/Staff only.'); window.location.href = '/useracc/index.php';</script>";
    exit;
}
require_once '../connection.php';
include '../navbar.php';
// Fetch boats and safaris for filter dropdowns
$boats = $conn->query('SELECT boat_id, boat_name FROM boats');
$safaris = $conn->query('SELECT safari_id, safari_name FROM safaris');
// Handle search/filter
$where = [];
$params = [];
if (!empty($_GET['boat_id'])) {
    $where[] = 'sc.boat_id = ?';
    $params[] = $_GET['boat_id'];
}
if (!empty($_GET['safari_id'])) {
    $where[] = 'sc.safari_id = ?';
    $params[] = $_GET['safari_id'];
}
if (!empty($_GET['schedule_date'])) {
    $where[] = 'sc.schedule_date = ?';
    $params[] = $_GET['schedule_date'];
}
if (!empty($_GET['status'])) {
    $where[] = 'sc.status = ?';
    $params[] = $_GET['status'];
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedules List</title>
    <link rel="stylesheet" href="../css/display.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <style>
        .filter-form { margin-bottom: 24px; display: flex; flex-wrap: wrap; gap: 18px; align-items: flex-end; }
        .filter-form label { font-weight: bold; }
        .filter-form input, .filter-form select { padding: 6px 10px; border-radius: 4px; border: 1px solid #ccc; }
        .filter-form button { padding: 8px 18px; border-radius: 4px; background: #007bff; color: #fff; border: none; font-weight: bold; cursor: pointer; }
        .filter-form button:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Schedules Management</h1>
            <form class="filter-form" method="get">
                <div>
                    <label for="boat_id">Boat:</label><br>
                    <select id="boat_id" name="boat_id">
                        <option value="">All</option>
                        <?php while($boat = $boats->fetch_assoc()): ?>
                            <option value="<?php echo $boat['boat_id']; ?>" <?php if(isset($_GET['boat_id']) && $_GET['boat_id']==$boat['boat_id']) echo 'selected'; ?>><?php echo htmlspecialchars($boat['boat_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label for="safari_id">Safari:</label><br>
                    <select id="safari_id" name="safari_id">
                        <option value="">All</option>
                        <?php while($safari = $safaris->fetch_assoc()): ?>
                            <option value="<?php echo $safari['safari_id']; ?>" <?php if(isset($_GET['safari_id']) && $_GET['safari_id']==$safari['safari_id']) echo 'selected'; ?>><?php echo htmlspecialchars($safari['safari_name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label for="schedule_date">Date:</label><br>
                    <input type="date" id="schedule_date" name="schedule_date" value="<?php echo htmlspecialchars($_GET['schedule_date'] ?? ''); ?>">
                </div>
                <div>
                    <label for="status">Status:</label><br>
                    <select id="status" name="status">
                        <option value="">All</option>
                        <option value="Scheduled" <?php if(($_GET['status'] ?? '')==='Scheduled') echo 'selected'; ?>>Scheduled</option>
                        <option value="Completed" <?php if(($_GET['status'] ?? '')==='Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Cancelled" <?php if(($_GET['status'] ?? '')==='Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>
                <div>
                    <button type="submit">Search/Filter</button>
                </div>
            </form>
            <a href="schedules_add.php" class="button update-btn" style="margin-bottom:20px;display:inline-block;">Add New Schedule</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Boat</th>
                        <th>Safari</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Available Capacity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT sc.*, bo.boat_name, sa.safari_name FROM schedules sc
                        LEFT JOIN boats bo ON sc.boat_id = bo.boat_id
                        LEFT JOIN safaris sa ON sc.safari_id = sa.safari_id
                        $where_sql
                        ORDER BY sc.schedule_id DESC";
                $stmt = $conn->prepare($sql);
                if ($params) {
                    $types = str_repeat('s', count($params));
                    $stmt->bind_param($types, ...$params);
                }
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['schedule_id']}</td>";
                        echo "<td>" . htmlspecialchars($row['boat_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['safari_name']) . "</td>";
                        echo "<td>{$row['schedule_date']}</td>";
                        echo "<td>{$row['start_time']}</td>";
                        echo "<td>{$row['end_time']}</td>";
                        echo "<td>{$row['available_capacity']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>";
                        echo "<a href='schedules_edit.php?id={$row['schedule_id']}' class='button update-btn'>Edit</a> ";
                        echo "<a href='schedules_process.php?delete_id={$row['schedule_id']}' class='button delete-btn' onclick=\"return confirm('Are you sure you want to delete this schedule?');\">Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No schedules found.</td></tr>";
                }
                $stmt->close();
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html> 
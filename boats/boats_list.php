<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'superadmin', 'staff'])) {
    echo "<script>alert('Access denied. Admin/Staff only.'); window.location.href = '/useracc/index.php';</script>";
    exit;
}
require_once '../connection.php';
include '../navbar.php';
// Handle search/filter
$where = [];
$params = [];
if (!empty($_GET['boat_name'])) {
    $where[] = 'boat_name LIKE ?';
    $params[] = '%' . $_GET['boat_name'] . '%';
}
if (!empty($_GET['status'])) {
    $where[] = 'status = ?';
    $params[] = $_GET['status'];
}
if (!empty($_GET['capacity'])) {
    $where[] = 'capacity = ?';
    $params[] = $_GET['capacity'];
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boats List</title>
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
            <h1>Boats Management</h1>
            <form class="filter-form" method="get">
                <div>
                    <label for="boat_name">Boat Name:</label><br>
                    <input type="text" id="boat_name" name="boat_name" value="<?php echo htmlspecialchars($_GET['boat_name'] ?? ''); ?>">
                </div>
                <div>
                    <label for="status">Status:</label><br>
                    <select id="status" name="status">
                        <option value="">All</option>
                        <option value="Available" <?php if(($_GET['status'] ?? '')==='Available') echo 'selected'; ?>>Available</option>
                        <option value="Under Maintenance" <?php if(($_GET['status'] ?? '')==='Under Maintenance') echo 'selected'; ?>>Under Maintenance</option>
                        <option value="Out on Safari" <?php if(($_GET['status'] ?? '')==='Out on Safari') echo 'selected'; ?>>Out on Safari</option>
                    </select>
                </div>
                <div>
                    <label for="capacity">Capacity:</label><br>
                    <input type="number" id="capacity" name="capacity" value="<?php echo htmlspecialchars($_GET['capacity'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit">Search/Filter</button>
                </div>
            </form>
            <a href="boats_add.php" class="button update-btn" style="margin-bottom:20px;display:inline-block;">Add New Boat</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM boats $where_sql ORDER BY boat_id DESC";
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
                        echo "<td>{$row['boat_id']}</td>";
                        echo "<td>{$row['boat_name']}</td>";
                        echo "<td>{$row['capacity']}</td>";
                        echo "<td>{$row['status']}</td>";
                        echo "<td>{$row['description']}</td>";
                        echo "<td>";
                        echo "<a href='boats_edit.php?id={$row['boat_id']}' class='button update-btn'>Edit</a> ";
                        echo "<a href='boats_process.php?delete_id={$row['boat_id']}' class='button delete-btn' onclick=\"return confirm('Are you sure you want to delete this boat?');\">Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No boats found.</td></tr>";
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
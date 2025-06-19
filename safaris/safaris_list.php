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
if (!empty($_GET['safari_name'])) {
    $where[] = 'safari_name LIKE ?';
    $params[] = '%' . $_GET['safari_name'] . '%';
}
if (isset($_GET['active_status']) && $_GET['active_status'] !== '') {
    $where[] = 'active_status = ?';
    $params[] = $_GET['active_status'];
}
if (!empty($_GET['duration'])) {
    $where[] = 'duration LIKE ?';
    $params[] = '%' . $_GET['duration'] . '%';
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safaris List</title>
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
            <h1>Safaris Management</h1>
            <form class="filter-form" method="get">
                <div>
                    <label for="safari_name">Safari Name:</label><br>
                    <input type="text" id="safari_name" name="safari_name" value="<?php echo htmlspecialchars($_GET['safari_name'] ?? ''); ?>">
                </div>
                <div>
                    <label for="active_status">Status:</label><br>
                    <select id="active_status" name="active_status">
                        <option value="">All</option>
                        <option value="1" <?php if(($_GET['active_status'] ?? '')==='1') echo 'selected'; ?>>Active</option>
                        <option value="0" <?php if(($_GET['active_status'] ?? '')==='0') echo 'selected'; ?>>Inactive</option>
                    </select>
                </div>
                <div>
                    <label for="duration">Duration:</label><br>
                    <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($_GET['duration'] ?? ''); ?>">
                </div>
                <div>
                    <button type="submit">Search/Filter</button>
                </div>
            </form>
            <a href="safaris_add.php" class="button update-btn" style="margin-bottom:20px;display:inline-block;">Add New Safari</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Duration</th>
                        <th>Price/Person</th>
                        <th>Max Passengers</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM safaris $where_sql ORDER BY safari_id DESC";
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
                        echo "<td>{$row['safari_id']}</td>";
                        echo "<td>{$row['safari_name']}</td>";
                        echo "<td>{$row['description']}</td>";
                        echo "<td>{$row['duration']}</td>";
                        echo "<td>{$row['price_per_person']}</td>";
                        echo "<td>{$row['max_passengers']}</td>";
                        echo "<td>" . ($row['active_status'] ? 'Active' : 'Inactive') . "</td>";
                        echo "<td>";
                        echo "<a href='safaris_edit.php?id={$row['safari_id']}' class='button update-btn'>Edit</a> ";
                        echo "<a href='safaris_process.php?delete_id={$row['safari_id']}' class='button delete-btn' onclick=\"return confirm('Are you sure you want to delete this safari?');\">Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No safaris found.</td></tr>";
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
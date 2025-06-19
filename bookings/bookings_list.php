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
if (!empty($_GET['customer_name'])) {
    $where[] = 'b.customer_name LIKE ?';
    $params[] = '%' . $_GET['customer_name'] . '%';
}
if (!empty($_GET['customer_email'])) {
    $where[] = 'b.customer_email LIKE ?';
    $params[] = '%' . $_GET['customer_email'] . '%';
}
if (!empty($_GET['safari_id'])) {
    $where[] = 'b.safari_id = ?';
    $params[] = $_GET['safari_id'];
}
if (!empty($_GET['booking_status'])) {
    $where[] = 'b.booking_status = ?';
    $params[] = $_GET['booking_status'];
}
$where_sql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
// Fetch safaris for filter dropdown
$safaris = $conn->query('SELECT safari_id, safari_name FROM safaris');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings List</title>
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
            <h1>Bookings Management</h1>
            <form class="filter-form" method="get">
                <div>
                    <label for="customer_name">Customer Name:</label><br>
                    <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($_GET['customer_name'] ?? ''); ?>">
                </div>
                <div>
                    <label for="customer_email">Email:</label><br>
                    <input type="text" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($_GET['customer_email'] ?? ''); ?>">
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
                    <label for="booking_status">Status:</label><br>
                    <select id="booking_status" name="booking_status">
                        <option value="">All</option>
                        <option value="Pending" <?php if(($_GET['booking_status'] ?? '')==='Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Confirmed" <?php if(($_GET['booking_status'] ?? '')==='Confirmed') echo 'selected'; ?>>Confirmed</option>
                        <option value="Completed" <?php if(($_GET['booking_status'] ?? '')==='Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Cancelled" <?php if(($_GET['booking_status'] ?? '')==='Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>
                <div>
                    <button type="submit">Search/Filter</button>
                </div>
            </form>
            <a href="bookings_add.php" class="button update-btn" style="margin-bottom:20px;display:inline-block;">Add New Booking</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Safari</th>
                        <th>Boat</th>
                        <th>Date</th>
                        <th>Passengers</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Booked At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT b.*, s.safari_name, bo.boat_name, u.userName AS customer_user_name, u.userGmail AS customer_user_email FROM bookings b
                        LEFT JOIN safaris s ON b.safari_id = s.safari_id
                        LEFT JOIN boats bo ON b.boat_id = bo.boat_id
                        LEFT JOIN user_details u ON b.user_id = u.id
                        $where_sql
                        ORDER BY b.booked_at DESC";
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
                        echo "<td>{$row['booking_id']}</td>";
                        // Show customer name/email from user_details if not present in bookings row
                        $display_name = $row['customer_name'] ?: $row['customer_user_name'];
                        $display_email = $row['customer_email'] ?: $row['customer_user_email'];
                        echo "<td>" . htmlspecialchars($display_name) . "</td>";
                        echo "<td>" . htmlspecialchars($display_email) . "</td>";
                        echo "<td>{$row['customer_phone']}</td>";
                        echo "<td>" . htmlspecialchars($row['safari_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['boat_name']) . "</td>";
                        echo "<td>{$row['booking_date']}</td>";
                        echo "<td>{$row['num_passengers']}</td>";
                        echo "<td>{$row['total_price']}</td>";
                        echo "<td>{$row['booking_status']}</td>";
                        echo "<td>{$row['payment_status']}</td>";
                        echo "<td>{$row['booked_at']}</td>";
                        echo "<td>";
                        echo "<a href='bookings_edit.php?id={$row['booking_id']}' class='button update-btn'>Edit</a> ";
                        echo "<a href='bookings_process.php?delete_id={$row['booking_id']}' class='button delete-btn' onclick=\"return confirm('Are you sure you want to delete this booking?');\">Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No bookings found.</td></tr>";
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
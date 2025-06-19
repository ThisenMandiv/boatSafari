<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    echo "<script>alert('Please log in as a customer to view your bookings.'); window.location.href = 'login.php';</script>";
    exit;
}
require_once 'connection.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT b.*, s.safari_name FROM bookings b JOIN safaris s ON b.safari_id = s.safari_id WHERE b.user_id = ? ORDER BY b.booking_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
include 'customer_navbar.php';
?>
<div class="main-wrapper">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="./css/display.css">
    <link rel="stylesheet" href="./css/navbar.css">
</head>
<body>
<div class="main-content">
    <div class="container">
        <h2>My Bookings</h2>
        <a href="customer_book_safari.php" class="button update-btn" style="margin-bottom:20px;display:inline-block;">Book New Safari</a>
        <table>
            <thead>
                <tr>
                    <th>Safari</th>
                    <th>Date</th>
                    <th>Number of People</th>
                    <th>Notes</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['safari_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['num_people']); ?></td>
                    <td><?php echo htmlspecialchars($row['notes']); ?></td>
                    <td><?php echo htmlspecialchars($row['booking_status']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
</div>
<?php include 'footer.php'; ?>
<?php
$stmt->close();
$conn->close();
?> 
<?php
require_once '../connection.php';
include '../navbar.php';
if (!isset($_GET['id'])) {
    echo "<script>alert('No booking selected.'); window.location.href='bookings_list.php';</script>";
    exit;
}
$booking_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo "<script>alert('Booking not found.'); window.location.href='bookings_list.php';</script>";
    exit;
}
$row = $result->fetch_assoc();
$stmt->close();
// Fetch safaris
$safaris = $conn->query("SELECT safari_id, safari_name FROM safaris WHERE active_status=1");
// Fetch boats
$boats = $conn->query("SELECT boat_id, boat_name FROM boats WHERE status='Available' OR boat_id=" . intval($row['boat_id']));
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Edit Booking</h1>
            <form action="bookings_process.php" method="post">
                <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($row['booking_id']); ?>">
                <label for="customer_name">Customer Name:</label><br>
                <input type="text" id="customer_name" name="customer_name" value="<?php echo htmlspecialchars($row['customer_name']); ?>" required><br><br>
                <label for="customer_email">Customer Email:</label><br>
                <input type="email" id="customer_email" name="customer_email" value="<?php echo htmlspecialchars($row['customer_email']); ?>"><br><br>
                <label for="customer_phone">Customer Phone:</label><br>
                <input type="text" id="customer_phone" name="customer_phone" value="<?php echo htmlspecialchars($row['customer_phone']); ?>"><br><br>
                <label for="safari_id">Safari:</label><br>
                <select id="safari_id" name="safari_id" required>
                    <option value="">Select Safari</option>
                    <?php while($safari = $safaris->fetch_assoc()): ?>
                        <option value="<?php echo $safari['safari_id']; ?>" <?php if($row['safari_id']==$safari['safari_id']) echo 'selected'; ?>><?php echo htmlspecialchars($safari['safari_name']); ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="boat_id">Boat:</label><br>
                <select id="boat_id" name="boat_id">
                    <option value="">Select Boat (optional)</option>
                    <?php while($boat = $boats->fetch_assoc()): ?>
                        <option value="<?php echo $boat['boat_id']; ?>" <?php if($row['boat_id']==$boat['boat_id']) echo 'selected'; ?>><?php echo htmlspecialchars($boat['boat_name']); ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="booking_date">Booking Date:</label><br>
                <input type="date" id="booking_date" name="booking_date" value="<?php echo htmlspecialchars($row['booking_date']); ?>" required><br><br>
                <label for="num_passengers">Number of Passengers:</label><br>
                <input type="number" id="num_passengers" name="num_passengers" min="1" value="<?php echo htmlspecialchars($row['num_passengers']); ?>" required><br><br>
                <label for="total_price">Total Price:</label><br>
                <input type="number" id="total_price" name="total_price" step="0.01" value="<?php echo htmlspecialchars($row['total_price']); ?>" required><br><br>
                <label for="booking_status">Booking Status:</label><br>
                <select id="booking_status" name="booking_status">
                    <option value="Pending" <?php if($row['booking_status']==='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Confirmed" <?php if($row['booking_status']==='Confirmed') echo 'selected'; ?>>Confirmed</option>
                    <option value="Completed" <?php if($row['booking_status']==='Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Cancelled" <?php if($row['booking_status']==='Cancelled') echo 'selected'; ?>>Cancelled</option>
                </select><br><br>
                <label for="payment_status">Payment Status:</label><br>
                <select id="payment_status" name="payment_status">
                    <option value="Pending" <?php if($row['payment_status']==='Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Paid" <?php if($row['payment_status']==='Paid') echo 'selected'; ?>>Paid</option>
                    <option value="Refunded" <?php if($row['payment_status']==='Refunded') echo 'selected'; ?>>Refunded</option>
                </select><br><br>
                <button type="submit" name="edit_booking">Update Booking</button>
            </form>
        </div>
    </div>
</body>
</html> 
<?php
require_once '../connection.php';
include '../navbar.php';
// Fetch safaris
$safaris = $conn->query("SELECT safari_id, safari_name FROM safaris WHERE active_status=1");
// Fetch boats
$boats = $conn->query("SELECT boat_id, boat_name FROM boats WHERE status='Available'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Booking</title>
    <link rel="stylesheet" href="../css/insert.css">
    <link rel="stylesheet" href="../css/navbar.css">
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Add New Booking</h1>
            <form action="bookings_process.php" method="post">
                <label for="customer_name">Customer Name:</label><br>
                <input type="text" id="customer_name" name="customer_name" required><br><br>
                <label for="customer_email">Customer Email:</label><br>
                <input type="email" id="customer_email" name="customer_email"><br><br>
                <label for="customer_phone">Customer Phone:</label><br>
                <input type="text" id="customer_phone" name="customer_phone"><br><br>
                <label for="safari_id">Safari:</label><br>
                <select id="safari_id" name="safari_id" required>
                    <option value="">Select Safari</option>
                    <?php while($safari = $safaris->fetch_assoc()): ?>
                        <option value="<?php echo $safari['safari_id']; ?>"><?php echo htmlspecialchars($safari['safari_name']); ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="boat_id">Boat:</label><br>
                <select id="boat_id" name="boat_id">
                    <option value="">Select Boat (optional)</option>
                    <?php while($boat = $boats->fetch_assoc()): ?>
                        <option value="<?php echo $boat['boat_id']; ?>"><?php echo htmlspecialchars($boat['boat_name']); ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <label for="booking_date">Booking Date:</label><br>
                <input type="date" id="booking_date" name="booking_date" required><br><br>
                <label for="num_passengers">Number of Passengers:</label><br>
                <input type="number" id="num_passengers" name="num_passengers" min="1" required><br><br>
                <label for="total_price">Total Price:</label><br>
                <input type="number" id="total_price" name="total_price" step="0.01" required><br><br>
                <label for="booking_status">Booking Status:</label><br>
                <select id="booking_status" name="booking_status">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select><br><br>
                <label for="payment_status">Payment Status:</label><br>
                <select id="payment_status" name="payment_status">
                    <option value="Pending">Pending</option>
                    <option value="Paid">Paid</option>
                    <option value="Refunded">Refunded</option>
                </select><br><br>
                <button type="submit" name="add_booking">Add Booking</button>
            </form>
        </div>
    </div>
</body>
</html> 
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    echo "<script>alert('Please log in as a customer to book a safari.'); window.location.href = 'login.php';</script>";
    exit;
}
require_once 'connection.php';
// Fetch available safaris
$safaris = $conn->query("SELECT safari_id, safari_name FROM safaris WHERE active_status = 1");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $safari_id = $_POST['safari_id'];
    $date = $_POST['date'];
    $num_people = $_POST['num_people'];
    $notes = $_POST['notes'];
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, safari_id, booking_date, num_people, notes, booking_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
    $stmt->bind_param('iisds', $user_id, $safari_id, $date, $num_people, $notes);
    if ($stmt->execute()) {
        echo "<script>alert('Safari booked successfully!'); window.location.href = 'customer_bookings.php';</script>";
    } else {
        echo "<script>alert('Error booking safari: {$conn->error}');</script>";
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Safari</title>
    <link rel="stylesheet" href="./css/insert.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <style>
        .main-wrapper {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .form-container {
            background: #fff;
            padding: 32px 32px 24px 32px;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 400px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 24px;
        }
        .form-container form label {
            display: block;
            margin-top: 12px;
            margin-bottom: 4px;
        }
        .form-container form input,
        .form-container form select,
        .form-container form textarea {
            width: 100%;
            padding: 8px 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        .form-container form button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .form-container form button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
<?php include 'customer_navbar.php'; ?>
<div class="main-wrapper">
    <div class="form-container">
        <h2>Book a Safari</h2>
        <form method="post">
            <label for="safari_id">Safari:</label>
            <select name="safari_id" id="safari_id" required>
                <option value="">Select Safari</option>
                <?php foreach ($safaris as $safari): ?>
                    <option value="<?php echo $safari['safari_id']; ?>"><?php echo htmlspecialchars($safari['safari_name']); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" required>
            <label for="num_people">Number of People:</label>
            <input type="number" name="num_people" id="num_people" min="1" required>
            <label for="notes">Notes (optional):</label>
            <textarea name="notes" id="notes" rows="3"></textarea>
            <button type="submit">Book Safari</button>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>
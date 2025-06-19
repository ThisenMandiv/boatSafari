<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'superadmin'])) {
    echo "<script>alert('Access denied. Admins only.'); window.location.href = 'index.php';</script>";
    exit;
}
require_once 'connection.php';
include 'navbar.php';
// Get stats
$boats = $conn->query('SELECT COUNT(*) as total FROM boats')->fetch_assoc()['total'];
$safaris = $conn->query('SELECT COUNT(*) as total FROM safaris')->fetch_assoc()['total'];
$bookings = $conn->query('SELECT COUNT(*) as total FROM bookings')->fetch_assoc()['total'];
$schedules = $conn->query('SELECT COUNT(*) as total FROM schedules')->fetch_assoc()['total'];
$users = $conn->query('SELECT COUNT(*) as total FROM user_details')->fetch_assoc()['total'];
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./css/display.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <style>
        .dashboard-container {
            margin: 40px auto 0 auto;
            max-width: 900px;
            display: flex;
            flex-wrap: wrap;
            gap: 32px;
            justify-content: center;
        }
        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 32px 36px;
            width: 220px;
            text-align: center;
        }
        .dashboard-card h2 {
            margin: 0 0 10px 0;
            color: #007bff;
            font-size: 2.2em;
        }
        .dashboard-card p {
            color: #444;
            font-size: 1.1em;
        }
        .switch-btn {
            display: inline-block;
            margin: 40px auto 0 auto;
            background: #007bff;
            color: #fff;
            padding: 14px 36px;
            border-radius: 6px;
            font-size: 1.1em;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background 0.2s;
        }
        .switch-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="container">
            <h1>Admin Dashboard</h1>
            <div class="dashboard-container">
                <div class="dashboard-card">
                    <h2><?php echo $boats; ?></h2>
                    <p>Total Boats</p>
                </div>
                <div class="dashboard-card">
                    <h2><?php echo $safaris; ?></h2>
                    <p>Total Safaris</p>
                </div>
                <div class="dashboard-card">
                    <h2><?php echo $bookings; ?></h2>
                    <p>Total Bookings</p>
                </div>
                <div class="dashboard-card">
                    <h2><?php echo $schedules; ?></h2>
                    <p>Total Schedules</p>
                </div>
                <div class="dashboard-card">
                    <h2><?php echo $users; ?></h2>
                    <p>Total Users</p>
                </div>
            </div>
            <div style="text-align:center;">
                <a href="/useracc/index.php" class="switch-btn">Switch to Customer Side</a>
            </div>
        </div>
    </div>
</body>
</html> 
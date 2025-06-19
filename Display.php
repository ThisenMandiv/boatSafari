<?php
session_start();
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'superadmin', 'staff'])) {
    echo "<script>alert('Access denied. Admin/Staff only.'); window.location.href = 'index.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Data Display Page</title>
    <link rel="stylesheet" href="./css/display.css">
    <link rel="stylesheet" href="./css/navbar.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="main-content">
        <div class="container">
            <h1>User Data Display Page</h1>
            <table>
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Gmail</th>
                        <th>User Password</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the PHP file that generates only the table rows
                    include 'display.inc.php';
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
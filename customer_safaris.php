<?php
require_once 'connection.php';
include 'customer_navbar.php';
?>
<div class="main-wrapper">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Safaris</title>
    <link rel="stylesheet" href="./css/display.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <style>
        .safaris-container { max-width: 1000px; margin: 40px auto; background: #fff; padding: 32px 28px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .safaris-container h2 { color: #007bff; text-align: center; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-top: 18px; }
        th, td { padding: 14px 12px; border-bottom: 1px solid #e0e6ed; text-align: left; }
        th { background: #007bff; color: #fff; }
        tr:last-child td { border-bottom: none; }
        .status-active { color: #28a745; font-weight: bold; }
        .status-inactive { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="safaris-container">
        <h2>Available Safaris</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Price/Person</th>
                    <th>Max Passengers</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM safaris ORDER BY safari_id DESC");
                if ($result && $result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['safari_name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['description']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['duration']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['price_per_person']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['max_passengers']) . '</td>';
                        echo '<td>';
                        if ($row['active_status']) {
                            echo '<span class="status-active">Active</span>';
                        } else {
                            echo '<span class="status-inactive">Inactive</span>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No safaris available.</td></tr>';
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
</div>
<?php include 'footer.php'; ?> 
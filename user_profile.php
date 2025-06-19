<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please log in to view your profile.'); window.location.href = 'login.php';</script>";
    exit;
}
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows !== 1) {
    echo "<script>alert('User not found.'); window.location.href = 'index.php';</script>";
    exit;
}
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
include 'customer_navbar.php';
?>
<div class="main-wrapper">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="./css/insert.css">
    <link rel="stylesheet" href="./css/navbar.css">
    <style>
        .profile-container {
            background: #fff;
            max-width: 500px;
            margin: 40px auto;
            padding: 32px 28px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .profile-container h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 24px;
        }
        .profile-details {
            margin-bottom: 28px;
        }
        .profile-details label {
            font-weight: bold;
            color: #333;
        }
        .profile-details p {
            margin: 0 0 16px 0;
            color: #444;
        }
        .profile-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
        }
        .profile-actions a, .profile-actions form button {
            padding: 10px 22px;
            border-radius: 4px;
            border: none;
            font-weight: bold;
            font-size: 1em;
            cursor: pointer;
            text-decoration: none;
            color: #fff;
        }
        .update-btn { background: #28a745; }
        .update-btn:hover { background: #218838; }
        .delete-btn { background: #dc3545; }
        .delete-btn:hover { background: #c82333; }
        .logout-btn { background: #007bff; }
        .logout-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="profile-container">
        <h2>My Profile</h2>
        <div class="profile-details">
            <label>User Name:</label>
            <p><?php echo htmlspecialchars($user['userName']); ?></p>
            <label>Email:</label>
            <p><?php echo htmlspecialchars($user['userGmail']); ?></p>
            <label>Role:</label>
            <p><?php echo htmlspecialchars($user['role']); ?></p>
        </div>
        <div class="profile-actions">
            <a href="update.php?id=<?php echo $user['id']; ?>" class="update-btn">Update</a>
            <form action="delete.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete your account?');">Delete</button>
            </form>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
</body>
</html>
</div>
<?php include 'footer.php'; ?> 
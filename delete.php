<?php
require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM user_details WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href = 'Display.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: {$conn->error}'); window.location.href = 'Display.php';</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'Display.php';</script>";
}
?> 
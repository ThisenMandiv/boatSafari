<?php
require_once '../connection.php';

// Add Boat
if (isset($_POST['add_boat'])) {
    $boat_name = $_POST['boat_name'];
    $capacity = intval($_POST['capacity']);
    $status = $_POST['status'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO boats (boat_name, capacity, status, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $boat_name, $capacity, $status, $description);
    if ($stmt->execute()) {
        echo "<script>alert('Boat added successfully!'); window.location.href='boats_list.php';</script>";
    } else {
        echo "<script>alert('Error adding boat: {$conn->error}'); window.location.href='boats_add.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Edit Boat
if (isset($_POST['edit_boat'])) {
    $boat_id = intval($_POST['boat_id']);
    $boat_name = $_POST['boat_name'];
    $capacity = intval($_POST['capacity']);
    $status = $_POST['status'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("UPDATE boats SET boat_name=?, capacity=?, status=?, description=? WHERE boat_id=?");
    $stmt->bind_param("sissi", $boat_name, $capacity, $status, $description, $boat_id);
    if ($stmt->execute()) {
        echo "<script>alert('Boat updated successfully!'); window.location.href='boats_list.php';</script>";
    } else {
        echo "<script>alert('Error updating boat: {$conn->error}'); window.location.href='boats_edit.php?id=$boat_id';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Delete Boat
if (isset($_GET['delete_id'])) {
    $boat_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM boats WHERE boat_id=?");
    $stmt->bind_param("i", $boat_id);
    if ($stmt->execute()) {
        echo "<script>alert('Boat deleted successfully!'); window.location.href='boats_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting boat: {$conn->error}'); window.location.href='boats_list.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// If no valid action
header('Location: boats_list.php');
exit; 
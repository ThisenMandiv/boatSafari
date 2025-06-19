<?php
require_once '../connection.php';

// Add Safari
if (isset($_POST['add_safari'])) {
    $safari_name = $_POST['safari_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price_per_person = floatval($_POST['price_per_person']);
    $max_passengers = $_POST['max_passengers'] !== '' ? intval($_POST['max_passengers']) : null;
    $active_status = intval($_POST['active_status']);
    $stmt = $conn->prepare("INSERT INTO safaris (safari_name, description, duration, price_per_person, max_passengers, active_status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $safari_name, $description, $duration, $price_per_person, $max_passengers, $active_status);
    if ($stmt->execute()) {
        echo "<script>alert('Safari added successfully!'); window.location.href='safaris_list.php';</script>";
    } else {
        echo "<script>alert('Error adding safari: {$conn->error}'); window.location.href='safaris_add.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Edit Safari
if (isset($_POST['edit_safari'])) {
    $safari_id = intval($_POST['safari_id']);
    $safari_name = $_POST['safari_name'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price_per_person = floatval($_POST['price_per_person']);
    $max_passengers = $_POST['max_passengers'] !== '' ? intval($_POST['max_passengers']) : null;
    $active_status = intval($_POST['active_status']);
    $stmt = $conn->prepare("UPDATE safaris SET safari_name=?, description=?, duration=?, price_per_person=?, max_passengers=?, active_status=? WHERE safari_id=?");
    $stmt->bind_param("sssdisi", $safari_name, $description, $duration, $price_per_person, $max_passengers, $active_status, $safari_id);
    if ($stmt->execute()) {
        echo "<script>alert('Safari updated successfully!'); window.location.href='safaris_list.php';</script>";
    } else {
        echo "<script>alert('Error updating safari: {$conn->error}'); window.location.href='safaris_edit.php?id=$safari_id';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Delete Safari
if (isset($_GET['delete_id'])) {
    $safari_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM safaris WHERE safari_id=?");
    $stmt->bind_param("i", $safari_id);
    if ($stmt->execute()) {
        echo "<script>alert('Safari deleted successfully!'); window.location.href='safaris_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting safari: {$conn->error}'); window.location.href='safaris_list.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// If no valid action
header('Location: safaris_list.php');
exit; 
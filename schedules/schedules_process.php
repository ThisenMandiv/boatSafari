<?php
require_once '../connection.php';

// Add Schedule
if (isset($_POST['add_schedule'])) {
    $boat_id = intval($_POST['boat_id']);
    $safari_id = intval($_POST['safari_id']);
    $schedule_date = $_POST['schedule_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $available_capacity = intval($_POST['available_capacity']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("INSERT INTO schedules (boat_id, safari_id, schedule_date, start_time, end_time, available_capacity, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssis", $boat_id, $safari_id, $schedule_date, $start_time, $end_time, $available_capacity, $status);
    if ($stmt->execute()) {
        echo "<script>alert('Schedule added successfully!'); window.location.href='schedules_list.php';</script>";
    } else {
        echo "<script>alert('Error adding schedule: {$conn->error}'); window.location.href='schedules_add.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Edit Schedule
if (isset($_POST['edit_schedule'])) {
    $schedule_id = intval($_POST['schedule_id']);
    $boat_id = intval($_POST['boat_id']);
    $safari_id = intval($_POST['safari_id']);
    $schedule_date = $_POST['schedule_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $available_capacity = intval($_POST['available_capacity']);
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE schedules SET boat_id=?, safari_id=?, schedule_date=?, start_time=?, end_time=?, available_capacity=?, status=? WHERE schedule_id=?");
    $stmt->bind_param("iisssisi", $boat_id, $safari_id, $schedule_date, $start_time, $end_time, $available_capacity, $status, $schedule_id);
    if ($stmt->execute()) {
        echo "<script>alert('Schedule updated successfully!'); window.location.href='schedules_list.php';</script>";
    } else {
        echo "<script>alert('Error updating schedule: {$conn->error}'); window.location.href='schedules_edit.php?id=$schedule_id';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Delete Schedule
if (isset($_GET['delete_id'])) {
    $schedule_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM schedules WHERE schedule_id=?");
    $stmt->bind_param("i", $schedule_id);
    if ($stmt->execute()) {
        echo "<script>alert('Schedule deleted successfully!'); window.location.href='schedules_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting schedule: {$conn->error}'); window.location.href='schedules_list.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// If no valid action
header('Location: schedules_list.php');
exit; 
<?php
require_once '../connection.php';

// Add Booking
if (isset($_POST['add_booking'])) {
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $safari_id = intval($_POST['safari_id']);
    $boat_id = $_POST['boat_id'] !== '' ? intval($_POST['boat_id']) : null;
    $booking_date = $_POST['booking_date'];
    $num_passengers = intval($_POST['num_passengers']);
    $total_price = floatval($_POST['total_price']);
    $booking_status = $_POST['booking_status'];
    $payment_status = $_POST['payment_status'];
    $stmt = $conn->prepare("INSERT INTO bookings (customer_name, customer_email, customer_phone, safari_id, boat_id, booking_date, num_passengers, total_price, booking_status, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssiiisdss", $customer_name, $customer_email, $customer_phone, $safari_id, $boat_id, $booking_date, $num_passengers, $total_price, $booking_status, $payment_status);
    if ($stmt->execute()) {
        echo "<script>alert('Booking added successfully!'); window.location.href='bookings_list.php';</script>";
    } else {
        echo "<script>alert('Error adding booking: {$conn->error}'); window.location.href='bookings_add.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Edit Booking
if (isset($_POST['edit_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    $customer_name = $_POST['customer_name'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $safari_id = intval($_POST['safari_id']);
    $boat_id = $_POST['boat_id'] !== '' ? intval($_POST['boat_id']) : null;
    $booking_date = $_POST['booking_date'];
    $num_passengers = intval($_POST['num_passengers']);
    $total_price = floatval($_POST['total_price']);
    $booking_status = $_POST['booking_status'];
    $payment_status = $_POST['payment_status'];
    $stmt = $conn->prepare("UPDATE bookings SET customer_name=?, customer_email=?, customer_phone=?, safari_id=?, boat_id=?, booking_date=?, num_passengers=?, total_price=?, booking_status=?, payment_status=? WHERE booking_id=?");
    $stmt->bind_param("sssiiisdssi", $customer_name, $customer_email, $customer_phone, $safari_id, $boat_id, $booking_date, $num_passengers, $total_price, $booking_status, $payment_status, $booking_id);
    if ($stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='bookings_list.php';</script>";
    } else {
        echo "<script>alert('Error updating booking: {$conn->error}'); window.location.href='bookings_edit.php?id=$booking_id';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// Delete Booking
if (isset($_GET['delete_id'])) {
    $booking_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE booking_id=?");
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='bookings_list.php';</script>";
    } else {
        echo "<script>alert('Error deleting booking: {$conn->error}'); window.location.href='bookings_list.php';</script>";
    }
    $stmt->close();
    $conn->close();
    exit;
}

// If no valid action
header('Location: bookings_list.php');
exit; 
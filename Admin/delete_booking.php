<?php
include_once('db_config.php');
session_start();

// Auth check
if (!isset($_SESSION['full_name'])) {
    header('Location: index.php');
    exit;
}

// Validate booking ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "Invalid booking ID.";
    header('Location: booking.php');
    exit;
}

$booking_id = (int) $_GET['id'];


// Check if booking exists
$stmt_check = $conn->prepare(
    "SELECT booking_id FROM bookings WHERE booking_id = ?"
);
$stmt_check->bind_param("i", $booking_id);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Booking not found.";
    $stmt_check->close();
    header('Location: booking.php');
    exit;
}
$stmt_check->close();


// Delete booking
$stmt = $conn->prepare(
    "DELETE FROM bookings WHERE booking_id = ?"
);
$stmt->bind_param("i", $booking_id);

if ($stmt->execute()) {
    $_SESSION['success'] = "Booking deleted successfully.";
} else {
    $_SESSION['error'] = "Failed to delete booking.";
}

$stmt->close();
$conn->close();

header('Location: booking.php');
exit;

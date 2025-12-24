<?php
include_once('db_config.php');
session_start();

// Temporary customer id (replace with login session)
$customer_id = 1;

if(!isset($_POST['room_id'], $_POST['nights'], $_POST['price'])){
    header("Location: room.php");
    exit;
}

$room_id = (int)$_POST['room_id'];
$nights  = (int)$_POST['nights'];
$price   = (float)$_POST['price'];

// Check room availability
$res = $conn->query("SELECT status FROM rooms WHERE room_id=$room_id");
$room = $res->fetch_assoc();
if(!$room || $room['status'] != 'Available'){
    die("Room not available");
}

// Prepare booking data
$check_in = date('Y-m-d');
$check_out = date('Y-m-d', strtotime("+$nights days"));
$total_price = $price * $nights;

// Insert booking
$sql = "INSERT INTO bookings (room_id, customer_id, check_in, check_out, total_price, booking_status)
        VALUES ($room_id, $customer_id, '$check_in', '$check_out', $total_price, 'Booked')";

if($conn->query($sql)){
    // Update room status
    $conn->query("UPDATE rooms SET status='Occupied' WHERE room_id=$room_id");

    // Redirect
    header("Location: booking-success.php");
    exit;
}else{
    echo "Booking failed: ".$conn->error;
}

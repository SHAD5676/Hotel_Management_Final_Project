<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['full_name'])){
    header('location:index.php');
    exit;
}

if(!isset($_GET['id'], $_GET['status'])){
    header('location:check_in_out.php');
    exit;
}

$id = (int)$_GET['id'];
$status = $_GET['status'];

// Update booking status
$conn->query("UPDATE bookings SET booking_status='$status' WHERE booking_id=$id");

// Update room status accordingly
if($status == 'Checked In'){
    $conn->query("UPDATE rooms r
                  JOIN bookings b ON r.room_id = b.room_id
                  SET r.status='Occupied'
                  WHERE b.booking_id=$id");
} elseif($status == 'Checked Out'){
    $conn->query("UPDATE rooms r
                  JOIN bookings b ON r.room_id = b.room_id
                  SET r.status='Available'
                  WHERE b.booking_id=$id");
}

header("Location: check_in_out.php");
exit;

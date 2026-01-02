<?php
include_once('db_config.php');

$booking_id = $_POST['booking_id'];
$total_amount = $_POST['total_amount'];
$payment_method = $_POST['payment_method'];

$sql = "INSERT INTO bills (booking_id, total_amount, payment_method) 
        VALUES ($booking_id, $total_amount, '$payment_method')";
mysqli_query($conn, $sql);

header("Location: bills.php");
exit;

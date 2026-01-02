<?php
include_once('db_config.php');
$bill_id = $_GET['id'];

$sql = "
SELECT bl.bill_id, bl.total_amount, bl.payment_method, bl.created_at,
       b.check_in, b.check_out, r.room_number, c.name AS customer_name
FROM bills bl
JOIN bookings b ON bl.booking_id = b.booking_id
LEFT JOIN rooms r ON b.room_id = r.room_id
LEFT JOIN customers c ON b.customer_id = c.customer_id
WHERE bl.bill_id = $bill_id
";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if(!$data){ die("Invalid Bill ID"); }
?>

<h2>Hotel Invoice</h2>
<hr>
<p><b>Invoice ID:</b> <?= $data['bill_id'] ?></p>
<p><b>Date:</b> <?= $data['created_at'] ?></p>
<p><b>Guest:</b> <?= $data['customer_name'] ?></p>
<p><b>Room:</b> <?= $data['room_number'] ?></p>
<p><b>Check In:</b> <?= $data['check_in'] ?></p>
<p><b>Check Out:</b> <?= $data['check_out'] ?></p>
<h3>Total Paid: <?= $data['total_amount'] ?> ৳</h3>
<p><b>Payment Method:</b> <?= $data['payment_method'] ?></p>

<button onclick="window.print()">Print Invoice</button>

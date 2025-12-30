<?php
include_once('db_config.php');

$id = $_GET['id'];
$sql = "SELECT * FROM bills WHERE bill_id = $id";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bill Invoice</title>
  <style>
    body { font-family: Arial; }
    table { width: 50%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 8px; }
  </style>
</head>

<body>
<h2>Hotel Bill</h2>
<hr>

<p><strong>Bill ID:</strong> <?= $row['bill_id'] ?></p>
<p><strong>Booking ID:</strong> <?= $row['booking_id'] ?></p>
<p><strong>Date:</strong> <?= $row['bill_date'] ?></p>

<table>
<tr>
  <th>Total Amount</th>
  <td><?= $row['total_amount'] ?> ৳</td>
</tr>
<tr>
  <th>Status</th>
  <td><?= $row['bill_status'] ?></td>
</tr>
</table>

<br>
<button onclick="window.print()">Print Bill</button>
</body>
</html>

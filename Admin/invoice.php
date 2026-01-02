<?php
include_once('db_config.php');
$booking_id = $_GET['booking_id'];

$sql = "
SELECT b.booking_id, b.check_in, b.check_out, b.total_price,
       r.room_number, c.name AS customer_name
FROM bookings b
LEFT JOIN rooms r ON b.room_id = r.room_id
LEFT JOIN customers c ON b.customer_id = c.customer_id
WHERE b.booking_id = $booking_id
";

$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);

if(!$data){ die("Invalid Booking ID"); }
?>

<!DOCTYPE html>
<html>
<head><title>Generate Invoice</title></head>
<body>
<h2>Invoice</h2>
<hr>
<p><b>Guest:</b> <?= $data['customer_name'] ?></p>
<p><b>Room:</b> <?= $data['room_number'] ?></p>
<p><b>Check In:</b> <?= $data['check_in'] ?></p>
<p><b>Check Out:</b> <?= $data['check_out'] ?></p>
<h3>Total Amount: <?= $data['total_price'] ?> ৳</h3>

<form method="post" action="save_bill.php">
    <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
    <input type="hidden" name="total_amount" value="<?= $data['total_price'] ?>">
    <label>Payment Method:</label><br>
    <select name="payment_method" required>
        <option value="">Select</option>
        <option value="Cash">Cash</option>
        <option value="Card">Card</option>
        <option value="Mobile Banking">Mobile Banking</option>
    </select>
    <br><br>
    <button type="submit">Confirm & Generate Bill</button>
</form>
</body>
</html>

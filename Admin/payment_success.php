<?php
include_once('db_config.php');

if (!isset($_GET['bill_id'])) {
    die("Invalid access");
}

$bill_id = $_GET['bill_id'];

$update = "
UPDATE bills 
SET payment_method='Stripe', created_at=NOW() 
WHERE bill_id='$bill_id'
";

mysqli_query($conn, $update);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Payment Success</title>
</head>
<body>

<h2>Payment Successful</h2>
<p>Your bill has been paid successfully.</p>

<a href="print_bill.php?id=<?= $bill_id ?>">Print Invoice</a><br><br>
<a href="bills.php">Back to Bills</a>

</body>
</html>

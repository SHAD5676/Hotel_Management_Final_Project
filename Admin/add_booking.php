<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

$message='';

if(isset($_POST['submit'])){
    $room_id = (int)$_POST['room_id'];
    $customer_id = (int)$_POST['customer_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $total_price = $_POST['total_price'];
    $booking_status = $_POST['booking_status'];

    if($room_id && $customer_id && $check_in && $booking_status){
        $sql = "INSERT INTO bookings (room_id, customer_id, check_in, check_out, total_price, booking_status)
                VALUES ('$room_id','$customer_id','$check_in','$check_out','$total_price','$booking_status')";

        if($conn->query($sql)){
            $conn->query("UPDATE rooms SET status='Occupied' WHERE room_id='$room_id'");
            $_SESSION['success']="Booking added successfully!";
            header("Location: booking.php");
            exit;
        } else {
            $message="<div class='alert alert-danger'>Error: {$conn->error}</div>";
        }
    } else {
        $message="<div class='alert alert-warning'>All required fields needed</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Booking</title>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Add Booking</h3>

<?= $message ?>

<form method="post">
<div class="form-group">
<label>Room</label>
<select name="room_id" class="form-control" required>
<option value="">Select Room</option>
<?php
$rooms = $conn->query("SELECT room_id, room_number FROM rooms");
while($r=$rooms->fetch_assoc()){
    echo "<option value='{$r['room_id']}'>{$r['room_number']}</option>";
}
?>
</select>
</div>

<div class="form-group">
<label>Customer ID</label>
<input type="number" name="customer_id" class="form-control" required>
</div>

<div class="form-group">
<label>Check In</label>
<input type="date" name="check_in" class="form-control" required>
</div>

<div class="form-group">
<label>Check Out</label>
<input type="date" name="check_out" class="form-control">
</div>

<div class="form-group">
<label>Total Price</label>
<input type="number" name="total_price" class="form-control">
</div>

<div class="form-group">
<label>Status</label>
<select name="booking_status" class="form-control" required>
<option value="Checked In">Checked In</option>
<option value="Checked Out">Checked Out</option>
</select>
</div>

<button type="submit" name="submit" class="btn btn-primary">Save</button>
<a href="booking.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
</body>
</html>

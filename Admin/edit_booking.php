<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('location:booking.php');
    exit;
}

$id = (int)$_GET['id'];
$message = '';

$res = $conn->query("SELECT * FROM bookings WHERE booking_id=$id");
if($res->num_rows==0){
    header('location:booking.php');
    exit;
}
$book = $res->fetch_assoc();

if(isset($_POST['submit'])){
    $check_out = $_POST['check_out'];
    $total_price = $_POST['total_price'];
    $booking_status = $_POST['booking_status'];

    $sql = "UPDATE bookings SET
            check_out='$check_out',
            total_price='$total_price',
            booking_status='$booking_status'
            WHERE booking_id='$id'";

    if($conn->query($sql)){
        $_SESSION['success']="Booking updated!";
        header("Location: booking.php");
        exit;
    }else{
        $message="<div class='alert alert-danger'>Error: {$conn->error}</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Edit Booking</h3>

<?= $message ?>

<form method="post">
  <div class="form-group">
    <label>Check Out</label>
    <input type="date" name="check_out" value="<?= $book['check_out'] ?>" class="form-control">
  </div>

  <div class="form-group">
    <label>Total Price</label>
    <input type="number" name="total_price" value="<?= $book['total_price'] ?>" class="form-control">
  </div>

  <div class="form-group">
    <label>Status</label>
    <select name="booking_status" class="form-control">
      <option value="Checked In" <?= $book['booking_status']=='Checked In'?'selected':'' ?>>Checked In</option>
      <option value="Checked Out" <?= $book['booking_status']=='Checked Out'?'selected':'' ?>>Checked Out</option>
    </select>
  </div>

  <button type="submit" name="submit" class="btn btn-primary">Update</button>
  <a href="booking.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
</body>
</html>

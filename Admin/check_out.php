<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

// Handle Check Out form submission
if(isset($_POST['check_out'])){
    $booking_id = $_POST['booking_id'];

    // Fetch booking details
    $stmt = $conn->prepare("SELECT booking_id, room_id, customer_id, total_price FROM bookings WHERE booking_id=?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $booking = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if($booking){
        // Insert bill
        $stmt = $conn->prepare("INSERT INTO bills (booking_id, total_amount, payment_method, created_at) VALUES (?, ?, ?, NOW())");
        $payment_method = 'Unpaid';
        $stmt->bind_param("ids", $booking['booking_id'], $booking['total_price'], $payment_method);
        $stmt->execute();
        $stmt->close();

        // Update booking status
        $stmt = $conn->prepare("UPDATE bookings SET booking_status='Checked Out' WHERE booking_id=?");
        $stmt->bind_param("i", $booking['booking_id']);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Booking checked out and bill created successfully!";
    } else {
        $_SESSION['error'] = "Booking not found!";
    }

    header('location:check_out.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Check Out</title>
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("includes/navbar.php"); ?>

  <!-- Left Sidebar -->
  <?php include("includes/leftbar.php"); ?>

  <div class="content-wrapper p-4">
    <h3>Check Out</h3>

    <?php
    if(isset($_SESSION['success'])){
        echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']);
    }
    if(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
        unset($_SESSION['error']);
    }
    ?>

    <!-- Checked In Bookings Table -->
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Booking ID</th>
          <th>Room</th>
          <th>Customer ID</th>
          <th>Total Price</th>
          <th>Check In</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $res = $conn->query("SELECT booking_id, room_id, customer_id, total_price, check_in 
                             FROM bookings 
                             WHERE booking_status='Checked In'
                             ORDER BY booking_id DESC");

        if($res->num_rows > 0){
            $i=1;
            while($row = $res->fetch_assoc()){
                echo "<tr>
                        <td>{$i}</td>
                        <td>{$row['booking_id']}</td>
                        <td>{$row['room_id']}</td>
                        <td>{$row['customer_id']}</td>
                        <td>{$row['total_price']} ৳</td>
                        <td>{$row['check_in']}</td>
                        <td>
                          <form method='post'>
                            <input type='hidden' name='booking_id' value='{$row['booking_id']}'>
                            <button type='submit' name='check_out' class='btn btn-sm btn-primary'>Check Out</button>
                          </form>
                        </td>
                      </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='7' class='text-center'>No Checked In Bookings</td></tr>";
        }
        ?>
      </tbody>
    </table>

  </div> <!-- /.content-wrapper -->

  <!-- Footer -->
  <?php include("includes/footer.php"); ?>

</div> <!-- /.wrapper -->

<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

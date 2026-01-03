<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>All Bills</title>
 
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("includes/navbar.php"); ?>

  <!-- Left Sidebar -->
  <?php include("includes/leftbar.php"); ?>

  
  <div class="content-wrapper p-4">

    <h3>All Bills</h3>

    <?php
    $sql = "
    SELECT bl.bill_id, bl.booking_id, bl.total_amount, bl.payment_method, bl.created_at,
           r.room_number, c.name AS customer_name
    FROM bills bl
    LEFT JOIN bookings b ON bl.booking_id = b.booking_id
    LEFT JOIN rooms r ON b.room_id = r.room_id
    LEFT JOIN customers c ON b.customer_id = c.customer_id
    ORDER BY bl.bill_id DESC
    ";
    $result = mysqli_query($conn, $sql);
    ?>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Bill ID</th>
          <th>Booking ID</th>
          <th>Guest</th>
          <th>Room</th>
          <th>Total</th>
          <th>Payment</th>
          <th>Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>
                        <td>{$row['bill_id']}</td>
                        <td>{$row['booking_id']}</td>
                        <td>{$row['customer_name']}</td>
                        <td>{$row['room_number']}</td>
                        <td>{$row['total_amount']} ৳</td>
                        <td>{$row['payment_method']}</td>
                        <td>{$row['created_at']}</td>
                       <td>
  <a href='print_bill.php?id={$row['bill_id']}' class='btn btn-sm btn-primary'>
    <i class='fas fa-print'></i> Print
  </a>
  <a href='pay_bill.php?id={$row['bill_id']}' class='btn btn-success btn-sm'>
    Pay Now
  </a>
</td>

                      </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='8' class='text-center'>No bills found</td></tr>";
        }
        ?>
      </tbody>
    </table>

  </div> 

  <!-- Footer -->
  <?php include("includes/footer.php"); ?>

</div> 


<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

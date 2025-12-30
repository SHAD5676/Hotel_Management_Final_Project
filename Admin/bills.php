<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

$sql = "SELECT * FROM bills ORDER BY bill_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Bills</title>
  <?php include('includes/header.php'); ?>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include('includes/sidebar.php'); ?>

<div class="content-wrapper">
<section class="content-header">
  <h1>Bills</h1>
</section>

<section class="content">
<div class="card">
<div class="card-body">

<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>Bill ID</th>
  <th>Booking ID</th>
  <th>Total</th>
  <th>Status</th>
  <th>Date</th>
  <th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = mysqli_fetch_assoc($result)) { ?>
<tr>
  <td><?= $row['bill_id'] ?></td>
  <td><?= $row['booking_id'] ?></td>
  <td><?= $row['total_amount'] ?> ৳</td>
  <td>
    <?php if($row['bill_status']=='Paid'){ ?>
      <span class="badge badge-success">Paid</span>
    <?php } elseif($row['bill_status']=='Partial'){ ?>
      <span class="badge badge-warning">Partial</span>
    <?php } else { ?>
      <span class="badge badge-danger">Unpaid</span>
    <?php } ?>
  </td>
  <td><?= $row['bill_date'] ?></td>
  <td>
    <a href="bill_view.php?id=<?= $row['bill_id'] ?>"
       class="btn btn-sm btn-primary">View</a>
  </td>
</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>
</section>
</div>

<?php include('includes/footer.php'); ?>
</div>
</body>
</html>

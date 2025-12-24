<?php
include_once('db_config.php');
session_start();
if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

$customers = mysqli_query($conn, "SELECT * FROM customers ORDER BY customer_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Customers</title>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Customers</h3>

<a href="customer_add.php" class="btn btn-primary mb-2">Add Customer</a>


<table class="table table-bordered">
<thead class="bg-dark">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php if(mysqli_num_rows($customers)>0): $i=1; ?>
<?php while($row=mysqli_fetch_assoc($customers)): ?>
<tr>
<td><?= $i++ ?></td>
<td><?= htmlspecialchars($row['name']) ?></td>
<td><?= htmlspecialchars($row['email']) ?></td>
<td><?= htmlspecialchars($row['phone']) ?></td>
<td><?= htmlspecialchars($row['address']) ?></td>
<td>
<a href="customer_edit.php?id=<?= $row['customer_id'] ?>" class="btn btn-sm btn-info">Edit</a>
<a href="customer_delete.php?id=<?= $row['customer_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
<?php else: ?>
<tr><td colspan="6" class="text-center">No customers found</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>
</div>
</body>
</html>

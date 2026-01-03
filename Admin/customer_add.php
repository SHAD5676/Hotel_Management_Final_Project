<?php
include_once('db_config.php');
session_start();
if(!isset($_SESSION['full_name'])){
    header('location:index.php');
    exit;
}

$message = '';
if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if($name && $email && $phone && $address){
        $sql = "INSERT INTO customers (name,email,phone,address) VALUES ('$name','$email','$phone','$address')";
        if($conn->query($sql)){
            $_SESSION['success']="Customer added successfully!";
            header("Location: customer.php");
            exit;
        } else {
            $message="<div class='alert alert-danger'>Error: {$conn->error}</div>";
        }
    } else {
        $message="<div class='alert alert-warning'>All fields are required.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Customer</title>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Add Customer</h3>

<?= $message ?>

<form method="post">
<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" class="form-control" required>
</div>

<div class="form-group">
<label>Address</label>
<input type="text" name="address" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-primary">Add Customer</button>
<a href="customer.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
</body>
</html>

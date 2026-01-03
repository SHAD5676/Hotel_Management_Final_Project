<?php
include_once('db_config.php');
session_start();
if(!isset($_SESSION['full_name'])){
    header('location:index.php');
    exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('location:customer.php');
    exit;
}

$id = (int)$_GET['id'];
$res = $conn->query("SELECT * FROM customers WHERE customer_id=$id");
if($res->num_rows==0){
    header('location:customer.php');
    exit;
}
$customer = $res->fetch_assoc();

$message='';
if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if($name && $email && $phone && $address){
        $sql = "UPDATE customers SET name='$name', email='$email', phone='$phone', address='$address' WHERE customer_id='$id'";
        if($conn->query($sql)){
            $_SESSION['success']="Customer updated successfully!";
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
<title>Edit Customer</title>
<link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Edit Customer</h3>

<?= $message ?>

<form method="post">
<div class="form-group">
<label>Name</label>
<input type="text" name="name" value="<?= htmlspecialchars($customer['name']) ?>" class="form-control" required>
</div>

<div class="form-group">
<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($customer['email']) ?>" class="form-control" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" value="<?= htmlspecialchars($customer['phone']) ?>" class="form-control" required>
</div>

<div class="form-group">
<label>Address</label>
<input type="text" name="address" value="<?= htmlspecialchars($customer['address']) ?>" class="form-control" required>
</div>

<button type="submit" name="submit" class="btn btn-primary">Update Customer</button>
<a href="customer.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
</body>
</html>

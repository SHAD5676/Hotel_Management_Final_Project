<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['full_name'])){
    header('location:index.php');
    exit;
}

$message = '';

if(isset($_POST['submit'])){
    $username = trim($_POST['full_name']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if($username && $password){
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES ('$username','$hashed','$role')";
        if($conn->query($sql)){
            $_SESSION['success'] = "User added successfully!";
            header("Location: users.php");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Error: {$conn->error}</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>All fields are required</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add User</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Add User</h3>
<?= $message ?>

<form method="post">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="Admin">Admin</option>
            <option value="Staff">Staff</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Save</button>
    <a href="users.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
</body>
</html>

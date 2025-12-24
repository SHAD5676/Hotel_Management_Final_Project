<?php
include_once('db_config.php');
session_start();

if(!isset($_SESSION['username'])){
    header('location:index.php');
    exit;
}

if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    header('location:users.php');
    exit;
}

$id = (int)$_GET['id'];
$message = '';

$res = $conn->query("SELECT * FROM users WHERE user_id=$id");
if($res->num_rows==0){
    header('location:users.php');
    exit;
}
$user = $res->fetch_assoc();

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    if($username){
        $sql = "UPDATE users SET username='$username', role='$role'";
        if($password){
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql .= ", password='$hashed'";
        }
        $sql .= " WHERE user_id=$id";

        if($conn->query($sql)){
            $_SESSION['success'] = "User updated!";
            header("Location: users.php");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Error: {$conn->error}</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>Username is required</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">
<h3>Edit User</h3>
<?= $message ?>

<form method="post">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Password <small>(leave blank to keep unchanged)</small></label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="Admin" <?= $user['role']=='Admin'?'selected':'' ?>>Admin</option>
            <option value="Staff" <?= $user['role']=='Staff'?'selected':'' ?>>Staff</option>
        </select>
    </div>
    <button type="submit" name="submit" class="btn btn-primary">Update</button>
    <a href="users.php" class="btn btn-secondary">Cancel</a>
</form>
</div>
</div>
</body>
</html>

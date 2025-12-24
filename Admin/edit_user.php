<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

$id = $_GET['id'];

$user = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$id'");
$data = mysqli_fetch_assoc($user);

if (isset($_POST['update'])) {

  $username = $_POST['username'];
  $role = $_POST['role'];

  if (!empty($_POST['password'])) {
    $password = md5($_POST['password']);
    $sql = "UPDATE users SET username='$username', role='$role', password='$password' WHERE user_id='$id'";
  } else {
    $sql = "UPDATE users SET username='$username', role='$role' WHERE user_id='$id'";
  }

  mysqli_query($conn, $sql);
  header("location:user.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit User</title>

  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper">

<section class="content-header">
  <div class="container-fluid">
    <h1>Edit User</h1>
  </div>
</section>

<section class="content">
<div class="container-fluid">
<div class="card">
<div class="card-body">

<form method="post">
  <div class="form-group">
    <label>Username (Email)</label>
    <input type="email" name="username" value="<?= htmlspecialchars($data['username']) ?>" class="form-control" required>
  </div>

  <div class="form-group">
    <label>Role</label>
    <select name="role" class="form-control">
      <option value="">User</option>
      <option value="Admin" <?= ($data['role']=='Admin')?'selected':'' ?>>Admin</option>
      <option value="Manager" <?= ($data['role']=='Manager')?'selected':'' ?>>Manager</option>
      <option value="Staff" <?= ($data['role']=='Staff')?'selected':'' ?>>Staff</option>
    </select>
  </div>

  <div class="form-group">
    <label>New Password (optional)</label>
    <input type="password" name="password" class="form-control">
  </div>

  <button name="update" class="btn btn-success">
    <i class="fas fa-save"></i> Update
  </button>
  <a href="user.php" class="btn btn-secondary">Back</a>
</form>

</div>
</div>
</div>
</section>

</div>

<?php include("includes/footer.php"); ?>
</div>

<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.js"></script>
</body>
</html>

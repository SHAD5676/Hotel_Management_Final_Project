<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['full_name'])) {
  header('location:index.php');
  exit;
}

// Fetch users
$users = mysqli_query($conn, "SELECT `id`, `full_name`, `email`, `phone`, `role`, `created_at`, `updated_at` FROM `users` ORDER BY `id` DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- AdminLTE style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include("includes/navbar.php"); ?>
    <?php include("includes/leftbar.php"); ?>

    <div class="content-wrapper">

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Users</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="user_add.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add User
              </a>
            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">

              <table class="table table-bordered table-hover">
                <thead class="bg-dark text-white">
                  <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (mysqli_num_rows($users) > 0): $i = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($users)): ?>
                      <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['full_name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['role'] ?? 'user') ?></td>
                        <td>
                          <a href="user_edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="user_delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                            onclick="return confirm('Are you sure you want to delete this user?')">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="6" class="text-center">No users found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </section>

    </div>

    <?php include("includes/footer.php"); ?>
  </div>


  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
</body>

</html>
<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin | Rooms</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <?php include("includes/navbar.php"); ?>
    <?php include("includes/leftbar.php"); ?>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Rooms</h1>
            </div>
            <div class="col-sm-6 text-right">
              <a href="add_room.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Room
              </a>
            </div>
          </div>

          <!-- Success message -->
          <?php
          if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
          }
          if (isset($_SESSION['error'])) {
            echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
            unset($_SESSION['error']);
          }
          ?>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Room List</h3>
            </div>

            <div class="card-body table-responsive p-0">
              <table class="table table-bordered table-hover">
                <thead class="thead-light">
                  <tr>
                    <th>ID</th>
                    <th>Room Number</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Image</th>
                    <th width="140">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT r.room_id, r.room_number, r.status,
                                       c.category_name, c.price,
                                       ri.image_url
                                FROM rooms r
                                JOIN room_categories c ON r.category_id = c.category_id
                                LEFT JOIN room_images ri ON r.room_id = ri.room_id
                                ORDER BY r.room_id DESC";

                  $result = $conn->query($sql);
                  $i = 1;

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()):
                  ?>
                      <tr>
                        <td><?= $i++ ?></td>
                        <td><?= htmlspecialchars($row['room_number']) ?></td>
                        <td><?= htmlspecialchars($row['category_name']) ?></td>
                        <td><?= number_format($row['price'], 2) ?></td>
                        <td>
                          <span class="badge <?= $row['status'] == 'Available' ? 'badge-success' : ($row['status'] == 'Occupied' ? 'badge-danger' : 'badge-warning') ?>">
                            <?= $row['status'] ?>
                          </span>
                        </td>
                        <td>
                          <?php if (!empty($row['image_url']) && file_exists($row['image_url'])): ?>
                            <img src="<?= $row['image_url'] ?>" alt="Room Image" style="max-width:60px; border-radius:4px;">
                          <?php else: ?>
                            <span class="text-muted">No Image</span>
                          <?php endif; ?>
                        </td>
                        <td>
                          <a href="edit_room.php?room_id=<?= $row['room_id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="delete_room.php?room_id=<?= $row['room_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                  <?php
                    endwhile;
                  } else {
                    echo "<tr><td colspan='7' class='text-center'>No rooms found</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </section>

    </div>

    <?php include("includes/footer.php"); ?>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
</body>

</html>
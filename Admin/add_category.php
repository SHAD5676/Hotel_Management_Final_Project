<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
  header('location:index.php');
  exit;
}

$message = '';

if (isset($_POST['submit'])) {
  // Get form values
  $category_name = $conn->real_escape_string($_POST['category_name']);
  $price = $conn->real_escape_string($_POST['price']);
  $details = $conn->real_escape_string($_POST['details']);

  // Basic validation
  if (!empty($category_name) && !empty($price)) {
    $sql = "INSERT INTO room_categories (category_name, price, details) VALUES ('$category_name', '$price', '$details')";
    if ($conn->query($sql)) {
      // Success: redirect to categories.php with session message
      $_SESSION['success'] = "Category added successfully!";
      header("Location: room_categories.php");
      exit;
    } else {
      // Database error: show on the same page
      $message = "<div class='alert alert-danger'>Database Error: " . $conn->error . "</div>";
    }
  } else {
    // Validation error: show on the same page
    $message = "<div class='alert alert-warning'>Please fill in all required fields.</div>";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Add Category</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">
    <?php include("includes/navbar.php"); ?>
    <?php include("includes/leftbar.php"); ?>

    <div class="content-wrapper">
      <!-- Content Header -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Add New Room Category</h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <?php echo $message; ?>
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Category Details</h3>
            </div>

            <?php
            if (!empty($message)) {
              echo $message;
            }
            ?>


            <!-- Form start -->
            <form method="post">
              <div class="card-body">
                <div class="form-group">
                  <label for="category_name">Category Name</label>
                  <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
                </div>

                <div class="form-group">
                  <label for="price">Price</label>
                  <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Enter price" required>
                </div>

                <div class="form-group">
                  <label for="details">Details</label>
                  <textarea class="form-control" id="details" name="details" rows="3" placeholder="Enter details"></textarea>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">Add Category</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>

    <?php include("includes/footer.php"); ?>
    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <script src="dist/js/adminlte.js"></script>
</body>

</html>
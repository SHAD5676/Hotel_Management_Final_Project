<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['full_name'])) {
  header('location:index.php');
  exit;
}

$message = '';

// Handle form submission
if (isset($_POST['submit'])) {
  $customer_id = (int) $_POST['customer_id'];
  $booking_id  = (int) $_POST['booking_id'];
  $rating      = (int) $_POST['rating'];
  $comments    = trim($_POST['comments']);
  $date        = date('Y-m-d H:i:s');

  if ($customer_id && $booking_id && $rating >= 1 && $rating <= 5 && $comments) {
    $comments = $conn->real_escape_string($comments);

    $sql = "INSERT INTO feedback (customer_id, booking_id, rating, comments, feedback_date)
                VALUES ($customer_id, $booking_id, $rating, '$comments', '$date')";

    if ($conn->query($sql)) {
      $_SESSION['success'] = "Feedback submitted successfully!";
      header("Location: feedback.php");
      exit;
    } else {
      $message = "<div class='alert alert-danger'>Database Error: {$conn->error}</div>";
    }
  } else {
    $message = "<div class='alert alert-warning'>Please fill all fields correctly.</div>";
  }
}
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
      <div class="content-header">
        <div class="container-fluid">
          <h1>Feedback / Reports</h1>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <!-- Success message -->
          <?php
          if (isset($_SESSION['success'])) {
            echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
            unset($_SESSION['success']);
          }
          echo $message;
          ?>

          <!-- Feedback Form -->
          <div class="card">
            <div class="card-header bg-info">
              <h3 class="card-title">Submit Feedback</h3>
            </div>

            <div class="card-body">
              <form method="post">
                <div class="form-group">
                  <label>Customer ID</label>
                  <input type="number" name="customer_id" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Booking ID</label>
                  <select name="booking_id" class="form-control" required>
                    <option value="">Select Booking</option>
                    <?php
                    $res = $conn->query("SELECT booking_id FROM bookings ORDER BY booking_id DESC");
                    while ($b = $res->fetch_assoc()) {
                      echo "<option value='{$b['booking_id']}'>{$b['booking_id']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Rating</label>
                  <select name="rating" class="form-control" required>
                    <?php for ($i = 1; $i <= 5; $i++) echo "<option value='$i'>$i</option>"; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Comments</label>
                  <textarea name="comments" class="form-control" rows="3" required></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-success">
                  Submit Feedback
                </button>
              </form>
            </div>
          </div>

          <!-- Feedback Table -->
          <div class="card mt-4">
            <div class="card-header bg-primary">
              <h3 class="card-title">All Feedback</h3>
            </div>

            <div class="card-body table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Booking</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $conn->query("SELECT * FROM feedback ORDER BY feedback_id DESC");

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      $rating = (int) $row['rating'];
                      $stars  = str_repeat('★', $rating) . str_repeat('☆', 5 - $rating);

                      echo "<tr>
                                        <td>{$row['feedback_id']}</td>
                                        <td>{$row['customer_id']}</td>
                                        <td>{$row['booking_id']}</td>
                                        <td style='color:gold;font-size:1.2em;'>{$stars}</td>
                                        <td>" . htmlspecialchars($row['comments']) . "</td>
                                        <td>{$row['feedback_date']}</td>
                                      </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='6' class='text-center'>No feedback found</td></tr>";
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
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
  $room_number = trim($_POST['room_number']);
  $category_id = (int) $_POST['category_id'];
  $status = trim($_POST['status']);

  // Validate required fields
  if ($room_number && $category_id && $status) {
    $room_number = $conn->real_escape_string($room_number);
    $status = $conn->real_escape_string($status);

    // Insert room
    $sql = "INSERT INTO rooms (room_number, category_id, status) VALUES ('$room_number', '$category_id', '$status')";
    if ($conn->query($sql)) {
      $room_id = $conn->insert_id; // Newly inserted room ID

      // Handle image upload
      if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/rooms/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

        $fileName = basename($_FILES['image']['name']);
        $targetFile = $targetDir . time() . "_" . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
          // Insert image record
          $sql_img = "INSERT INTO room_images (room_id, image_url) VALUES ('$room_id', '$targetFile')";
          $conn->query($sql_img);
        } else {
          $message = "<div class='alert alert-warning'>Room added, but image upload failed.</div>";
        }
      }

      $_SESSION['success'] = "Room added successfully!";
      header("Location: room.php");
      exit;
    } else {
      $message = "<div class='alert alert-danger'>Database Error: {$conn->error}</div>";
    }
  } else {
    $message = "<div class='alert alert-warning'>All fields are required.</div>";
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Admin | Add New Room</title>
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
          <h1>Add New Room</h1>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">

          <?= $message ?>

          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Room Details</h3>
            </div>

            <form method="post" enctype="multipart/form-data">

              <div class="card-body">

                <div class="form-group">
                  <label>Room Number</label>
                  <input type="text" name="room_number" class="form-control" required>
                </div>

                <div class="form-group">
                  <label>Category</label>
                  <select name="category_id" class="form-control" required>
                    <option value="" disabled selected>Select Category</option>
                    <?php
                    $cats = $conn->query("SELECT category_id, category_name FROM room_categories ORDER BY category_name");
                    while ($cat = $cats->fetch_assoc()) {
                      echo "<option value='{$cat['category_id']}'>{$cat['category_name']}</option>";
                    }
                    ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control" required>
                    <option value="" disabled selected>Select Status</option>
                    <option value="Available">Available</option>
                    <option value="Occupied">Occupied</option>
                    <option value="Maintenance">Maintenance</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>Room Image</label>
                  <input type="file" name="image" class="form-control" accept="image/*" id="roomImageInput">
                  <div class="mt-2">
                    <img id="roomImagePreview" src="#" alt="Image Preview" style="max-width: 200px; display: none; border: 1px solid #ccc; padding: 5px;">
                  </div>
                </div>


              </div>

              <div class="card-footer">
                <button type="submit" name="submit" class="btn btn-primary">
                  Add Room
                </button>
              </div>
            </form>
          </div>

        </div>
      </section>
    </div>

    <?php include("includes/footer.php"); ?>
  </div>

  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.js"></script>

  <script>
    document.getElementById('roomImageInput').addEventListener('change', function(event) {
      const file = event.target.files[0];
      const preview = document.getElementById('roomImagePreview');

      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
      } else {
        preview.src = '#';
        preview.style.display = 'none';
      }
    });
  </script>

</body>

</html>
<?php
include_once('db_config.php');

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

/* ---------- AUTH CHECK (ADMIN OR USER) ---------- */
if (!isset($_SESSION['user_id']) && !isset($_SESSION['full_name'])) {
  header('Location: login.php?error=Please login to access room details');
  exit;
}

/* ---------- VALIDATE ROOM ID ---------- */
if (!isset($_GET['room_id']) || !is_numeric($_GET['room_id'])) {
  header('Location: room.php');
  exit;
}

$room_id = (int) $_GET['room_id'];

/* ---------- HANDLE BOOKING ---------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nights'])) {

  $guest_name    = trim($_POST['guest_name']);
  $guest_contact = trim($_POST['guest_contact']);
  $check_in      = $_POST['check_in'];
  $nights        = (int) $_POST['nights'];

  if ($guest_name === '' || $guest_contact === '' || $check_in === '' || $nights <= 0) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: room_details.php?room_id=$room_id");
    exit;
  }

  /* ---------- FETCH ROOM & PRICE AGAIN (SECURE) ---------- */
  $roomCheck = $conn->prepare("
        SELECT r.status, c.price
        FROM rooms r
        JOIN room_categories c ON r.category_id = c.category_id
        WHERE r.room_id = ?
    ");
  $roomCheck->bind_param("i", $room_id);
  $roomCheck->execute();
  $roomData = $roomCheck->get_result()->fetch_assoc();

  if (!$roomData || $roomData['status'] !== 'Available') {
    $_SESSION['error'] = "Room is no longer available.";
    header("Location: room_details.php?room_id=$room_id");
    exit;
  }

  $price        = (float) $roomData['price'];
  $check_out    = date('Y-m-d', strtotime($check_in . " +$nights days"));
  $total_price  = $price * $nights;

  /* ---------- CUSTOMER ID ---------- */
  $customer_id = $_SESSION['user_id'] ?? ('GUEST-' . rand(100000, 999999));

  /* ---------- INSERT BOOKING ---------- */
  $insertBooking = $conn->prepare("
        INSERT INTO bookings 
        (room_id, customer_id, check_in, check_out, total_price, booking_status)
        VALUES (?, ?, ?, ?, ?, 'Booked')
    ");
  $insertBooking->bind_param(
    "isssd",
    $room_id,
    $customer_id,
    $check_in,
    $check_out,
    $total_price
  );
  $insertBooking->execute();

  /* ---------- UPDATE ROOM STATUS ---------- */
  $updateRoom = $conn->prepare("UPDATE rooms SET status = 'Booked' WHERE room_id = ?");
  $updateRoom->bind_param("i", $room_id);
  $updateRoom->execute();

  $_SESSION['success'] = "Room booked successfully!";
  header("Location: room.php");
  exit;
}

/* ---------- FETCH ROOM INFO ---------- */
$stmt = $conn->prepare("
    SELECT r.room_id, r.room_number, r.status,
           c.category_name, c.price,
           ri.image_url
    FROM rooms r
    JOIN room_categories c ON r.category_id = c.category_id
    LEFT JOIN room_images ri ON r.room_id = ri.room_id
    WHERE r.room_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  header('Location: room.php');
  exit;
}

$room = $result->fetch_assoc();
$image = $room['image_url'] ?: 'default.jpg';
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Room Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <?php include_once 'Inc/top_nav.php'; ?>

  <main>
    <div class="container py-5">

      <a href="room.php" class="btn btn-secondary mb-4">&larr; Back to Rooms</a>

      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
      <?php endif; ?>

      <div class="row">
        <div class="col-md-6 mb-3">
          <img src="admin/<?= htmlspecialchars($image) ?>"
            class="img-fluid rounded"
            style="height:250px; object-fit:cover;">
        </div>

        <div class="col-md-6">
          <h2>Room <?= htmlspecialchars($room['room_number']) ?></h2>
          <p><strong>Category:</strong> <?= htmlspecialchars($room['category_name']) ?></p>
          <p><strong>Price per night:</strong> $<?= number_format($room['price'], 2) ?></p>

          <p>
            <strong>Status:</strong>
            <span class="badge <?= $room['status'] === 'Available' ? 'bg-success' : 'bg-warning'; ?>">
              <?= htmlspecialchars($room['status']) ?>
            </span>
          </p>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="guest_name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Contact Number</label>
              <input type="text" name="guest_contact" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Check-in Date</label>
              <input type="date" name="check_in" class="form-control" min="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Number of nights</label>
              <select name="nights" class="form-select" required>
                <?php for ($i = 1; $i <= 30; $i++): ?>
                  <option value="<?= $i ?>"><?= $i ?> night<?= $i > 1 ? 's' : '' ?></option>
                <?php endfor; ?>
              </select>
            </div>

            <button type="submit" class="btn btn-primary" <?= $room['status'] !== 'Available' ? 'disabled' : '' ?>>
              Book Now
            </button>
          </form>
        </div>
      </div>

    </div>
  </main>

  <?php include_once 'Inc/footer.php'; ?>

  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}

/* PROCESS CHECKOUT */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {

    $booking_id = $_POST['booking_id'];

    // Get room_id from booking
    $stmt = $conn->prepare("SELECT room_id FROM bookings WHERE booking_id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking) {
        $room_id = $booking['room_id'];

        // Update booking status
        $updateBooking = $conn->prepare(
            "UPDATE bookings SET booking_status = 'Checked Out' WHERE booking_id = ?"
        );
        $updateBooking->bind_param("i", $booking_id);
        $updateBooking->execute();


        // -------- CREATE BILL --------

// total_price already bookings table 
$stmtBill = $conn->prepare(
    "INSERT INTO bills (booking_id, total_amount, bill_status, bill_date)
     VALUES (?, ?, 'Unpaid', CURDATE())"
);

$stmtBill->bind_param("id", $booking_id, $rowTotal);

// total_price
$priceStmt = $conn->prepare(
    "SELECT total_price FROM bookings WHERE booking_id = ?"
);
$priceStmt->bind_param("i", $booking_id);
$priceStmt->execute();
$priceResult = $priceStmt->get_result();
$priceRow = $priceResult->fetch_assoc();

$rowTotal = $priceRow['total_price'];

$stmtBill->execute();


        // Update room status
        $updateRoom = $conn->prepare(
            "UPDATE rooms SET status = 'Available' WHERE room_id = ?"
        );
        $updateRoom->bind_param("i", $room_id);
        $updateRoom->execute();

        $_SESSION['success'] = "Guest checked out successfully!";
    }

    header("Location: check_out.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Check Out</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include("includes/navbar.php"); ?>
        <?php include("includes/leftbar.php"); ?>

        <div class="content-wrapper p-4">
            <h3>Check Out</h3>

            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
                unset($_SESSION['success']);
            }
            ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room</th>
                        <th>Customer ID</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $sql = "SELECT 
                    b.booking_id,
                    b.customer_id,
                    b.check_in,
                    b.check_out,
                    b.total_price,
                    b.booking_status,
                    r.room_number
                FROM bookings b
                JOIN rooms r ON b.room_id = r.room_id
                WHERE b.booking_status = 'Accepted'
                ORDER BY b.booking_id DESC";

                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?= $row['booking_id']; ?></td>
                                <td><?= $row['room_number']; ?></td>
                                <td><?= $row['customer_id']; ?></td>
                                <td><?= $row['check_in']; ?></td>
                                <td><?= $row['check_out']; ?></td>
                                <td><?= $row['total_price']; ?></td>
                                <td>
                                    <span class="badge bg-success">Accepted</span>
                                </td>
                                <td>
                                    <form method="POST"
                                        onsubmit="return confirm('Confirm check out?');">
                                        <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                                        <button type="submit" name="checkout"
                                            class="btn btn-sm btn-primary">
                                            Check Out
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr>
                    <td colspan='8' class='text-center'>
                        No guests to check out
                    </td>
                  </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>

    </div>
</body>

</html>
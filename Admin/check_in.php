<?php
include_once('db_config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'], $_POST['status'])) {

    $booking_id = (int) $_POST['booking_id'];
    $status     = $_POST['status'];

    // Update booking status
    $stmt = $conn->prepare(
        "UPDATE bookings SET booking_status = ? WHERE booking_id = ?"
    );
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();

    // If Accepted → mark room as Occupied
    if ($status === 'Accepted') {

        $roomQuery = $conn->prepare(
            "SELECT room_id FROM bookings WHERE booking_id = ?"
        );
        $roomQuery->bind_param("i", $booking_id);
        $roomQuery->execute();
        $room = $roomQuery->get_result()->fetch_assoc();

        if ($room) {
            $updateRoom = $conn->prepare(
                "UPDATE rooms SET status = 'Occupied' WHERE room_id = ?"
            );
            $updateRoom->bind_param("i", $room['room_id']);
            $updateRoom->execute();
        }
    }

    $_SESSION['success'] = "Booking status updated successfully!";

    // 🔁 Refresh same page (NOT another page)
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Check In</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include("includes/navbar.php"); ?>
        <?php include("includes/leftbar.php"); ?>

        <div class="content-wrapper p-4">
            <h3>Check In</h3>

            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
                unset($_SESSION['success']);
            }
            ?>

            <a href="check_in.php" class="btn btn-primary mb-2">Add checkings</a>

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
                                <td><?= $row['booking_status']; ?></td>

                                <td>
                                    <?php if ($row['booking_status'] === 'Booked') { ?>

                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                                            <input type="hidden" name="status" value="Accepted">
                                            <button type="submit" class="btn btn-sm btn-success">Accept</button>
                                        </form>

                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                                            <input type="hidden" name="status" value="Rejected">
                                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                        </form>

                                    <?php } else { ?>

                                        <span class="badge 
                        <?= $row['booking_status'] === 'Accepted' ? 'bg-success' : 'bg-danger'; ?>">
                                            <?= $row['booking_status']; ?>
                                        </span>

                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>

            </table>

        </div>
    </div>
</body>

</html>
<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['full_name'])) {
    header('location:index.php');
}
?>

<!DOCTYPE html>
<html>

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

        <!-- Navbar -->
        <?php include("includes/navbar.php"); ?>

        <!-- Main Sidebar Container -->
        <?php include("includes/leftbar.php"); ?>


        <div class="content-wrapper p-4">
            <h3>Bookings</h3>

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
                        <th>Customer</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "
SELECT b.booking_id, b.customer_id, b.room_id, b.check_in, b.check_out,
       b.total_price, b.booking_status,
       r.room_number, c.name AS customer_name
FROM bookings b
LEFT JOIN rooms r ON b.room_id = r.room_id
LEFT JOIN customers c ON b.customer_id = c.customer_id
ORDER BY b.booking_id DESC
";

                    $result = $conn->query($sql);
                    $i = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                <td>{$i}</td>
                <td>{$row['room_number']}</td>
                <td>{$row['customer_name']}</td>
                <td>{$row['check_in']}</td>
                <td>{$row['check_out']}</td>
                <td>{$row['total_price']}</td>
                <td>{$row['booking_status']}</td>
                <td>
                    <a href='edit_booking.php?id={$row['booking_id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='delete_booking.php?id={$row['booking_id']}' onclick='return confirm(\"Are you sure?\")' class='btn btn-sm btn-danger'>Delete</a>";

                            // Generate Invoice button only for Checked Out bookings
                            if ($row['booking_status'] == 'Checked Out') {
                                echo " <a href='invoice.php?booking_id={$row['booking_id']}' class='btn btn-sm btn-success ml-2'>Generate Invoice</a>";
                            }

                            echo "</td>
              </tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center'>No bookings found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
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
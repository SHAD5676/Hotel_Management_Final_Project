<?php
include_once('db_config.php');
session_start();

if (!isset($_SESSION['username'])) {
    header('location:index.php');
    exit;
}

// Fetch customers
$result = $conn->query("SELECT * FROM customers ORDER BY customer_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customers</title>
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

<?php include("includes/navbar.php"); ?>
<?php include("includes/leftbar.php"); ?>

<div class="content-wrapper p-4">

    <div class="d-flex justify-content-between mb-3">
        <h3>Customer List</h3>
        <a href="customer_add.php" class="btn btn-primary">Add Customer</a>
    </div>

    <!-- Session Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="20%">Name</th>
                <th width="20%">Email</th>
                <th width="15%">Phone</th>
                <th width="25%">Address</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['customer_id']; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['address']); ?></td>
                    <td>
                        <a href="customer_edit.php?id=<?= $row['customer_id']; ?>"
                           class="btn btn-warning btn-sm">
                           Edit
                        </a>

                        <a href="customer_delete.php?id=<?= $row['customer_id']; ?>"
                           onclick="return confirm('Are you sure you want to delete this customer?')"
                           class="btn btn-danger btn-sm">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No customers found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</div>
</div>
</body>
</html>

<?php
include_once('../db_config.php');
session_start();

// Protect page
if (!isset($_SESSION['full_name'])) {
  header('location:index.php');
  exit;
}

/*
|-------------------------------------------------------------------------- 
| Determine bill/booking ID
|-------------------------------------------------------------------------- 
*/
$booking_id = null;

if (isset($_GET['booking_id'])) {
  $booking_id = intval($_GET['booking_id']);
} elseif (isset($_GET['bill_id'])) {
  $bill_id = intval($_GET['bill_id']);
  // Fetch booking_id using bill_id
  $stmt = $conn->prepare("SELECT booking_id FROM bills WHERE bill_id = ?");
  $stmt->bind_param("i", $bill_id);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $stmt->close();

  if (!$row) {
    die("Bill not found for this Bill ID");
  }

  $booking_id = $row['booking_id'];
} else {
  die("Invalid access");
}

/*
|-------------------------------------------------------------------------- 
| Fetch bill details
|-------------------------------------------------------------------------- 
*/
$stmt = $conn->prepare("SELECT bill_id, total_amount FROM bills WHERE booking_id = ?");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$result = $stmt->get_result();
$bill = $result->fetch_assoc();
$stmt->close();

if (!$bill) {
  die("Bill not found for this booking");
}

/*
|-------------------------------------------------------------------------- 
| Insert payment record into payments table
|-------------------------------------------------------------------------- 
*/
$stmt = $conn->prepare("
    INSERT INTO payments (booking_id, amount, payment_date, method)
    VALUES (?, ?, NOW(), 'Stripe')
");
$stmt->bind_param("id", $booking_id, $bill['total_amount']);
$stmt->execute();
$stmt->close();

/*
|-------------------------------------------------------------------------- 
| Update bill payment method
|-------------------------------------------------------------------------- 
*/
$stmt = $conn->prepare("
    UPDATE bills
    SET payment_method = 'Stripe'
    WHERE booking_id = ?
");
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Payment Successful</title>
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">

  <!-- JS Libraries for PDF -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <style>
    /* Print styles */
    @media print {
      body * {
        visibility: hidden;
      }

      #invoice,
      #invoice * {
        visibility: visible;
      }

      #invoice {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
      }

      #print-button,
      #pdf-button {
        display: none;
      }
    }

    /* Invoice card */
    .invoice-card {
      border: 1px solid #ccc;
      padding: 20px;
      border-radius: 8px;
      background-color: #fff;
    }

    .invoice-card h4 {
      margin-bottom: 20px;
    }

    .invoice-card table {
      width: 100%;
    }

    .invoice-card table th {
      text-align: left;
    }

    .invoice-card table td {
      text-align: right;
    }

    .invoice-card table td.label {
      text-align: left;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <?php include("includes/navbar.php"); ?>
    <?php include("includes/leftbar.php"); ?>

    <div class="content-wrapper p-4">

      <section class="content">
        <div class="container-fluid">

          <div class="row justify-content-center">
            <div class="col-md-8">

              <div class="card card-outline card-success shadow-lg" id="invoice">
                <div class="card-header text-center">
                  <h4>
                    <i class="fas fa-check-circle mr-2"></i>
                    Payment Successful
                  </h4>
                  <p class="text-success mb-0">Your payment has been recorded successfully</p>
                </div>

                <div class="card-body invoice-card">

                  <div class="text-center mb-3">
                    <i class="fas fa-credit-card fa-3x text-success"></i>
                  </div>

                  <table class="table table-borderless">
                    <tr>
                      <th class="label">Booking ID</th>
                      <td>#<?= htmlspecialchars($booking_id) ?></td>
                    </tr>
                    <tr>
                      <th class="label">Bill ID</th>
                      <td>#<?= htmlspecialchars($bill['bill_id']) ?></td>
                    </tr>
                    <tr>
                      <th class="label">Amount Paid</th>
                      <td class="text-success font-weight-bold"><?= number_format($bill['total_amount'], 2) ?> ৳</td>
                    </tr>
                    <tr>
                      <th class="label">Payment Method</th>
                      <td>Stripe</td>
                    </tr>
                    <tr>
                      <th class="label">Payment Date</th>
                      <td><?= date("Y-m-d H:i:s") ?></td>
                    </tr>
                  </table>

                  <div class="mt-4 text-center">
                    <button id="print-button" class="btn btn-primary mr-2">
                      <i class="fas fa-print"></i> Print Invoice
                    </button>

                    <button id="pdf-button" class="btn btn-success mr-2">
                      <i class="fas fa-file-pdf"></i> Download PDF
                    </button>

                    <a href="bills.php" class="btn btn-secondary">
                      <i class="fas fa-arrow-left"></i> Back to Bills
                    </a>
                  </div>

                  <p class="text-muted mt-3" style="font-size:13px;">
                    <i class="fas fa-lock mr-1"></i>
                    Payment securely processed
                  </p>

                </div>
              </div>

            </div>
          </div>

        </div>
      </section>

    </div>

    <?php include("includes/footer.php"); ?>

  </div>

  <!-- jQuery and Bootstrap -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="dist/js/adminlte.min.js"></script>

  <script>
    $(document).ready(function() {
      // Print invoice
      $('#print-button').click(function() {
        window.print();
      });

      // Download PDF on the same page
      $('#pdf-button').click(async function() {
        const {
          jsPDF
        } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4');

        const invoice = document.getElementById('invoice');

        const canvas = await html2canvas(invoice, {
          scale: 2
        });
        const imgData = canvas.toDataURL('image/png');

        const pageWidth = doc.internal.pageSize.getWidth();
        const imgWidth = pageWidth - 40; // 20pt margin
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        doc.addImage(imgData, 'PNG', 20, 20, imgWidth, imgHeight);
        doc.save('Invoice_<?= $booking_id ?>.pdf');
      });
    });
  </script>

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
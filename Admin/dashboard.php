<?php
include_once('db_config.php');
session_start();
if (!isset($_SESSION['full_name'])) {
  header('location:index.php');
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

  <style>
    .custom-menu {
      z-index: 1000;
      position: absolute;
      background-color: #ffffff;
      border: 1px solid #0000001c;
      border-radius: 5px;
      padding: 8px;
      min-width: 13vw;
    }

    a.custom-menu-list {
      width: 100%;
      display: flex;
      color: #4c4b4b;
      font-weight: 600;
      font-size: 1em;
      padding: 1px 11px;
    }

    span.card-icon {
      position: absolute;
      font-size: 3em;
      bottom: .2em;
      color: #ffffff80;
    }

    .file-item {
      cursor: pointer;
    }

    a.custom-menu-list:hover,
    .file-item:hover,
    .file-item.active {
      background: #80808024;
    }

    a.custom-menu-list span.icon {
      width: 1em;
      margin-right: 5px
    }

    .candidate {
      margin: auto;
      width: 23vw;
      padding: 0 10px;
      border-radius: 20px;
      margin-bottom: 1em;
      display: flex;
      border: 3px solid #00000008;
      background: #8080801a;

    }

    .candidate_name {
      margin: 8px;
      margin-left: 3.4em;
      margin-right: 3em;
      width: 100%;
    }

    .img-field {
      display: flex;
      height: 8vh;
      width: 4.3vw;
      padding: .3em;
      background: #80808047;
      border-radius: 50%;
      position: absolute;
      left: -.7em;
      top: -.7em;
    }

    .candidate img {
      height: 100%;
      width: 100%;
      margin: auto;
      border-radius: 50%;
    }

    .vote-field {
      position: absolute;
      right: 0;
      bottom: -.4em;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- Navbar -->
    <?php include("includes/navbar.php"); ?>

    <!-- Main Sidebar Container -->
    <?php include("includes/leftbar.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div>
          </div>
        </div>
      </div>

      <!-- Main content -->
      <section class="content">


        <div class="container-fluid">

          <div class="row">
            <div class="col-lg-12">
              <div class="card col-md-4 offset-2 bg-info float-left">
                <div class="card-body text-white">
                  <h4><b>More info</b></h4>
                  <hr>
                  <span class="card-icon"><i class="fa fa-users"></i></span>
                  <h3 class="text-right"><b></b></h3>
                </div>
              </div>
              <div class="card col-md-4 offset-2 bg-primary ml-4 float-left">
                <div class="card-body text-white">
                  <h4><b>More info</b></h4>
                  <hr>
                  <span class="card-icon"><i class="fa fa-user-tie"></i></span>
                  <h3 class="text-right"><b></b></h3>
                </div>
              </div>
            </div>
          </div>

        </div>

    </div>

  </div>
  <!-- /.content-wrapper -->



  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content -->
  </aside>

  </div>
  <!-- ./wrapper -->

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
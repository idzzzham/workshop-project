<?php 
  session_start();

  $conn = mysqli_connect("localhost", "root", "", "workshopdb");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jebat Racquet</title>

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    
    <style>

        /* body {
            min-height: 75rem;
        } */

    </style>
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
      <a href="index.html" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
      <img style="height: 40px; width: 40px;" src="../../assets/images/logo.png" alt="" class="img-fluid mx-auto d-block">
        <!-- <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg> -->
      </a>

      <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
        <li><a href="../../index.php" class="nav-link px-2 link-secondary">Home</a></li>
        <?php
            if (isset($_SESSION["user_name"]) && $_SESSION["user_name"] == "admin") {
              // echo '<li><a href="#" class="nav-link px-2 link-secondary">Booking Page</a></li>';
              echo "<li><a href='views/landing-page/admin.php' class='nav-link px-2 link-secondary'>Admin</a></li>";
            }
            else if (isset($_SESSION["user_name"])) {
              echo '<li><a href="booking.php" class="nav-link px-2 link-secondary">Book Now</a></li>';
              echo "<li><a class='nav-link px-2 link-secondary'>" . $_SESSION["user_name"] . "</a></li>";
            }
          ?>
        <!-- <li><a href="#" class="nav-link px-2 link-dark">Features</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
        <li><a href="#" class="nav-link px-2 link-dark">About</a></li> -->
      </ul>

      <div class="col-md-3 text-end">
        <a type="button" class="btn btn-primary me-2" href="../includes/logout.inc.php">Log Out</a>
      </div>
    </header>
</div>
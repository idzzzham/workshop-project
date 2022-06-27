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
    <title>Register</title>
    
    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>
<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="card-body pt-0">
                            <h3 class="text-center mt-5 mb-4">
                                <a href="/" class="d-block auth-logo">
                                    <img style="height: 100px; width: auto;" src="../../assets/images/logo.png" alt="">
                                </a>
                            </h3>
                            <div class="p-3">
                                <h4 class="text-muted font-size-18 mb-1 text-center">Register</h4>
                                <p class="text-muted text-center">Create your account now.</p>
                                <form class="form-horizontal mt-4" action="../includes/register.inc.php" method="post" id="RegForm">

                                    <div class="mb-3">
                                        <label for="username">Name</label>
                                        <input type="text" class="form-control" name="uid" placeholder="Enter name">
                                    </div>

                                    <div class="mb-3">
                                        <label for="useremail">Email</label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter email">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" name="pwd" placeholder="Enter password">
                                    </div>

                                    <div class="mb-3">
                                        <label for="userpassword">Re-enter Password</label>
                                        <input type="password" class="form-control" name="pwdrepeat" placeholder="Enter password">
                                    </div>

                                    <div class="mb-3 row mt-4">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit" name="submit">Register</button>
                                        </div>
                                    </div>

                                    <!-- <div class="mb-0 row">
                                        <div class="col-12 mt-4">
                                            <p class="text-muted mb-0 font-size-14">By registering you agree to the Lexa <a href="#" class="text-primary">Terms of Use</a></p>
                                        </div>
                                    </div> -->
                                </form>
                                <?php
                                    if (isset($_GET["error"])) {
                                        if ($_GET["error"] == "emptyinput") {
                                          echo '<script>alert("Fill in all fields!")</script>';
                                        }
                                        else if ($_GET["error"] == "usernametaken") {
                                            echo '<script>alert("Username already taken!")</script>';
                                        }
                                        else if ($_GET["error"] == "passworddontmatch") {
                                            echo '<script>alert("Password dont match!")</script>';
                                        }
                                        else if ($_GET["error"] == "stmtfailed") {
                                            echo '<script>alert("Something went wrong! Try again!")</script>';
                                        }
                                        else if ($_GET["error"] == "none") {
                                            echo '<script>alert("Register done! Sign in to continue!")</script>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Already have an account ? <a href="login.php" class="text-primary"> Login </a> </p>
                        © <script>document.write(new Date().getFullYear())</script> Idzham <span class="d-none d-sm-inline-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- JAVASCRIPT -->
<script src="../../assets/libs/jquery/jquery.min.js"></script>
<script src="../../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/libs/metismenu/metisMenu.min.js"></script>
<script src="../../assets/libs/simplebar/simplebar.min.js"></script>
<script src="../../assets/libs/node-waves/waves.min.js"></script>
<script src="../../assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- App js -->
<script src="../../assets/js/app.js"></script>
</body>
</html>
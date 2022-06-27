<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
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
                                <a href="../../index.html" class="d-block auth-logo">
                                    <img style="height: 100px; width: auto;" src="../../assets/images/logo.png" alt="">
                                </a>
                            </h3>
                            <div class="p-3">
                                <h4 class="text-muted font-size-18 mb-1 text-center">Welcome !</h4>
                                <p class="text-muted text-center">Sign in to continue to TUAH Badminton</p>
                                <form class="form-horizontal mt-4" action="../includes/login.inc.php" method="post" id="RegForm">
                                    <div class="mb-3">
                                        <label for="username">Name</label>
                                        <input type="text" name="uid" class="form-control" id="username" placeholder="Enter name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword">Password</label>
                                        <input type="password" name="pwd" class="form-control" id="userpassword" placeholder="Enter password">
                                    </div>
                                    <div class="mb-3 row mt-4">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit" name="submit">Log In</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Don't have an account ? <a href="register.php" class="text-primary"> Register Now </a></p>
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
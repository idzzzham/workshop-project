<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
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
                                    <img style="height: 100px; width: auto;" src="/assets/images/logo.png" alt="">
                                </a>
                            </h3>
                            <div class="p-3">
                                <h4 class="text-muted font-size-18 mb-1 text-center">Register</h4>
                                <p class="text-muted text-center">Create your account now.</p>
                                <form class="form-horizontal mt-4" action="index.html">

                                    <div class="mb-3">
                                        <label for="username">Name</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        <label for="useremail">Email</label>
                                        <input type="email" class="form-control" id="useremail" placeholder="Enter email">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                                    </div>

                                    <div class="mb-3">
                                        <label for="userpassword">Re-enter Password</label>
                                        <input type="password" class="form-control" id="userpassword" placeholder="Enter password">
                                    </div>

                                    <div class="mb-3 row mt-4">
                                        <div class="col-12 text-end">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
                                        </div>
                                    </div>

                                    <!-- <div class="mb-0 row">
                                        <div class="col-12 mt-4">
                                            <p class="text-muted mb-0 font-size-14">By registering you agree to the Lexa <a href="#" class="text-primary">Terms of Use</a></p>
                                        </div>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <p>Already have an account ? <a href="/page/auth/login.php" class="text-primary"> Login </a> </p>
                        © <script>document.write(new Date().getFullYear())</script> Lexa <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
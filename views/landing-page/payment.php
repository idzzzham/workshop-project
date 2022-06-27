<?php
    session_start();
    include_once '../includes/dbh.inc.php';

    date_default_timezone_set('Asia/Kuala_Lumpur');
    $date = date('Y-m-d');
    $currenttime = date("H:i");

    function getPosts() {
        $posts = array();
        $posts[0] = $_POST['check_list'];
        $posts[1] = $_POST['date'];
        $posts[2] = $_POST['time'];
        $posts[3] = $_POST['duration'];
        return $posts;
    }

    // book
    if (isset($_SESSION["user_name"])) {
        if (isset($_POST['book'])) {
            $data = getPosts();
            // $courtstring = implode("",$data[0]);
            // $courtid = array_map('intval', explode(',', $courtstring));
            foreach($_POST['check_list'] as $check) {
                // $courtidstring = implode("",$check);
                $courtidint = (int)$check;
                $time = (int)$data[2];
                $duration = (int)$data[3];
                $timetotal = $time + $duration;
                $timestring = (string)$timetotal . ":00:00";
                // var_dump($time);
                // die();

                $name = $_SESSION["user_name"];
                $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '".$_SESSION['user_name']."'";
                $user_result = mysqli_query($conn, $user_query);
                $userid = $user_result->fetch_array()['user_id'] ?? '';

                $price_query = "SELECT `court_price` FROM `courts` WHERE `court_id` = '$courtidint'";
                $price_result = mysqli_query($conn, $price_query);
                $price = $price_result->fetch_array()['court_price'] ?? '';
                $priceint = (int)$price;

                $totalprice = $priceint * $duration;

                $insert_Query = "INSERT INTO 
                `books`(`user_id`, `court_id`, `book_date`, `book_time`, `book_duration`, `book_endtime`, `book_totalprice`, `book_status`) 
                VALUES ('$userid','$courtidint','$data[1]','$data[2]','$data[3]','$timestring','$totalprice','1')";

                try {
                    $insert_Result = mysqli_query($conn, $insert_Query);
                    
                    if ($insert_Result) {
                        if (mysqli_affected_rows($conn) > 0) {
                            // echo '<script>alert("Data Inserted")</script>';
                            $court_query = "UPDATE `courts` SET `court_status`='1' WHERE `court_id`='$courtidint'";
                            $update_result = mysqli_query($conn, $court_query);
                        }
                        else {
                            echo '<script>alert("Data Not Inserted")</script>';
                        }
                    }
                } catch(Exception $ex) {
                    echo 'Error Insert '.$ex->getMessage();
                }
            }
        }
    }

    $data = getPosts();
    $courtidint = (int)$data[0];
    $time = (int)$data[2];  
    $duration = (int)$data[3];
    $timetotal = $time + $duration;
    $timestring = (string)$timetotal . ":00:00";
    $name = (string)$_SESSION['user_name'];
    $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '$name'";
    $user_result = mysqli_query($conn, $user_query);
    $userid = $user_result->fetch_array()['user_id'] ?? '';

    $price_query = "SELECT `court_price` FROM `courts` WHERE `court_id` = '$courtidint'";
    $price_result = mysqli_query($conn, $price_query);
    $price = $price_result->fetch_array()['court_price'] ?? '';
    $priceint = (int)$price;

    $totalprice = $priceint * $duration;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <!-- Bootstrap Css -->
    <link href="../../assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="../../assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="../../assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container page-content" style="margin-top:-50px;">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <div class="invoice-title">
                                    <h4 class="float-end font-size-16"><strong>Order #<?php echo $userid ?></strong></h4>
                                    <h3>
                                        <img src="./../../assets/images/logo.png" alt="logo" height="50"/>
                                    </h3>
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <div class="p-2">
                                        <h3 class="font-size-16"><strong>Payment</strong></h3>
                                    </div>
                                    <div class="">
                                            <div class="table-responsive">
                                            <form action="booking.php" method="post">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>Court</strong></td>
                                                            <td class="text-center"><strong>Type</strong></td>
                                                            <td class="text-center"><strong>Date</strong></td>
                                                            <td class="text-center"><strong>Start Time</strong></td>
                                                            <td class="text-center"><strong>Duration</strong>
                                                            </td>
                                                            <td class="text-end"><strong>Totals</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                        <?php
                                                            // var_dump($a);
                                                            // die();
                                                            $query = "SELECT * FROM `books` b
                                                                        LEFT JOIN `courts` c
                                                                        ON b.court_id = c.court_id
                                                                        WHERE `user_id` = $userid
                                                                        AND b.book_status = '1' 
                                                                        ORDER BY `court_name`";
                                                            $result = mysqli_query($conn, $query);
                                                            if(mysqli_num_rows($result) > 0) {
                                                                $sumtotal = 0;
                                                                while($row = mysqli_fetch_array($result)) {
                                                                    
                                                        ?>
                                                        <tr>
                                                            <input type="hidden" name="check_list[]" value=<?php echo $row["court_id"] ?>>
                                                            <td name="check-list[]">Court <?php echo $row["court_name"] ?></td>
                                                            <td class="text-center" name="type" ><?php echo $row["court_type"] ?></td>
                                                            <td class="text-center" name="date" ><?php echo $row["book_date"] ?></td>
                                                            <td class="text-center" name="date" ><?php echo $row["book_time"] ?></td>
                                                            <td class="text-center" name="duration" ><?php echo $row["book_duration"] ?> hours</td>
                                                            <td class="text-end" >RM<?php echo $totalprice = $row["book_totalprice"] ?>.00</td>
                                                        </tr>
                                                        <?php
                                                            $totalharga = $sumtotal += $totalprice;
                                                                }
                                                            }

                                                        ?>
                                                        <tr>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line"></td>
                                                            <td class="thick-line text-center">
                                                                <strong>Subtotal</strong></td>
                                                            <td class="thick-line text-end">RM<?php echo $totalharga ?>.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Deposit</strong></td>
                                                            <td class="no-line text-end">RM<?php echo $depo = 10 ?>.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line"></td>
                                                            <td class="no-line text-center">
                                                                <strong>Total</strong></td>
                                                            <td class="no-line text-end">
                                                                <h4 class="m-0" name="price" value="<?php $totalharga + $depo ?>">RM<?php echo $totalharga + $depo ?>.00</h4></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        
                                            <div class="d-print-none">
                                                <div class="float-end">
                                                    <button type="submit" name="cancel" class="btn btn-danger waves-effect waves-light">Cancel</button>
                                                    <button type="submit" name="confirm" class="btn btn-success waves-effect waves-light">Pay</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

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
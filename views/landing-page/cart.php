<?php
    include_once 'header2.php';

    function getPosts() {
        $posts = array();
        $posts[0] = $_POST['check_list'];
        // $posts[2] = $_POST['time'];
        // $posts[3] = $_POST['duration'];
        return $posts;
    }

    if (isset($_POST['delete'])) {
        try {
        foreach($_POST['check_list'] as $check) {
            
            $courtidint = (int)$check;

            $data = getPosts();
        
            $court_query = "UPDATE `courts` SET `court_status`='0' WHERE `court_id`='$courtidint'";
            //$delete_Query = "DELETE FROM `books` WHERE `court_id` = $courtidint";
            
            try {
                $delete_Result = mysqli_query($conn, $court_query);
        
                if ($delete_Result) {
                    if (mysqli_affected_rows($conn) > 0) {
                        echo '<script>alert("Booking has been canceled! Refund will take 2 to 3 working days.")</script>';
                        $selectbook = "SELECT `book_id` FROM `books` b
                                LEFT JOIN `courts` c
                                ON b.court_id = $courtidint";
                        $select_result = mysqli_query($conn, $selectbook);
                        $bookid = $select_result->fetch_array()['book_id'] ?? '';
                        $book_query = "UPDATE `books` SET `book_status`='0' 
                                        WHERE `court_id`='$courtidint' AND `book_status`='2'";
                        $update_result = mysqli_query($conn, $book_query);
                    }
                    else {
                        echo '<script>alert("Data not deleted")</script>';
                    }
                }
            } catch(Exception $ex) {
            echo 'Error Delete '.$ex->getMessage();
            }
        } 
    }catch(Exception $ex) {
            echo '<script>alert("Please select court")</script>';
        }
    }

        

    if (isset($_POST['complete'])) {
        
        foreach($_POST['check_list'] as $check) {
            try {
            $courtidint = (int)$check;

            $data = getPosts();

            $book_query = "UPDATE `books` SET `book_status`='3' 
                                        WHERE `court_id`='$courtidint' AND `book_status`='2'";
            $update_result = mysqli_query($conn, $book_query);

            $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '".$_SESSION['user_name']."'";
            $user_result = mysqli_query($conn, $user_query);
            $userid = $user_result->fetch_array()['user_id'] ?? '';

            $selectbook = "SELECT `book_id` FROM `books` b
                            WHERE `book_status` = '3'
                            AND `court_id` = '$courtidint'";
            $select_result = mysqli_query($conn, $selectbook);
            $bookid = $select_result->fetch_array()['book_id'] ?? '';

            $history_query = "INSERT INTO `history`(`book_id`) VALUES ('$bookid')";
            $history_Result = mysqli_query($conn, $history_query);
            
            $selectcourt = "SELECT `court_id` FROM `books` b
                            LEFT JOIN `history` h
                            ON b.book_id = h.book_id
                            WHERE b.court_id = '$courtidint'";
            $court_result = mysqli_query($conn, $selectcourt);
            $courtidhistory = $court_result->fetch_array()['court_id'] ?? '';

            $court_query = "UPDATE `courts` SET `court_status`='0' WHERE `court_id`='$courtidhistory'";
            $courtid_result = mysqli_query($conn, $court_query);

            // die();
            // $select_query = "SELECT `book_id` FROM `books` b
            //                     LEFT JOIN `courts` c
            //                     ON b.court_id = $courtidint";
            // $select_result = mysqli_query($conn, $select_query);
            // $bookidstring = $select_result->fetch_array()['book_id'] ?? '';
            // $bookidint = (int)$bookidstring;
            // // var_dump($bookidint);
            // // die();

            

            // $selectbook = "SELECT `book_id` FROM `books` b
            //                 WHERE `book_status` = '3'";
            // $select_result = mysqli_query($conn, $selectbook);
            // $bookid = $select_result->fetch_array()['book_id'] ?? '';
            // // var_dump($bookid);
            // // die();
            
            // try {
                
        
            //     if ($update_result) {
            //         if (mysqli_affected_rows($conn) > 0) {
            //             //echo '<script>alert("Data deleted")</script>';
            //             $court_query = "UPDATE `courts` SET `court_status`='0' WHERE `court_id`='$courtidint'";
            //             $delete_result = mysqli_query($conn, $court_query);
            //             $selectbook = "SELECT `book_id` FROM `books` b
            //                             WHERE `book_status` = '3'";
            //             $select_result = mysqli_query($conn, $selectbook);
            //             $bookid = $select_result->fetch_array()['book_id'] ?? '';

            //             $history_query = "INSERT INTO `history`(`book_id`) VALUES ('$bookid')";
            //             $history_Result = mysqli_query($conn, $history_query);
            //         }
            //         else {
            //             echo '<script>alert("Data not deleted")</script>';
            //         }
                    
            //     }
                
            // } catch(Exception $ex) {
            // echo 'Error Delete '.$ex->getMessage();
            // }
        } catch(Exception $ex) {
            echo '<script>alert("Please select court")</script>';
        }
        }
    
}
?>

<!-- display court -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card" style="border:none;">
                <div class="card-body">
                    <h4 class="card-title">Upcoming Courts</h4>
                        <form class="form-control mt-2" action="cart.php" method="post">
                            <div class="mb-3 row">
                                <?php
                                    $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '".$_SESSION['user_name']."'";
                                    $user_result = mysqli_query($conn, $user_query);
                                    $userid = $user_result->fetch_array()['user_id'] ?? '';
                                    $query = "SELECT * FROM `books` b 
                                                LEFT JOIN `courts` c 
                                                ON b.court_id = c.court_id
                                                WHERE b.user_id = $userid
                                                AND b.book_status = 2
                                                ORDER BY b.book_date";
                                    $result = mysqli_query($conn, $query);
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_array($result)) {
                                ?>
                            <div class="col-sm-3">
                                <div class="text-center">
                                        <?php
                                            if($row["court_type"] == "Wooden") {
                                        ?>
                                                <input type="checkbox" name="check_list[]" value=<?php echo $row["court_id"] ?>>
                                                <img src="../../assets/images/wooden-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                                <input type="hidden" name="date" value=<?php $row["book_date"] ?>>
                                                <p>Date : <?php echo $row["book_date"] ?><p>
                                                <p>Time : <?php echo $row["book_time"] ?> - <?php echo $row["book_endtime"] ?><p>
                                                <p>Duration : <?php echo $row["book_duration"] ?> hours<p>
                                                <p>Total price : RM<?php echo $row["book_totalprice"] ?>.00<p>
                                        <?php
                                            } else if($row["court_type"] == "Synthetic") {
                                        ?>
                                                <input type="checkbox" name="check_list[]" value=<?php echo $row["court_id"] ?>>
                                                <img src="../../assets/images/badminton-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                                <input type="hidden" name="date" value=<?php $row["book_date"] ?>>
                                                <p>Date : <?php echo $row["book_date"] ?><p>
                                                <p>Time : <?php echo $row["book_time"] ?> - <?php echo $row["book_endtime"] ?><p>
                                                <p>Duration : <?php echo $row["book_duration"] ?> hours<p>
                                                <p>Total price : RM<?php echo $row["book_totalprice"] ?>.00<p>
                                        <?php
                                            }
                                        ?>
                                </div> 
                            </div>
                                <?php
                                        }
                                    } else {
                                ?>
                                        <p class="text-center">No bookings available<p>
                                <?php
                                    }
                                ?>
                            </div>
                            <div class="mt-2 d-grid gap-2 justify-content-md-center">
                                <?php
                                    if(mysqli_num_rows($result) > 0) {
                                        ?>
                                        <button type="submit" name="delete" class="btn btn-outline-danger w-md validity">Cancel Booking</button>
                                        <button type="submit" name="complete" class="btn btn-outline-success w-md validity">Complete</button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" name="delete" class="btn btn-outline-primary w-md validity" disabled>Cancel Booking</button>
                                        <button type="submit" name="complete" class="btn btn-outline-success w-md validity" disabled>Complete</button>
                                        <?php
                                    }
                                ?>
                                
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card" style="border:none;">
                <div class="card-body">
                    <h4 class="card-title">History</h4>
                            <div class="mb-3 row">
                                <?php
                                    $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '".$_SESSION['user_name']."'";
                                    $user_result = mysqli_query($conn, $user_query);
                                    $userid = $user_result->fetch_array()['user_id'] ?? '';
                                    $query = "SELECT * FROM `history` h
                                                LEFT JOIN `books` b
                                                ON h.book_id = b.book_id
                                                LEFT JOIN `courts` c
                                                ON b.court_id = c.court_id
                                                WHERE b.user_id = $userid
                                                AND b.book_status = 3
                                                ORDER BY b.book_date";
                                    $result = mysqli_query($conn, $query);
                                    if(mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_array($result)) {
                                ?>
                            <div class="col-sm-3">
                                <div class="text-center">
                                        <?php
                                            if($row["court_type"] == "Wooden") {
                                        ?>
                                                <img src="../../assets/images/wooden-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                                <p>Date : <?php echo $row["book_date"] ?><p>
                                                <p>Time : <?php echo $row["book_time"] ?> - <?php echo $row["book_endtime"] ?><p>
                                                <p>Duration : <?php echo $row["book_duration"] ?> hours<p>
                                                <p>Total price : RM<?php echo $row["book_totalprice"] ?>.00<p>
                                        <?php
                                            } else if($row["court_type"] == "Synthetic") {
                                        ?>
                                                <img src="../../assets/images/badminton-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                                <p>Date : <?php echo $row["book_date"] ?><p>
                                                <p>Time : <?php echo $row["book_time"] ?> - <?php echo $row["book_endtime"] ?><p>
                                                <p>Duration : <?php echo $row["book_duration"] ?> hours<p>
                                                <p>Total price : RM<?php echo $row["book_totalprice"] ?>.00<p>
                                        <?php
                                            }
                                        ?>
                                </div> 
                            </div>
                                <?php
                                        }
                                    } else {
                                ?>
                                        <p class="text-center">No history available<p>
                                <?php
                                    }
                                ?>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>
<?php
    include_once 'footer2.php';
?>
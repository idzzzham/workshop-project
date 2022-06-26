<?php
    include_once 'header2.php';

    function getPosts() {
        $posts = array();
        $posts[0] = $_POST['check_list'];
        // $posts[1] = $_POST['date'];
        // $posts[2] = $_POST['time'];
        // $posts[3] = $_POST['duration'];
        return $posts;
    }

    if (isset($_POST['delete'])) {
        foreach($_POST['check_list'] as $check) {
            $courtidint = (int)$check;

            $data = getPosts();
        
            $delete_Query = "DELETE FROM `books` WHERE `court_id` = $courtidint";
            
            try {
                $delete_Result = mysqli_query($conn, $delete_Query);
        
                if ($delete_Result) {
                    if (mysqli_affected_rows($conn) > 0) {
                        echo '<script>alert("Data deleted")</script>';
                        $court_query = "UPDATE `courts` SET `court_status`='0' WHERE `court_id`='$courtidint'";
                        $delete_result = mysqli_query($conn, $court_query);
                    }
                    else {
                        echo '<script>alert("Data not deleted")</script>';
                    }
                }
            } catch(Exception $ex) {
            echo 'Error Delete '.$ex->getMessage();
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
                                                AND c.court_status = 1";
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
                                                <p>Date : <?php echo $row["book_date"] ?><p>
                                                <p>Start Time : <?php echo $row["book_time"] ?><p>
                                                <p>Duration : <?php echo $row["book_duration"] ?> hours<p>
                                                <p>End Time : <?php echo $row["book_endtime"] ?><p>
                                        <?php
                                            } else if($row["court_type"] == "Synthetic") {
                                        ?>
                                                <input type="checkbox" name="check_list[]" value=<?php echo $row["court_id"] ?>>
                                                <img src="../../assets/images/badminton-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                                <p>Date : <?php echo $row["book_date"] ?><p>
                                                <p>Start Time : <?php echo $row["book_time"] ?><p>
                                                <p>Duration : <?php echo $row["book_duration"] ?> hours<p>
                                                <p>End Time : <?php echo $row["book_endtime"] ?><p>
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
                                        <button type="submit" name="delete" class="btn btn-outline-primary w-md validity">Cancel Booking</button>
                                        <?php
                                    } else {
                                        ?>
                                        <button type="submit" name="delete" class="btn btn-outline-primary w-md validity" disabled>Cancel Booking</button>
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

<?php
    include_once 'footer2.php';
?>
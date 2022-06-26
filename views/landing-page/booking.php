<?php
    include_once 'header2.php';

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
                // var_dump($timestring);
                // die();

                $name = $_SESSION["user_name"];
                $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '".$_SESSION['user_name']."'";
                $user_result = mysqli_query($conn, $user_query);
                $userid = $user_result->fetch_array()['user_id'] ?? '';
            
                $insert_Query = "INSERT INTO `books`(`user_id`, `court_id`, `book_date`, `book_time`, `book_duration`, `book_endtime`) VALUES ('$userid','$courtidint','$data[1]','$data[2]','$data[3]','$timestring')";
        
                try {
                    $insert_Result = mysqli_query($conn, $insert_Query);
                    
        
                    if ($insert_Result) {
                        if (mysqli_affected_rows($conn) > 0) {
                            echo '<script>alert("Data Inserted")</script>';
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

                $endtime = $timestring;
                if ($currenttime == $endtime) {
                    $court_query = "UPDATE `courts` SET `court_status`='0' WHERE `court_id`='$courtidint'";
                    $update_result = mysqli_query($conn, $court_query);
                }   
                // var_dump($endtime);
                // die();
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
                    <h4 class="card-title">Book Courts</h4>
                        <form class="form-control mt-2" action="booking.php" method="post">
                            <div class="mb-3 row">
                                <label for="date" class="col-md-2 col-form-label">Choose the date</label>
                                <div class="col-md-10">
                                    <input class="form-control form-control-md" type="date" name="date" min="<?php echo $date ?>" value="<?php echo $date ?>" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="date" class="col-md-2 col-form-label">Choose start time</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-md" name="time" style="margin-top:5px;" required>
                                        <option value="">Time</option>
                                        <option name="time" value="11:00:00">11:00 AM</option>
                                        <option name="time" value="12:00:00">12:00 PM</option>
                                        <option name="time" value="13:00:00">1:00 PM</option>
                                        <option name="time" value="14:00:00">2:00 PM</option>
                                        <option name="time" value="15:00:00">3:00 PM</option>
                                        <option name="time" value="16:00:00">4:00 PM</option>
                                        <option name="time" value="17:00:00">5:00 PM</option>
                                        <option name="time" value="18:00:00">6:00 PM</option>
                                        <option name="time" value="19:00:00">7:00 PM</option>
                                        <option name="time" value="20:00:00">8:00 PM</option>
                                        <option name="time" value="21:00:00">9:00 PM</option>
                                        <option name="time" value="22:00:00">10:00 PM</option>
                                    </select>
                                    <!-- <input class="form-control form-control-md" type="time" name="time" value="<?php echo $currenttime ?>" required> -->
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="date" class="col-md-2 col-form-label">Choose duration</label>
                                <div class="col-md-10">
                                    <select class="form-control form-control-md" name="duration" style="margin-top:5px;" required>
                                        <option value="">Duration</option>
                                        <option name="duration" value=1>1 hour</option>
                                        <option name="duration" value=2>2 hours</option>
                                        <option name="duration" value=3>3 hours</option>
                                        <option name="duration" value=4>4 hours</option>
                                    </select>
                                    <!-- <input class="form-control form-control-md" type="time" name="time" value="<?php echo $currenttime ?>" required> -->
                                </div>
                            </div>
                            
                            <div class="mb-3 row">
                                <?php
                                    $query = "SELECT * FROM `courts` WHERE `court_status` = 0 ORDER BY `court_name`";
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
                                        <?php
                                            } else if($row["court_type"] == "Synthetic") {
                                        ?>
                                                <input type="checkbox" name="check_list[]" value=<?php echo $row["court_id"] ?>>
                                                <img src="../../assets/images/badminton-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                        <?php
                                            }

                                        ?>
                                </div> 
                            </div>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="mt-2 d-grid gap-2 justify-content-md-center">
                                        <button type="submit" name="book" class="btn btn-outline-primary w-md validity">Book now</button>
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
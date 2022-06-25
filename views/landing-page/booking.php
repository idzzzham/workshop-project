<?php
    include_once 'header2.php';

    $date = date('Y-m-d');
    $currenttime = date("H:i");

    function getPosts() {
        $posts = array();
        $posts[0] = $_POST['check_list'];
        $posts[1] = $_POST['date'];
        $posts[2] = $_POST['time'];
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
                // var_dump($check);
                // die();

                $name = $_SESSION["user_name"];
                $user_query = "SELECT `user_id` FROM `users` WHERE `user_name` = '".$_SESSION['user_name']."'";
                $user_result = mysqli_query($conn, $user_query);
                $userid = $user_result->fetch_array()['user_id'] ?? '';
            
                $insert_Query = "INSERT INTO `books`(`user_id`, `court_id`, `book_date`, `book_time`) VALUES ('$userid','$courtidint','$data[1]','$data[2]')";
        
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
                    <h4 class="card-title">Courts</h4>
                        <form class="form-control mt-2" action="booking.php" method="post">
                            <div class="mb-3 row">
                                <label for="date" class="col-md-2 col-form-label">Choose the Date</label>
                                <div class="col-md-10">
                                    <input class="form-control form-control-md" type="date" name="date" min="<?php echo $date ?>" value="<?php echo $date ?>" required>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="date" class="col-md-2 col-form-label">Choose the Time</label>
                                <div class="col-md-10">
                                    <input class="form-control form-control-md" type="time" name="time" value="<?php echo $currenttime ?>" required>
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
                                            if($row["court_type"] == "Wooden Court") {
                                        ?>
                                                <input type="checkbox" name="check_list[]" value=<?php echo $row["court_id"] ?>>
                                                <img src="../../assets/images/wooden-court.png" style="width: 50%;">
                                                <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                        <?php
                                            } else if($row["court_type"] == "Synthetic Court") {
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
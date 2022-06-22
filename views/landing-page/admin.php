<?php
    include_once 'header2.php';
    include_once '../includes/dbh.inc.php';

    $id = "";
    $name = "";
    $type = "";

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try {
        $conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);
    } catch(Exception $ex) {
        echo 'Error';
    }

    function getPosts() {
        $posts = array();
        $posts[0] = $_POST['id'];
        $posts[1] = $_POST['name'];
        $posts[2] = $_POST['type'];
        return $posts;
    }

    // insert
    if (isset($_POST['insert'])) {

        $data = getPosts();
      
	    $insert_Query = "INSERT INTO `courts`(`court_name`, `court_type`) VALUES ('$data[1]','$data[2]')";
	
        try {
            $insert_Result = mysqli_query($conn, $insert_Query);

            if ($insert_Result) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo '<script>alert("Data Inserted")</script>';
                }
                else {
                    echo '<script>alert("Data Not Inserted")</script>';
                }
            }
        } catch(Exception $ex) {
            echo 'Error Insert '.$ex->getMessage();
        }
    }

    //update
    if (isset($_POST['update'])) {

        $data = getPosts();
      
        $update_Query = "UPDATE `courts` SET `court_name`='$data[1]',`court_type`='$data[2]' WHERE `court_id`='$data[0]'";
      
        try {
          $update_Result = mysqli_query($conn, $update_Query);
      
          if ($update_Result) {
            if (mysqli_affected_rows($conn) > 0) {
              echo '<script>alert("Data updated")</script>';
            }
            else {
              echo '<script>alert("Data not updated")</script>';
            }
          }
        } catch(Exception $ex) {
          echo 'Error Update '.$ex->getMessage();
        }
      }

    //delete
    if (isset($_POST['delete'])) {

        $data = getPosts();
    
        $delete_Query = "DELETE FROM `courts` WHERE `court_id` = $data[0]";
    
        try {
            $delete_Result = mysqli_query($conn, $delete_Query);
    
            if ($delete_Result) {
                if (mysqli_affected_rows($conn) > 0) {
                    echo '<script>alert("Data deleted")</script>';
                }
                else {
                    echo '<script>alert("Data not deleted")</script>';
                }
            }
        } catch(Exception $ex) {
        echo 'Error Delete '.$ex->getMessage();
        }
    }

?>

<!-- display court -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Courts</h4>
                    <div class="mb-3 row">
                        <?php
                            $query = "SELECT * FROM `courts` ORDER BY `court_name`";
                            $result = mysqli_query($conn, $query);
                            if(mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_array($result)) {
                        ?>
                        <div class="col-sm-3">
                            <form class="form-control-sm mt-2" action="admin.php" method="post">
                                <div class="text-center">
                                    <img src="../../assets/images/badminton-court.png" style="width: 50%;">
                                    <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                    <input type="hidden" name="id" value="<?php echo $row['court_id'] ?>">
                                    <input class="form-control form-control-sm" type="text" name="name" value="<?php $row['court_name'] ?>" placeholder="Change court name">
                                    <select class="form-control form-control-sm" name="type" style="margin-top:5px;">
                                        <option>Change Court Type</option>
                                        <option name="type" value="Wooden Court">Wooden Court</option>
                                        <option name="type" value="Synthetic Court">Synthetic Court</option>
                                    </select>
                                    <div class="mt-4 d-grid gap-2 justify-content-md-center">
                                        <button type="submit" name="update" class="btn btn-outline-primary w-md">Update</button>
                                        <button type="submit" name="delete" class="btn btn-outline-primary w-md">Delete</button>
                                    </div> 
                                </div>  
                            </form>
                        </div><!-- end row --> 
                        <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
</div>

<!-- add court -->
<div class="container" style="margin-top: 25px;">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Court</h4>
                    <form class="form-horizontal mt-3" action="admin.php" method="post">
                        <input type="hidden" name="id" placeholder="Court ID" value="<?php echo $id ?>">
                        <div class="mb-3 row">
                            <label for="example-number-input" class="col-md-2 col-form-label">Court Name</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="name" value="<?php echo $name ?>">
                            </div>
                        </div><!-- end row -->
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Court Type</label>
                            <div class="col-md-10">
                                <select class="form-control" name="type">
                                    <option>Select</option>
                                    <option name="type" value="Wooden Court">Wooden Court</option>
                                    <option name="type" value="Synthetic Court">Synthetic Court</option>
                                </select>
                            </div>
                        </div><!-- end row -->
                        <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" name="insert" class="btn btn-outline-primary w-md">Add</button>
                        </div>
                    </form>
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

<?php
    include_once 'header2.php';
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
                            <form class="form-control mt-2" action="booking.php" method="post">
                                <div class="text-center">
                                    <img src="../../assets/images/badminton-court.png" style="width: 50%;">
                                    <p>Court <?php echo $row["court_name"] ?> : <?php echo $row["court_type"] ?><p>
                                    <div class="mt-2 d-grid gap-2 justify-content-md-center">
                                        <button type="submit" name="book" class="btn btn-outline-primary w-md">Book now</button>
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

<?php
    include_once 'footer2.php';
?>
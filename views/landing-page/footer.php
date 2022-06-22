<div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="index.php" class="nav-link px-2 text-muted">Home</a></li>
      <li><a href="views/landing-page/booking.php" class="nav-link px-2 link-secondary">Book Now</a></li>
        <?php
          if (isset($_SESSION["user_name"]) && $_SESSION["user_name"] == "admin") {
            echo "<li><a href='adminpanel.php' class='nav-link px-2 link-secondary'>Admin Page</a></li>";
          }
          else if (isset($_SESSION["user_name"])) {
            echo "<li><a class='nav-link px-2 link-secondary'>" . $_SESSION["user_name"] . "</a></li>";
          }
        ?>
      <!-- <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Features</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Pricing</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">About</a></li> -->
    </ul>
    <p class="text-center text-muted">&copy; 2022 Company, Inc</p>
  </footer>
</div>

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/metismenu/metisMenu.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/jquery-sparkline/jquery.sparkline.min.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

</body>
</html>
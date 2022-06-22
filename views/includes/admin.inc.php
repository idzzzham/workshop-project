<?php
    // insert
    if (isset($_POST['insert'])) {

        $name = $_POST["name"];
	    $type = $_POST["type"];

        require_once "dbh.inc.php";
        require_once "functions.inc.php";
    
        insertCourt($conn, $id, $name, $type);
        
    }
    else {
        header("location: ../landing-page/admin.php");
        exit();
    }
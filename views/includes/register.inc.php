<?php

if (isset($_POST["submit"])) {

	$username = $_POST["uid"];
	$email = $_POST["email"];
	$pwd = $_POST["pwd"];
	$pwdrepeat = $_POST["pwdrepeat"];

	require_once 'dbh.inc.php';
	require_once 'functions.inc.php';

	if (emptyInputSignup($username, $email, $pwd, $pwdrepeat) !== false) {
		header("location: ../auth/register.php?error=emptyinput");
		exit();
	}
    else if (uidExist($conn, $username) !== false) {
        header("location: ../auth/register.php?error=usernametaken");
        exit();
    }
    else if (pwdMatch($pwd, $pwdrepeat) !== false) {
		header("location: ../auth/register.php?error=passworddontmatch");
		exit();
	}
	// else if (invalidUid($username) !== false) {
	// 	header("location: ../auth/register.php?error=invaliduid");
	// 	exit();
	// }
	// if (invalidEmail($email) !== false) {
	// 	header("location: ../auth/register.php?error=invalidemail");
	// 	exit();
	// }
	
	// if (uidExist($conn, $username) !== false) {
	// 	header("location: ../auth/register.php?error=usernametaken");
	// 	exit();
	// }

	createUser($conn, $username, $email, $pwd);
	
}
else {
    echo '<script>alert("Error")</script>';
	header("location: ../auth/register.php");
	exit();
}
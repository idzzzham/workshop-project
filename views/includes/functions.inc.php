<?php

include_once "dbh.inc.php";

function createUser($conn, $username, $email, $pwd) {
	$userid = random_num(20);
	$sql = "INSERT INTO users (user_id, user_name, user_email, user_pwd) VALUES ($userid, ?, ?, ?);";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../auth/register.php?error=stmtfailed");
		exit();
	}

	$hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

	mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPwd);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	header("location: ../auth/login.php?error=none");
	exit();
    // $sql = "INSERT INTO `users`(`user_id`, `user_name`, `user_email`, `user_pwd`) VALUES ('$userid', '$username','$email','$hashedPwd')";

    // if (mysqli_query($conn, $sql)) {
    //     header("location: ../auth/register.php?error=none");
    // } else {
    //     echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    // }
}

function random_num($length) {
	$text = "";
	if ($length < 5) {
		$length = 5;
	}

	$len = rand(4, $length);

	for ($i=0; $i < $len; $i++) { 
		$text .= rand(0, 9);
	}

	return $text;
}

function loginUser($conn, $username, $pwd) {
	$uidExists = uidExist($conn, $username);

	if ($uidExists === false) {
		header("location: ../auth/login.php?error=wrongusername");
		exit();
	}

	$pwdHashed = $uidExists["user_pwd"];
	$checkPwd = password_verify($pwd, $pwdHashed);

	if ($checkPwd == false) {
		header("location: ../auth/login.php?error=wrongpassword");
		exit();
	}
	else if ($checkPwd === true) {
		session_start();

	 	$_SESSION["user_name"] = $uidExists["user_name"];
        if (isset($_SESSION["user_name"]) && $_SESSION["user_name"] == "admin") {
            header("location: ../landing-page/admin.php " );
        }
        else {
            header("location: ../../index.php " );
        }
	}
}

function uidExist($conn, $username) {
	$sql = "SELECT * FROM `users` WHERE `user_name` = ?;";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		header("location: ../auth/login.php?error=stmtfailed");
		exit();
	}

	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);

	$resultData = mysqli_stmt_get_result($stmt);

	if ($row = mysqli_fetch_assoc($resultData)) {
		return $row;
	}
	else {
		$result = false;
		return $result;
	}

	mysqli_stmt_close($stmt);
}

function emptyInputSignup($username, $email, $pwd, $pwdrepeat) {
	if (empty($username) || empty($email) || empty($pwd) || empty($pwdrepeat)) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function pwdMatch($pwd, $pwdrepeat) {
	if ($pwd !== $pwdrepeat) {
		$result = true;
	}
	else {
		$result = false;
	}
	return $result;
}

function insertCourt($conn, $id, $name, $type) {

	$id;
	$name;
	$type;

	$data = getPosts();
      
	$insert_Query = "INSERT INTO `courts`(`court_name`, `court_type`) VALUES ('$data[1]','$data[2]')";
	
	try {
		$insert_Result = mysqli_query($conn, $insert_Query);

		if ($insert_Result) {
			if (mysqli_affected_rows($conn) > 0) {
				echo '<script>alert("Data Inserted")</script>';
				header("location: ../landing-page/admin.php");
	    		exit();
			}
			else {
				echo '<script>alert("Data Not Inserted")</script>';
			}
		}
	} catch(Exception $ex) {
	echo 'Error Insert '.$ex->getMessage();
	}
}

function getPosts() {
	$posts = array();
	$posts[0] = $_POST['id'];
	$posts[1] = $_POST['name'];
	$posts[2] = $_POST['type'];
	return $posts;
  }

// function invalidUid($username) {
// 	if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
// 		$result = true;
// 	}
// 	else {
// 		$result = false;
// 	}
// 	return $result;
// }

// function invalidEmail($email) {
// 	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
// 		$result = true;
// 	}
// 	else {
// 		$result = false;
// 	}
// 	return $result;
// }





// function emptyInputLogin($username, $pwd) {
// 	if (empty($username) ||  empty($pwd)) {
// 		$result = true;
// 	}
// 	else {
// 		$result = false;
// 	}
// 	return $result;
// }

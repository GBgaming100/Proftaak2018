<?php

include("../functions.php");
$salt = "8dC_9Kl?";


$username = $_POST['username'];

$email = $_POST['username'];

$password = $_POST['password'];

$salt = "8dC_9Kl?";

$encrypted = md5($password . $salt);

	

    $sql = "SELECT user_id, user_name FROM users WHERE (user_name = ? OR user_email = ?) AND user_password = ?;";

    $params = [ "sss", &$username, &$email, &$encrypted];

    $user = GetFromDatabase($sql, $params);

	if (empty($user)) {

		$message = "Wrong Password or Username";
		$type = "danger";
	}
	else {
		$user = $user[0];

		$_SESSION["user"] = $user['user_name'];
		$_SESSION["id"] = $user['user_id'];

		$message =  $user['user_name'].", you have succesfully logged in";
		$type = "success";

	}
		addMessage($type, $message);

		if(isset($_REQUEST["destination"])){
				header("Location: {$_REQUEST["destination"]}");
			}else if(isset($_SERVER["HTTP_REFERER"])){
				header("Location: {$_SERVER["HTTP_REFERER"]}");
			}

	end();
?>
<?php
	include("../functions.php");

	$salt = "8dC_9Kl?";


	$name = $_POST['username'];

	$email = $_POST['mail'];

	$password = $_POST['password'];

	$encrypted = md5($password . $salt);

	$nameUsed = true;
	$emailUsed = true;

	$message = "";
	$type = "";

	if(isset($name) && isset($email) && isset($password))
	{
		if($name != "" && $email != "" && $password != "") {


		$sql = "SELECT user_id, user_name FROM users WHERE user_name = '".$name."'";

     	$username = connectWithDatabase($sql);

		if(empty($username))
		{
			$nameUsed = false;
			$message .= "Email is allready used";
			$type = "danger";
		}

		$sql = "SELECT user_id, user_name FROM users WHERE user_email = '".$email."'";

     	$useremail = connectWithDatabase($sql);

		if(empty($useremail))
		{
			$emailUsed = false;
			$message .= "Username is allready used";
			$type = "danger";
		}

		if($nameUsed == false && $emailUsed == false)
		{
			$message = $name .", your account has been created";
			$type = "success";

			$_SESSION["user"] = $name;

			$sql = "INSERT INTO users (user_name, user_email, user_password)VALUES ('".$name."', '".$email."', '".$encrypted."')";
			
			connectWithDatabase($sql);
		}
		else
		{
			$message = "Email and username are allready used";
			$type = "danger";
		}
		addMessage($type, $message);
		}
	}

	if(isset($_REQUEST["destination"])){
				header("Location: {$_REQUEST["destination"]}");
			}else if(isset($_SERVER["HTTP_REFERER"])){
				header("Location: {$_SERVER["HTTP_REFERER"]}");
			}

	end();
	
?>
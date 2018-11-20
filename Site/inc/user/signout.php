<?php
	include("../functions.php"); 
	
		$message = $_SESSION['user'] .", you have successfully logged out.";
		$type = "success";

		addMessage($type, $message);
		
	unset($_SESSION['user']);
	unset($_SESSION['id']);

	if(isset($_REQUEST["destination"])){
				header("Location: {$_REQUEST["destination"]}");
			}else if(isset($_SERVER["HTTP_REFERER"])){
				header("Location: {$_SERVER["HTTP_REFERER"]}");
			}

	end();

?>
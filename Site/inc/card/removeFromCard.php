<?php
    include("../functions.php");

	$value = $_POST['productId'];
	$user_id = $_POST['userId'];

	$sql = "DELETE FROM myCard WHERE product_id = '". $value ."' AND user_id = '". $user_id ."';";
	echo $sql;
	connectWithDatabase($sql);

	$sql = "SELECT distinct name FROM products WHERE id = ".$value;
	$product = connectWithDatabase($sql)[0]['name'];
	
	addMessage("info", $product.", is van de lijst verwijderd.");

?>
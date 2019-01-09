<?php
    include("../functions.php");

	$value = $_POST['productId'];
	$user_id = $_POST['userId'];

	$sql = "SELECT distinct p.name as name FROM products p JOIN mycard c ON p.id = c.product_id WHERE c.id = ".$value;
	$product = connectWithDatabase($sql)[0]['name'];
	
	addMessage("info", $product.", is van de lijst verwijderd.");

	$sql = "DELETE FROM mycard WHERE id = '". $value ."' AND user_id = '". $user_id ."';";
	connectWithDatabase($sql);
?>
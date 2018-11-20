<?php
    include("../functions.php");

	$value = $_POST['productId'];
	$vending_id = $_POST['vendingId'];
	$user_id = $_POST['userId'];

	$sql = "INSERT INTO myCard (user_id, product_id, vending_id) VALUES ('". $user_id ."', '". $value ."', '". $vending_id ."');";

	connectWithDatabase($sql);

	$sql = "SELECT distinct name FROM products WHERE id = ".$value;
	$product = connectWithDatabase($sql)[0]['name'];
	
	addMessage("success", $product.", is aan de lijst toegevoegd.");

?>
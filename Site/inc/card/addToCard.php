<?php
    include("../functions.php");

	$value = $_POST['productId'];
	$vending_id = $_POST['vendingId'];

	$sql = "INSERT INTO myCard (user_id, product_id, vending_id) VALUES (1, '". $value ."', '". $vending_id ."');";

	connectWithDatabase($sql);

?>
<?php
    include("../functions.php");

    $userId = $_POST['userId'];
	$vendingId = $_POST['vendingId'];
	$productPosition = $_POST['productPosition'];	

	$sql = "SELECT u.user_credit as credit, p.price as price FROM users u, products p WHERE u.user_id = ".$userId." AND p.id = (SELECT product_id FROM vendingassortiment WHERE machine_id = 1 AND position = 42)";
	$newBalance = connectWithDatabase($sql)[0]['credit'] - connectWithDatabase($sql)[0]['price'];
	
	$sql = "INSERT INTO transactions (user_id, price, product_id) VALUES (".$userId.", ". connectWithDatabase($sql)[0]['price'].", (SELECT product_id FROM vendingassortiment WHERE position = ".$productPosition." AND machine_id = ".$vendingId."));";
	connectWithDatabase($sql);

	$sql = "UPDATE users SET user_credit = ".$newBalance." WHERE user_id = ".$userId.";";
	connectWithDatabase($sql);

	$sql = "DELETE FROM myCard WHERE product_id = (SELECT product_id FROM vendingassortiment WHERE position = ".$productPosition." AND machine_id = ".$vendingId.") AND user_id = '". $userId ."';";
	connectWithDatabase($sql);

?>
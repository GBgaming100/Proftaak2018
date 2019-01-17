<?php
    include("../functions.php");

	$value = $_POST['productId'];
	$vending_id = $_POST['vendingId'];
	$user_id = $_POST['userId'];

	$sql = "INSERT INTO mycard (user_id, product_id, vending_id) VALUES (?, ?, ?);";
	$params = ['iii', &$user_id, &$value, &$vending_id];

	PostToDatabase($sql, $params);

	$sql = "SELECT distinct name FROM products WHERE id = ?;";
	$params = ['i', &$value];

	$product = GetFromDatabase($sql, $params)[0]['name'];
	
	addMessage("success", $product.", is aan de lijst toegevoegd.");

?>
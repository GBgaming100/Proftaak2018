<?php
    include("../functions.php");

	$value = $_POST['productId'];
	$user_id = $_POST['userId'];

	$sql = "SELECT distinct p.name as name FROM products p JOIN mycard c ON p.id = c.product_id WHERE c.id = ?;";
	$params = ['i', &$value];

	$product = GetFromDatabase($sql, $params)[0]['name'];
	
	addMessage("info", $product.", is van de lijst verwijderd.");

	$sql = "DELETE FROM mycard WHERE id = '". $value ."' AND user_id = '". $user_id ."';";
	$params = ['ii', &$value, &$user_id];

	PostToDatabase($sql, $params);
?>
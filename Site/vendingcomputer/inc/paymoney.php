<?php
    include("../../inc/functions.php");

    $userId = $_POST['userId'];
	$vendingId = $_POST['vendingId'];
	$productPosition = $_POST['productPosition'];	

	$sql = "SELECT u.user_credit as credit, p.price as price FROM users u, products p WHERE u.user_id = ? AND p.id = (SELECT product_id FROM vendingassortiment WHERE machine_id = ? AND position = ?)";
	$params = ['iii', &$userId, &$vendingId, &$productPosition];

	$price = GetFromDatabase($sql, $params)[0]['price'];
	$newBalance = GetFromDatabase($sql, $params)[0]['credit'] - $price;
	
	$sql = "INSERT INTO transactions (user_id, price, product_id) VALUES (?, ?, (SELECT product_id FROM vendingassortiment WHERE position = ? AND machine_id = ?));";
	$params = ['iiii', &$userId, &$price, &$vendingId, &$productPosition];

	PostToDatabase($sql, $params);

	$sql = "UPDATE users SET user_credit = ? WHERE user_id = ?;";
	$params = ['ii', &$newBalance, &$userId];

	PostToDatabase($sql, $params);

	$sql = "DELETE FROM mycard WHERE product_id = (SELECT product_id FROM vendingassortiment WHERE position = ? AND machine_id = ?) AND user_id = ?;";
	$params = ['iii', &$productPosition, &$vendingId, &$userId];

	PostToDatabase($sql, $params);

?>
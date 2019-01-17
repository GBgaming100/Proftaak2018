<?php
    include("../../inc/functions.php");

	$vendingId = $_POST['vendingId'];
	$productPosition = $_POST['productPosition'];

	$sql = "SELECT stock FROM vendingassortiment WHERE machine_id = ? AND position = ?;";
	$params = ['ii', &$vendingId, &$productPosition];

	$currentStock = GetFromDatabase($sql, $params)[0]['stock'];
	$newStock = $currentStock - 1;

	$sql = "UPDATE vendingassortiment SET stock = ".$newStock." WHERE machine_id = ".$vendingId." AND position = ".$productPosition.";";
	$params = ['iii', &$newStock, &$vendingId, &$productPosition];

	PostToDatabase($sql, $params);

?>
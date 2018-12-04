<?php
    include("../functions.php");

	$vendingId = $_POST['vendingId'];
	$productPosition = $_POST['productPosition'];

	$sql = "SELECT stock FROM vendingassortiment WHERE machine_id = ".$vendingId." AND position = ".$productPosition.";";

	$currentStock = connectWithDatabase($sql)[0]['stock'];

	$newStock = $currentStock - 1;

	$sql = "UPDATE vendingassortiment SET stock = ".$newStock." WHERE machine_id = ".$vendingId." AND position = ".$productPosition.";";

	connectWithDatabase($sql);

?>
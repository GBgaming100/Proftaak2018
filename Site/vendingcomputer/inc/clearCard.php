<?php
    include("../functions.php");
    $userId = $_POST['userId'];
	$vendingId = $_POST['vendingId'];
	$productPosition = $_POST['productPosition'];	

	$sql = "DELETE FROM myCard WHERE product_id = (SELECT product_id FROM vendingassortiment WHERE position = ".$productPosition." AND machine_id = ".$vendingId.") AND user_id = '". $userId ."';";
	echo $sql;

?>
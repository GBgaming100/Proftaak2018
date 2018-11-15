<?php
    include("../functions.php");

	$value = $_POST['productId'];

	$sql = "DELETE FROM myCard WHERE product_id = '". $value ."';";

	connectWithDatabase($sql);

?>
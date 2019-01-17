<?php
    include("../functions.php");

    $userId = 5;

    if (isset($_POST['userId'])) {
    	$userId = $_POST['userId'];
    }

	$sql = "SELECT p.img, p.name, t.price, t.date FROM transactions t JOIN products p ON t.product_id = p.id WHERE t.user_id = ? ORDER BY t.date DESC;";

    $params = [ "i", &$userId];

	echo json_encode(GetFromDatabase($sql, $params));

?>
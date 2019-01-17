<?php

include("../functions.php");

$id = $_POST['id'];
$position = $_POST['position'];
$product = $_POST['product'];
$stock = $_POST['stock'];


$sql = "UPDATE vendingassortiment SET product_id = ?, position = ?, stock = ? WHERE id = ?;";
$params = ['iiii', &$product, &$position, &$stock, &$id];

PostToDatabase($sql, $params);

<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM vendingassortiment WHERE id = ?;";
$params = ['i', &$id];

PostToDatabase($sql, $params);

$product = $_POST['product'];
$vending = $_POST['vending'];

$sql = "DELETE FROM `mycard` WHERE product_id = ? AND vending_id= ?;";
$params = ['i', &$product, &$vending];

PostToDatabase($sql, $params);
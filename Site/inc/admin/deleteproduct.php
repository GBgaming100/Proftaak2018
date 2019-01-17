<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM products WHERE id = ?;";
$params = ['i', &$id];

PostToDatabase($sql, $params);

$sql = "DELETE FROM `mycard` WHERE product_id = ?;";
$params = ['i', &$id];

PostToDatabase($sql, $params);
<?php

include("../functions.php");
$machine = $_POST['machineId'];
$position = $_POST['position'];
$product = $_POST['product'];
$stock = $_POST['stock'];

$sql = "INSERT INTO vendingassortiment (product_id, position, stock, machine_id)VALUES (?, ?, ?, ?);";
$params = ['iiii', &$product, &$position, &$stock, &$machine];

PostToDatabase($sql, $params);

<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM vendingassortiment WHERE id = ".$id.";";

connectWithDatabase($sql);

$product = $_POST['product'];
$vending = $_POST['vending'];

$sql = "DELETE FROM `mycard` WHERE product_id = ".$product." AND vending_id= ".$vending.";";

connectWithDatabase($sql);
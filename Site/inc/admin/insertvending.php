<?php

include("../functions.php");
$machine = $_POST['machineId'];
$position = $_POST['position'];
$product = $_POST['product'];
$stock = $_POST['stock'];

$sql = "INSERT INTO vendingassortiment (product_id, position, stock, machine_id)VALUES (".$product.", ".$position.", ".$stock.", ".$machine.");";

connectWithDatabase($sql);

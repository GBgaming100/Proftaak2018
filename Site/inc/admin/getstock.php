<?php

include("../functions.php");

$id = 1;

if (isset($_POST['id'])) {
	$id = $_POST['id'];
}


$sql = "SELECT m.id, m.name as vending_name, a.id as vendingassortiment_id, a.position, a.stock, p.id as product_id, p.name as product_name FROM `vendingassortiment` a JOIN vendingmachines m ON a.`machine_id` = m.id JOIN products p ON a.product_id = p.id WHERE m.id = ".$id;

$machines = connectWithDatabase($sql);

foreach ($machines as $key => $machine) {

	$sql = "SELECT id, name FROM products WHERE NOT id = ".$machine['product_id'];
	$machines[$key]["product_other"] = connectWithDatabase($sql);
}

echo json_encode($machines);
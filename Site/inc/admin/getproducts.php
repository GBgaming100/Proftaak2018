<?php

include("../functions.php");

$sql = "SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON c.id = p.cat_id";

$categories = connectWithDatabase($sql);

foreach ($categories as $key => $categorie) {

	$sql = "SELECT * FROM `categories` WHERE NOT id = ".$categorie['cat_id'];
	$categories[$key]["category_other"] = connectWithDatabase($sql);
}

echo json_encode($categories);

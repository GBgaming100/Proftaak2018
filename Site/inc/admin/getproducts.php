<?php

include("../functions.php");

$sql = "SELECT p.*, c.name as cat_name FROM products p JOIN categories c ON c.id = p.cat_id WHERE ?";
$one = 1;
$params = ['i', &$one];

$categories = GetFromDatabase($sql, $params);

foreach ($categories as $key => $categorie) {

	$sql = "SELECT * FROM `categories` WHERE NOT id = ?;";
	$params = ['i', &$categorie['cat_id']];

	$categories[$key]["category_other"] = GetFromDatabase($sql, $params);
}

echo json_encode($categories);

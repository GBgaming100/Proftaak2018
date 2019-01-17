<?php

include("../functions.php");

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$img = $_POST['img'];
$cat = $_POST['cat'];
$background = $_POST['color'];


$sql = "UPDATE products SET name = ?, price = ?, img = ?, cat_id = ?, background = ? WHERE id = ?;";
$params = ['sssssi', &$name, &$price, &$img, &$cat, &$background, &$id];

PostToDatabase($sql, $params);

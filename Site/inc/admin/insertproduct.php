<?php

include("../functions.php");

$name = $_POST['name'];
$price = $_POST['price'];
$img = $_POST['img'];
$cat = $_POST['cat'];
$background = $_POST['color'];

$sql = "INSERT INTO products (name, price, img, cat_id, background)VALUES ('".$name."', ".$price.", '".$img."', '".$cat."', '".$background."');";
$params = ['sssss', &$name, &$price, &$img, &$cat, &$background];

PostToDatabase($sql, $params);

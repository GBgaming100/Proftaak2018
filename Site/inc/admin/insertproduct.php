<?php

include("../functions.php");

$name = $_POST['name'];
$price = $_POST['price'];
$img = $_POST['img'];
$background = $_POST['color'];

$sql = "INSERT INTO products (name, price, img, background)VALUES ('".$name."', ".$price.", '".$img."', '".$background."');";

echo $sql;

connectWithDatabase($sql);

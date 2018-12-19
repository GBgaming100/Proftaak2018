<?php

include("../functions.php");

$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$img = $_POST['img'];
$background = $_POST['color'];


$sql = "UPDATE products SET name = '".$name."', price = '".$price."', img = '".$img."', background = '".$background."' WHERE id = ".$id.";";

echo $sql;

connectWithDatabase($sql);

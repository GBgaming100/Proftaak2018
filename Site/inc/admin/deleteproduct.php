<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM products WHERE id = ".$id.";";

connectWithDatabase($sql);

$sql = "DELETE FROM `mycard` WHERE product_id = ".$id.";";

connectWithDatabase($sql);
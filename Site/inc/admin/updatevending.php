<?php

include("../functions.php");

$id = $_POST['id'];
$position = $_POST['position'];
$product = $_POST['product'];
$stock = $_POST['stock'];


$sql = "UPDATE vendingassortiment SET product_id = ".$product.", position = ".$position.", stock = ".$stock." WHERE id = ".$id.";";

connectWithDatabase($sql);

<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM products WHERE id = ".$id.";";

echo $sql;

connectWithDatabase($sql);

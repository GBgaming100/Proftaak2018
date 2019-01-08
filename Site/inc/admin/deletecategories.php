<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM categories WHERE id = ".$id.";";

connectWithDatabase($sql);

$sql = "UPDATE products SET cat_id = 0 WHERE cat_id = ".$id.";";

connectWithDatabase($sql);

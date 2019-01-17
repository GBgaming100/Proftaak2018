<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM categories WHERE id = ?;";
$params = ['i', &$id];

PostToDatabase($sql, $params);

$sql = "UPDATE products SET cat_id = 0 WHERE cat_id = ?;";
$params = ['i', &$id];

PostToDatabase($sql, $params);

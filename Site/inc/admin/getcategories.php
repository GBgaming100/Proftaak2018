<?php

include("../functions.php");

$sql = "SELECT * FROM categories WHERE ?;";
$one = 1;
$params = ['i', &$one];

echo json_encode(GetFromDatabase($sql, $params));

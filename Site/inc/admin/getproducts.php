<?php

include("../functions.php");

$sql = "SELECT * FROM products";

$products = connectWithDatabase($sql);

echo json_encode($products);

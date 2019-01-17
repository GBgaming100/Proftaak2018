<?php

include("../functions.php");

$name = $_POST['name'];

$sql = "INSERT INTO categories (name)VALUES (?);";
$params = ['s', &$name];

PostToDatabase($sql, $params);

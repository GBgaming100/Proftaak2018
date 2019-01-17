<?php

include("../functions.php");

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "UPDATE categories SET name = ? WHERE id = ?;";
$params = ['si', &$name, &$id];

PostToDatabase($sql, $params);

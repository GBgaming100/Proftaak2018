<?php

include("../functions.php");

$id = $_POST['id'];
$name = $_POST['name'];

$sql = "UPDATE categories SET name = '".$name."' WHERE id = ".$id.";";

connectWithDatabase($sql);

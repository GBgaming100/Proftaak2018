<?php

include("../functions.php");

$name = $_POST['name'];

$sql = "INSERT INTO categories (name)VALUES ('".$name."');";

echo $sql;

connectWithDatabase($sql);

<?php

include("../functions.php");
$id = $_POST['id'];

$sql = "DELETE FROM vendingassortiment WHERE id = ".$id.";";

connectWithDatabase($sql);

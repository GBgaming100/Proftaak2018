<?php

include("../functions.php");

$sql = "SELECT * FROM categories";

echo json_encode(connectWithDatabase($sql));

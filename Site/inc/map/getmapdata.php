<?php

include("../functions.php");

$sql = "SELECT * FROM vendingmachines";

$machines = connectWithDatabase($sql);

echo json_encode($machines);
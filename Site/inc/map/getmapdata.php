<?php

include("../functions.php");

$sql = "SELECT * FROM vendingmachines WHERE ?";
$one = 1;
$params = ['i', &$one];

$machines = GetFromDatabase($sql, $params);

echo json_encode($machines);
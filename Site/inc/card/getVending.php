<?php
    include("../functions.php");

    	$sql = "SELECT * FROM `vendingmachines` WHERE id in (SELECT vending_id FROM mycard where user_id = ?)";
        $params = ['i', &$_SESSION['id']];

    	$vendingmachines = GetFromDatabase($sql, $params);

        foreach ($vendingmachines as $key => $machine) {
            
        $sql = "SELECT product_id FROM mycard WHERE user_id = ? AND vending_id = ?;";
        $params = ['ii', &$_SESSION['id'], &$machine['id']];

        $ids = GetFromDatabase($sql, $params);

        $idArray = [];

        foreach ($ids as $id) 
        {
            array_push($idArray, $id['product_id']);
        }

        $sql = "SELECT * FROM products WHERE ? AND id in(". implode(", ",$idArray) .")";
        $one = 1;
        $params = ['i', &$one];

        $cardItems = GetFromDatabase($sql, $params);

        $vendingmachines[$key]['card'] = $cardItems;

        }

		echo json_encode($vendingmachines);

?>
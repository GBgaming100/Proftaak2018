<?php
    include("../functions.php");

    	$sql = "SELECT * FROM `vendingmachines` WHERE id in (SELECT vending_id FROM mycard where user_id = ?);";
        $params = ['i', &$_SESSION['id']];

    	$vendingmachines = GetFromDatabase($sql, $params);

        foreach ($vendingmachines as $key => $machine) {
            
        $sql = "SELECT product_id FROM mycard WHERE user_id = ? AND vending_id = ?;";
        $params = ['ii', &$_SESSION['id'], &$machine['id']];

        $ids = GetFromDatabase($sql, $params);

        $cardItems = [];

        foreach ($ids as $id) 
        {

            $sql = "SELECT c.id as id, p.name as name, p.price as price, p.img as img FROM products p JOIN mycard c ON p.id = c.product_id WHERE p.id = ? AND c.user_id = ?;";
            $params = ['ii', &$id['product_id'], &$_SESSION['id']];

            array_push($cardItems, GetFromDatabase($sql, $params)[0]);
        }

        $vendingmachines[$key]['card'] = $cardItems;

        }

		echo json_encode($vendingmachines);

?>
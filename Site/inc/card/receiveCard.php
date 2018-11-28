<?php
    include("../functions.php");
        $user_id = $_POST['userId'];

    	$sql = "SELECT * FROM `vendingmachines` WHERE id in (SELECT vending_id FROM mycard where user_id = ".$user_id.")";

    	$vendingmachines = connectWithDatabase($sql);

        foreach ($vendingmachines as $key => $machine) {
            
        $sql = "SELECT product_id FROM myCard WHERE user_id = ".$user_id." AND vending_id = ". $machine['id'];

        $ids = connectWithDatabase($sql);

        $idArray = [];

        foreach ($ids as $id) 
        {
            array_push($idArray, $id['product_id']);
        }

        $sql = "SELECT * FROM products WHERE id in(". implode(", ",$idArray) .")";

        $cardItems = connectWithDatabase($sql);

        $vendingmachines[$key]['card'] = $cardItems;

        }

		echo json_encode($vendingmachines);

?>
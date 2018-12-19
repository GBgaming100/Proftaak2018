<?php
    include("../functions.php");
        $user_id = $_POST['userId'];

    	$sql = "SELECT * FROM `vendingmachines` WHERE id in (SELECT vending_id FROM mycard where user_id = ".$user_id.")";

    	$vendingmachines = connectWithDatabase($sql);

        foreach ($vendingmachines as $key => $machine) {
            
        $sql = "SELECT product_id FROM myCard WHERE user_id = ".$user_id." AND vending_id = ". $machine['id'];

        $ids = connectWithDatabase($sql);

        $cardItems = [];

        foreach ($ids as $id) 
        {

            $sql = "SELECT c.id as id, p.name as name, p.price as price, p.img as img FROM products p JOIN mycard c ON p.id = c.product_id WHERE p.id = ". $id['product_id'];

            array_push($cardItems, connectWithDatabase($sql)[0]);
        }

        $vendingmachines[$key]['card'] = $cardItems;

        }

		echo json_encode($vendingmachines);

?>
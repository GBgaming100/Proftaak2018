<?php
    include("../functions.php");

        $id = 1;
        if (isset($_POST['machine'])) {
            $id = $_POST['machine'];
        }

    	$sql = "SELECT * FROM `vendingmachines` v JOIN vendingassortiment a ON v.id = a.machine_id WHERE a.machine_id = ". $id ." AND a.product_id IN (SELECT product_id FROM mycard WHERE vending_id = ".$id.")";

    	$position = connectWithDatabase($sql);

		echo json_encode($position);

?>
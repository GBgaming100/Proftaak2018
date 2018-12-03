<?php
    include("../functions.php");

    	$user_id = $_SESSION["id"];
        $id = 1;
        if (isset($_POST['machine'])) {
            $id = $_POST['machine'];
        }

    	$sql = "SELECT position FROM `vendingassortiment` WHERE machine_id = ". $id ." AND product_id IN (SELECT product_id FROM `mycard` WHERE user_id = ". $user_id ." AND vending_id = ". $id .")";

    	$position = connectWithDatabase($sql);



		echo json_encode(array("positions" => $position, "user" => $user_id));

?>
<?php
    include("../functions.php");

    	$user_id = $_SESSION["id"];
        $id = 2;
        if (isset($_POST['machine'])) {
            $id = $_POST['machine'];
        }

    	$sql = "SELECT v.position FROM mycard c JOIN vendingassortiment v ON c.product_id = v.product_id WHERE c.user_id = ".$user_id." AND c.vending_id = ".$id."";

    	$position = connectWithDatabase($sql);



		echo json_encode(array("positions" => $position, "user" => $user_id));

?>
<?php
    include("../functions.php");

    	$user_id = $_SESSION["id"];
        $id = 1;
        if (isset($_POST['machine'])) {
            $id = $_POST['machine'];
        }

    	$sql = "SELECT v.position FROM mycard c JOIN vendingassortiment v ON c.product_id = v.product_id WHERE c.user_id = ? AND c.vending_id = ?;";
    	$params = ['ii', &$user_id, &$id];

    	$position = GetFromDatabase($sql, $params);



		echo json_encode(array("positions" => $position, "user" => $user_id));

?>
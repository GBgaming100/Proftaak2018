<?php
    include("../functions.php");
        $id = 1;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        $search = "";
        if (isset($_POST['search'])) {
            $search = $_POST['search'];
        }

        $filter = "";
        if (isset($_POST['filter'])) {
            $filter = $_POST['filter'];
        }

        if (isset($_POST['categories'])) {
            $catogories = $_POST['categories'];
        }
        else
        {
            $sql = "SELECT id FROM `categories` WHERE `id` in (SELECT cat_id FROM products WHERE id in (SELECT product_id FROM vendingassortiment WHERE machine_id = ?))";
            $params = ['i', &$id];

            $catogories = GetFromDatabase($sql, $params);

            $i = array();

            foreach ($catogories as $cat) {
                array_push($i, $cat['id']);
            }

            $catogories = $i;
        }

        // var_dump($catogories);


    	$sql = "SELECT p.* , v.stock, v.machine_id FROM products AS p JOIN vendingassortiment AS v ON p.id = v.product_id WHERE p.cat_id IN (".implode(", ", $catogories).") AND p.name LIKE ? AND v.machine_id = ? ".$filter.";";
        $search_string = '%'.$search."%";
        $params = ['si', &$search_string, &$id];

    	$products = GetFromDatabase($sql, $params);

		echo json_encode($products);

?>
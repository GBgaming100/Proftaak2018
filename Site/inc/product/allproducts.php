<?php
    include("../functions.php");

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
            $sql = "SELECT id FROM categories WHERE ?";

            $one = 1;
            $params = ['i', &$one];

            $catogories = GetFromDatabase($sql, $params);

            $i = array();

            foreach ($catogories as $cat) {
                array_push($i, $cat['id']);
            }

            $catogories = $i;
        }

    	$sql = "SELECT p.* FROM products as p WHERE p.cat_id IN (".implode(", ", $catogories).") AND p.name LIKE ? ".$filter.";";
        $search_string = '%'. $search . '%';

        $params = [ "s", &$search_string];

    	$products = GetFromDatabase($sql, $params);
		echo json_encode($products);

?>
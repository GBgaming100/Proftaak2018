<?php
    include("../functions.php");


        $data = [];

        if (isset($_POST['id'])) {

            $id = $_POST['id'];

        	$sql = "SELECT * FROM `categories` WHERE `id` in (SELECT cat_id FROM products WHERE id in (SELECT product_id FROM vendingassortiment WHERE machine_id = ?));";
            $params = ['i', &$id];

            $cats = GetFromDatabase($sql, $params);

            foreach ($cats as $key => $cat) {
                $sql = "SELECT count(cat_id) as total FROM products WHERE cat_id = ? AND id IN (SELECT product_id FROM vendingassortiment WHERE machine_id = ?);"; 
                $params = ['ii', &$cat['id'], &$id];

                $cats[$key]['total'] = GetFromDatabase($sql, $params)[0]['total'];
            }

            $sql = "SELECT * FROM filters WHERE ?";
            $one = 1;
            $params = ['i', &$one];

            $filters = GetFromDatabase($sql, $params);

            $extras = $arrayName = array('categories' => $cats, 'filters' => $filters);

    		echo json_encode($extras);
        }
        else
        {
            $sql = "SELECT * FROM categories WHERE ?";
            $one = 1;
            $params = ['i', &$one];

            $cats = GetFromDatabase($sql, $params);

            foreach ($cats as $key => $cat) {
                $sql = "SELECT count(cat_id) as total FROM products WHERE cat_id = ?;"; 
                $params = ['i', &$cat['id']];

                $cats[$key]['total'] = GetFromDatabase($sql, $params)[0]['total'];
            }

            $sql = "SELECT * FROM filters WHERE ?";
            $params = ['i', &$one];

            $filters = GetFromDatabase($sql, $params);

            $extras = $arrayName = array('categories' => $cats, 'filters' => $filters);

            echo json_encode($extras);
        }

?>
<?php
    include("../functions.php");


        $data = [];

        if (isset($_POST['id'])) {

            $id = $_POST['id'];

        	$sql = "SELECT * FROM `categories` WHERE `id` in (SELECT cat_id FROM products WHERE id in (SELECT product_id FROM vendingassortiment WHERE machine_id = ".$id."))";

        	$cats = connectWithDatabase($sql);

            foreach ($cats as $key => $cat) {
                $sql = "SELECT count(cat_id) as total FROM products WHERE cat_id = ".$cat['id']." AND id IN (SELECT product_id FROM vendingassortiment WHERE machine_id = ".$id.")"; 

                $cats[$key]['total'] = connectWithDatabase($sql)[0]['total'];
            }

            $sql = "SELECT * FROM filters";

            $filters = connectWithDatabase($sql);

            $extras = $arrayName = array('categories' => $cats, 'filters' => $filters);

    		echo json_encode($extras);
        }
        else
        {
            $sql = "SELECT * FROM `categories`";

            $cats = connectWithDatabase($sql);

            foreach ($cats as $key => $cat) {
                $sql = "SELECT count(cat_id) as total FROM products WHERE cat_id = ".$cat['id']; 

                $cats[$key]['total'] = connectWithDatabase($sql)[0]['total'];
            }

            $sql = "SELECT * FROM filters";

            $filters = connectWithDatabase($sql);

            $extras = $arrayName = array('categories' => $cats, 'filters' => $filters);

            echo json_encode($extras);
        }

?>
<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();

$db = $database->connect();

$cat = new Category($db);

$res = $cat->read();

$num = $res->rowCount();

if ($num > 0) {

    $cats_arr = array();
    $cats_arr['data'] = array();
    while ($row = $res->fetch(PDO::FETCH_ASSOC) ) 
    {

        extract($row);
        $cat_item = array(

            'id' => $id,
            'name' => $name,
            
        );

        array_push($cats_arr['data'], $cat_item);
    }

    echo json_encode($cats_arr);
} else {

}

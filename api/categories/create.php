<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');




include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();

$db = $database->connect();

$cat = new Category($db);


$data=json_decode(file_get_contents("php://input"));

if(!isset($data->name)){
    http_response_code(206);
    echo 'name is required ';
    die(203);
}

$cat->name=$data->name;


if($cat->create()){
    // http_response_code(201);
    echo json_encode(array('message'=>'category created'),201);
}
else{
    echo json_encode(array('message'=>'category not created'),401);

}
<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');




include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();

$db = $database->connect();

$cat = new Category($db);


$cat->createTable();
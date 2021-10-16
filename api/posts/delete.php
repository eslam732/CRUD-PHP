<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:DELETE');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();

$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->id)) {
    http_response_code(206);
    echo 'id is required ';
    die(203);
}

$post->id = $data->id;


if ($post->delete()) {
     http_response_code(201);
    echo json_encode(array('message' => 'post deleted'), 201);
} else {
    echo json_encode(array('message' => 'post not deleted'), 401);

}

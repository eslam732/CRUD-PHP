<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods:POST');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

$database = new Database();

$db = $database->connect();

$post = new Post($db);

$data = json_decode(file_get_contents("php://input"));

if (!isset($data->title) || !isset($data->body)
 || !isset($data->author) || !isset($data->category_id) || !isset($data->id)) {
    http_response_code(206);
    echo 'title , body ,author and category_id ,id are required ';
    die(203);
}

$post->id = $data->id;
$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

if ($post->update()) {
     http_response_code(201);
    echo json_encode(array('message' => 'post updated'), 201);
} else {
    echo json_encode(array('message' => 'post not updated'), 401);

}

<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Posts.php';

// Instantiate Database object and connect
$database = new Database();
$db = $database->connect();

// Instantiate post object
$post = new Post($db);

// Get id from url
$post->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get post
$post->read_single();

// Create array
$post_arr = array(
   "id" => $post->id,
   "title" => $post->title,
   "body" => html_entity_decode($post->body),
   "author" => $post->author,
   "category_id" => $post->category_id,
   "category_name" => $post->category_name
);

// make json
// print_r(json_encode($post_arr));
echo json_encode($post_arr);
?>
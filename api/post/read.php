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

// Blog post query
$result = $post->read();

// Get row count
$num = $result->rowCount();

// Check for posts 
if($num > 0) {

   // Post Array
   $post_arr = array();
   $post_arr['data'] = array();

   while($row = $result->fetch(PDO::FETCH_ASSOC)) {

      extract($row);
      $post_item = array(
         "id" => $id,
         "title" => $title,
         "body" => html_entity_decode($body),
         "author" => $author,
         "category_id" => $category_id,
         "category_name" => $category_name
      );
      // Push to data
      array_push($post_arr['data'],$post_item);
   }
   echo json_encode($post_arr);

   
}else {
   echo json_encode(array(
      "message" => "No post found"
   ));
}

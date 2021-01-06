<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Categories.php';

// Instantiate Database object and connect
$database = new Database();
$db = $database->connect();

// Instantiate post object
$category = new Category($db);

// get the id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();


// Blog post query
$result = $category->getboth();
$num = $result->rowCount();
$post_arr = array();
$post_arr['data'] = array();

if($num>0){
   while($row = $result->fetch(PDO::FETCH_ASSOC)){
   
      extract($row);
      $post_item = array(
         "id" => $post_id,
         "title" => $post_title,
         "body" => html_entity_decode($post_body),
         "author" => $post_author,
         "category_id" => $category_id,
         "category_name" => $name
      );
   
      array_push($post_arr['data'],$post_item);
   }
   
   
   echo json_encode($post_arr);
} else {
   echo json_encode(
      array("message" => "No post found")
   );
}


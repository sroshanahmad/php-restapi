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

// Blog post query
$result = $category->read();

// Get row count
$num = $result->rowCount();

// Check for posts 
if($num > 0) {

   // Post Array
   $cat_arr = array();
   $cat_arr['data'] = array();

   while($row = $result->fetch(PDO::FETCH_ASSOC)) {

      extract($row);
      $cat_item = array(
         "id" => $id,
         "name" => $name
      );
      // Push to data
      array_push($cat_arr['data'],$cat_item);
   }
   echo json_encode($cat_arr);

   
}else {
   echo json_encode(array(
      "message" => "No post found"
   ));
}

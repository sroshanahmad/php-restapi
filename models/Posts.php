<?php

class Post{

   private $conn;
   private $table = 'posts';

   // Properties
   public $id;
   public $category_id;
   public $category_name;
   public $title;
   public $body;
   public $author;
   public $created_at;

   // Contructor with DB
   public function __construct($db){
      $this->conn = $db;
   }

   // 1Get Posts
   public function read() {
      $query = 'SELECT 
               c.name as category_name,
               p.id,
               p.category_id,
               p.title,
               p.body,
               p.author,
               p.created_at
               FROM
               ' .$this->table.' p
               LEFT JOIN
               categories c
               ON p.category_id=c.id
               ORDER BY 
               p.created_at DESC';
      
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
   }
   // 2 Get single Post
   public function read_single() {
      $query = '
      SELECT 
      c.name as category_name,
      p.id,
      p.category_id,
      p.title,
      p.body,
      p.author,
      p.created_at
      FROM '.$this->table.' p
      LEFT JOIN
      categories c ON p.category_id=c.id
      WHERE p.id = ?
      LIMIT 0,1
      ';

      $stmt = $this->conn->prepare($query);
      // $stmt->bindParam(1,$this->id);
      // $stmt->execute();
      $stmt->execute([$this->id]);
      
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // set properties
      extract($row);
      $this->title = $title;
      $this->body = $body;
      $this->author = $author;
      $this->category_id = $category_id;
      $this->category_name = $category_name;
      
   }

   // 3 Create post
   public function create() {
      $query = '
      INSERT INTO
      '.$this->table.'
      SET
      title = ?,
      body = ?,
      author= ?,
      category_id = ?
      ';
      $stmt = $this->conn->prepare($query);

      // clean data
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->body = htmlspecialchars(strip_tags($this->body));
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      // execute data
      if($stmt->execute([$this->title,$this->body,$this->author,$this->category_id])){
         return true;
      }else{
         printf("Error: %s.\n",$stmt->error);
         return false;
      }
   }
   
    // Update Post
    public function update() {
      // Create query
      $query = 'UPDATE ' . $this->table . '
      SET title = ?, body = ?, author = ?, category_id = ?
      WHERE id = ?';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->body = htmlspecialchars(strip_tags($this->body));
      $this->author = htmlspecialchars(strip_tags($this->author));
      $this->category_id = htmlspecialchars(strip_tags($this->category_id));
      $this->id = htmlspecialchars(strip_tags($this->id));

     

      // Execute query
      if($stmt->execute([$this->title, $this->body, $this->author, $this->category_id, $this->id])) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
}

 // Delete Post
 public function delete() {
   // Create query
   $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

   // Prepare statement
   $stmt = $this->conn->prepare($query);

   // Clean data
   $this->id = htmlspecialchars(strip_tags($this->id));

   // Bind data
   $stmt->bindParam(':id', $this->id);

   // Execute query
   if($stmt->execute()) {
     return true;
   }

   // Print error if something goes wrong
   printf("Error: %s.\n", $stmt->error);

   return false;
}

}
?>
<?php

class Database{
   
   private $host = 'l0ebsc9jituxzmts.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
   private $dbname = 'n1aaxi664lc4vc64';
   private $username= 'd0tdf95q8v53y1bk';
   private $password= 'lj2izv6mkcej8sze';
   private $conn;

   public function connect() {

      $this->conn = null;
      try{
         $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
         $this->conn = new PDO($dsn,$this->username,$this->password);
         $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      }
      catch(PDOException $e) {
         echo 'Connection Error: ' . $e->getMessage();
      }
      return $this->conn; 
   }
}

?>
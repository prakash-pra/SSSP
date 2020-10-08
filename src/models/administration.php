<?php
class Administrator{
  
  // database connection and table name
  private $conn;
  private $table_name = "administrator";

  // object properties
  public $username;
  public $password;
  
  // constructor with $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }

function check_login(){

  $query = "SELECT * FROM administrator WHERE userName=:username AND password=:password";

  $stmt =  $this->conn->prepare($query);
  $stmt->bindParam(":userName", $this->password);
  $stmt->bindParam(":password", $this->password);

  if($stmt->execute()){
    $data = $stmt->fetch();
    return $data;
}
  return array(); 
}

}

?>
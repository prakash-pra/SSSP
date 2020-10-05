<?php
class Student{
  
  // database connection and table name
  private $conn;
  private $table_name = "student";

  // object properties
  public $studentID;
  public $firstName;
  public $lastName;
  public $email;
  
  // constructor with $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }

  // read products
public function getStudents(){
  
  // select all query
  $query ="SELECT * FROM student";

  // prepare query statement
  $stmt = $this->conn->prepare($query);

  // execute query
  $stmt->execute();
  return $stmt;
}

// create product
function create(){
  
  // query to insert record
  $query = "INSERT INTO
              " . $this->table_name . "
          SET
              studentID=:studentID, firstName=:firstName, lastName=:lastName, email=:email";

  // prepare query
  $stmt = $this->conn->prepare($query);

  // sanitize
  $this->studentID=htmlspecialchars(strip_tags($this->studentID));
  $this->firstName=htmlspecialchars(strip_tags($this->firstName));
  $this->lastName=htmlspecialchars(strip_tags($this->lastName));
  $this->email=htmlspecialchars(strip_tags($this->email));

  

  // bind values
  $stmt->bindParam(":studentID", $this->studentID);
  $stmt->bindParam(":firstName", $this->firstName);
  $stmt->bindParam(":lastName", $this->lastName);
  $stmt->bindParam(":email", $this->email);


  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;
    
}

}

?>
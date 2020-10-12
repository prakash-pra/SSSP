<?php
class Spreadsheet{
  
  // database connection and table name
  private $conn;
  private $table_name = "spreadsheet";
  public $courseName;
  public $program;
  public $campus;
  public $credit;
  public $stream;
  public $tutor;
  public $monday;
  public $tuesday;
  public $wednesday;
  public $thrusday;
  public $friday;

  // constructor with $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }


public function getStudents(){
  
  // select all query
  $query ="SELECT * FROM spreadsheet"; 

  // prepare query statement
  $stmt = $this->conn->prepare($query);

  // execute query
  $stmt->execute();
  return $stmt;
}
}
?>
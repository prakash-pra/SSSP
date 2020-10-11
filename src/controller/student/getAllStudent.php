<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
include_once '../../models/student.php';
  
$database = new Database();
$db = $database->getConnection();
  
$student = new Student($db);

$students = $student->getStudents();

$allStudents = $students->rowCount();

if($allStudents>0){

  $students_arr['records'] = array();

  while($row = $students->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $student_list=array(
      "studentId" => $studentId,
      "firstName" => $firstName,
      "lastName" => $lastName,
      "email" => $email, 
  );
  array_push($students_arr["records"], $student_list);
  }
  http_response_code(200);
  echo json_encode(array('status' => 'success','message'=> 'Successfully get all students record',"students"=>$students_arr));
}
else {
  http_response_code(404);
  echo json_encode(array('status' => 'success','message'=> 'No student found'));
}

?>
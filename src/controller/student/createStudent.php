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
  
// get posted data
$data = json_decode(file_get_contents("php://input"));
//  echo json_encode(array("message" => "Unable to register User. Data is incomplete.", "data"=>$data));

// make sure data is not empty
if(!empty($data->studentId)&&
!empty($data->firstName)&&
!empty($data->studentId)&&
!empty($data->lastName)&&
!empty($data->email)){
    // set student property values
    $student->studentID = $data->studentId;
    $student->firstName = $data->firstName;
    $student->lastName = $data->lastName;
    $student->email = $data->email;
    // create the student
    if($student->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "student was registered."));
    }
  
    // if unable to create the student, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create user."));
    }
}
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to register User. Data is incomplete."));
}
?>
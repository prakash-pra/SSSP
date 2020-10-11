<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
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
if(!empty($data->studentId)){
    // set student property values
    $student->studentID = $data->studentId;
        
        if($student->remove_student()){
  
            // set response code - 200 created
            http_response_code(200);
      
            // tell the user
            echo json_encode(array("status" => 1,
                                  "message" => "Student successfully removed."));
        } else {
          // set response code - 400 bad request
          http_response_code(404);
  
          // tell the user
          echo json_encode(array("status" => 0,
                              "message" => "Unable to remove the student. Please try again."));
        }
}
else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("status" => 0,
                        "message" => "Unable to remove the student. Please try again."));
}
?>
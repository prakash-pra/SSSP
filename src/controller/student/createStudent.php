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
if(!empty($data->studentId) &&
!empty($data->firstName) &&
!empty($data->lastName) &&
!empty($data->email)&&
!empty($data->contact)){
    echo "success";
}
 else{
    echo "failed";
}
// make sure data is not empty
/*if(isset($data)&& !empty($data)){
  
    $request = json_decode($data,true);

    print_r("some data:"+$request);
    // set product property values
    $student->studentID = $request->studentId;
    $student->firstName = $request->firstName;
    $student->lastName = $request->lastName;
    $student->email = $request->email;
    $student->contact = $request->contact;
  
    // create the product
    if($student->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "student was registered."));
    }
  
    // if unable to create the product, tell the user
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
    echo json_encode(array("message" => "Unable to register User. Data is incomplete.", "data"=>$data));
    return $data;
}*/
?>
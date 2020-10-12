<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
include_once '../../models/spreadsheet.php';
  
$database = new Database();
$db = $database->getConnection();
  
$spreadsheet = new Spreadsheet($db);

$spreadsheetData = $spreadsheet->getStudents();

$allData = $spreadsheetData->rowCount();

if($allData>0){

  $spreadsheet_data['records'] = array();

  while($row = $spreadsheetData->fetch(PDO::FETCH_ASSOC)) {

    extract($row);
    $all_spreadsheet_data=array(
     "courseName"=>$course_name,
      "program"=>$program,
      "campus"=>$campus,
      "credit" =>$credits,
      "stream" =>$number_streams,
      "tutor" =>$tutor,
      "monday"=> $monday,
      "tuesday" =>$tuesday,
      "wednesday" =>$wednesday,
      "thursday" =>$thursday,
      "friday" =>$friday, 
  );
  array_push($spreadsheet_data["records"], $all_spreadsheet_data);
  }
  http_response_code(200);
  echo json_encode(array('status' => 1,
  'message'=> 'Successfully get all spreadsheet record',"students"=>$spreadsheet_data));
}
else {
  http_response_code(404);
  echo json_encode(array('status' => 'success','message'=> 'No student found'));
}
?>
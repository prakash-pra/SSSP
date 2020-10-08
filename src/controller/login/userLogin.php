
<?php 

require '../../../vendor/autoload.php';
use \Firebase\JWT\JWT;

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
  
if($_SERVER['REQUEST_METHOD'] === 'POST'){
// get posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data->studentId)&&
!empty($data->email)){

  $student->studentID = $data->studentId;
  $student->email = $data->email;

  $user_data = $student->check_login();
  
  if(!empty($user_data)){
    $studentId = $user_data['studentID'];
    $email = $user_data['email'];

    if($studentId == $data->studentId && $email == $data->email ){

      $iss = 'localhost';
      $iat = time();
      $nbf = $iat + 10;
      $exp = $iat + 60;
      $aud = 'myuser';
      $user_arr_data = array(
        "studentId"=> $user_data['studentID'],
          "email"=>$user_data['email'],
      );
      
      $secret_key = "student@streaming!service$";

      $payload_info = array(
        "iss"=>$iss,
        "iat"=>$iat,
        "nbf"=> $nbf,
        "exp"=>$exp ,
        "aud"=>$aud,
        "data"=>$user_arr_data
      );

      $jwt = JWT::encode($payload_info, $secret_key,'HS512');

      http_response_code(200);
      echo json_encode(array("status"=>1, 
      "message" => "user successfully login.",
      "jwt" => $jwt
    ));
    } else {
      http_response_code(404);
      echo json_encode(array("status"=>0, 
      "message" => "Invalid login credentials."));
    }
  }else{
    http_response_code(404);
    echo json_encode(array("status"=>0, 
    "message" => "Invalid credentials."));
  }

} else {
  http_response_code(404);
  echo json_encode(array("status"=>0, 
  "message" => "Unable to login. Data is incomplete."));
}
}
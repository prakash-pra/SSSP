
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
//$data = json_decode(file_get_contents("php://input"));
$all_header = getallheaders();

$data->jwt = $all_header['Authorization'];

if(!empty($data->jwt)){

  try{
    $secret_key = "student@streaming!service$";

    $decoded_data = JWT::decode($data->jwt, $secret_key,array('HS512'));

    http_response_code(200);
    echo json_encode(array(
    "status"=>1, 
    "message" => "we got jwt token",
    "user_data"=> $decoded_data
  ));

  } catch(Exception $ex){
    http_response_code(500);
    echo json_encode(array(
      "status"=>0, 
      "message" => $ex->getMessage(),
    ));
  }
}
}
?>
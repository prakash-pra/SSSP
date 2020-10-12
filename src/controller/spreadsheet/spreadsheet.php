<?php
require '../../../vendor/autoload.php';
  //include 'connect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// get database connection
include_once '../../config/database.php';
// include_once '../../models/student.php';
  
$database = new Database();
$conn = $database->getConnection();
  
		if($_FILES["spreadsheet"]["name"] != '') {
			$allowed_extension = array('xls', 'csv', 'xlsx');
			$file_array = explode('.', $_FILES["spreadsheet"]["name"]);
			$file_extension = end($file_array);
	
			if(in_array($file_extension, $allowed_extension)) {
				$file_name = '../../moved_files/'.time(). '.' . $file_extension;
				move_uploaded_file($_FILES['spreadsheet']['tmp_name'], $file_name);
				$file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);
				$reader->setReadDataOnly(TRUE); 
				// $reader->setReadEmptyCells(FALSE);
        $spreadsheet = $reader->load($file_name);
				unlink($file_name);
        $data = $spreadsheet->getActiveSheet()->toArray();
        
				foreach($data as $row) {
					print_r($data);
					// get columns
				 	$courseName = isset($row[0]) ? $row[0] : "";
				 	$program = isset($row[1]) ? $row[1] : "";
				 	$campus = isset($row[2]) ? $row[2] : "";
				 	$credits = isset($row[3]) ? $row[3] : "";
				 	$number_streams = isset($row[4]) ? $row[4] : "";
				 	$tutor = isset($row[5]) ? $row[5] : "";
				 	$monday = isset($row[6]) ? $row[6] : "";
				 	$tuesday = isset($row[7]) ? $row[7] : "";
				 	$wednesday = isset($row[8]) ? $row[8] : "";
				 	$thursday = isset($row[9]) ? $row[9] : "";
				 	$friday = isset($row[10]) ? $row[10] : "";

					// insert item
				 	$query = "INSERT INTO spreadsheet (course_name, program, campus, credits, number_streams, tutor, monday,
				 	tuesday, wednesday, thursday, friday) ";
				 	$query .= "VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

				 	$prep = $conn->prepare($query);
				 	$prep->execute(array($courseName, $program, $campus, $credits, $number_streams, 
				 		$tutor, $monday, $tuesday, $wednesday, $thursday, $friday));
        }	
        if($prep) {
          
          // set response code - 200 created
          http_response_code(200);
    
          // tell the user
          echo json_encode(array("status" => 1,
                                "message" => "Data successfully inserted."));
                  }
                  else {
      // set response code - 500 internal server error
        http_response_code(500);

        // tell the user
        echo json_encode(array("status" => 0,
                            "message" => "Failed to insert the data.Try again."));
      }				

			}
			elseif($_FILES["uploadfile"]["name"] != $allowed_extension)
		 	{
		 	 echo 'Only .xls .csv or .xlsx file allowed';
		 	}
		} else {
      echo "Please select the file and try again.";
    }
?>
<?php  
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

DEFINE('HOST', 'localhost');
DEFINE('USER', 'bet4youco_cron');
DEFINE('PASSWORD', 'QhQ90JlHdOPN');
DEFINE('DB', 'bet4youco_data');

$table_name = 'b4y_runners';
$connect = mysqli_connect(HOST, USER, PASSWORD, DB) or die('unable to connect DB');

 $data = json_decode(file_get_contents("php://input"));  
 if(count($data) > 0)  
 {  
      $b4yrating = mysqli_real_escape_string($connect, $data->rating); 
      $btn_name = $data->btnName;  
      if($btn_name == 'Update')  
      {  
           $id = $data->id;  
           $query = "UPDATE '$table_name' SET b4y_rating = '$b4yrating' WHERE id = '$id'";  
           if(mysqli_query($connect, $query))  
           {  
                echo 'Data Updated...';  
           }  
           else  
           {  
                echo 'Error';  
           }  
      }  
 }  
 ?>  
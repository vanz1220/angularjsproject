<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

DEFINE('HOST', 'localhost');
DEFINE('USER', 'root');
DEFINE('PASSWORD', '');
DEFINE('DB', 'horse_rating');

$table_name = 'horse_rate';
$conn = mysqli_connect(HOST, USER, PASSWORD, DB) or die('unable to connect DB');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id = $_GET['id'];

        if($id != ""){
            $query = "DELETE FROM $table_name WHERE id='$id'";
            mysqli_query($conn, $query);
            $response['success'] = true;
            $response['message'] = "Data Has been Deleted";
            echo json_encode($response, 200);
            return;
        }else{
            echo json_encode("please provide data", 500);
            return;
        }
}else{
    echo json_encode("Bad request", 500);
    return;
}
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
    $marketId = $_GET["marketId"];
    $date = $_GET["date"];
    $selectionId = $_GET["selectionId"];
    $rating = $_GET["b4y_rating"];

    $result = mysqli_query($conn, "SELECT * FROM $table_name WHERE selectionId='".$selectionId."'");
    while(mysqli_num_rows($result) == 0){
        if($marketId != "" || $date != "" || $selectionId != "" || $rating != ""){
            $query = "INSERT INTO $table_name (marketId, date, selectionId, rating) VALUES ('$marketId', '$date', '$selectionId', '$rating')";
            mysqli_query($conn, $query);
            $response['success'] = true;
            $response['message'] = "Data Has been Updated";
            echo json_encode($response, 200);
            return;
        }else{
            echo json_encode("please provide data", 500);
            return;
        }
    }
}else{
    echo json_encode("Bad request", 500);
    return;
}
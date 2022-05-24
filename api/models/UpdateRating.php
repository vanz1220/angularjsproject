<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

DEFINE('HOST', 'localhost');
DEFINE('USER', 'bet4youco_cron');
DEFINE('PASSWORD', 'QhQ90JlHdOPN');
DEFINE('DB', 'bet4youco_data');

$table_name = 'b4y_runners';
$conn = mysqli_connect(HOST, USER, PASSWORD, DB) or die('unable to connect DB');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET["id"];
    $marketId = $_GET["marketId"];
    $selectionId = $_GET["selectionId"];
    $rating = $_GET["b4y_rating"];

        if($marketId != "" || $date != "" || $selectionId != "" || $rating != ""){
            $query = "UPDATE $table_name SET b4y_rating='$rating' WHERE selectionId='$selectionId'";
            mysqli_query($conn, $query);
            $response['b4yrate'] = $rating;
            $response['success'] = true;
            $response['message'] = "Data Has been Updated";
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
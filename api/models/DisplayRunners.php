<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

DEFINE('HOST', 'localhost');
DEFINE('USER', 'bet4youco_cron');
DEFINE('PASSWORD', 'QhQ90JlHdOPN');
DEFINE('DB', 'bet4youco_data');

$table_name = 'b4y_runners';
$conn = mysqli_connect(HOST, USER, PASSWORD, DB) or die('unable to connect DB');

$marketid = '';
if (isset($_GET['marketid'])) {
    $marketid= $_GET['marketid'];
    $result = mysqli_query($conn, "SELECT * FROM $table_name WHERE marketId = '".$marketid."'");
}
else{
    $result = mysqli_query($conn, "SELECT * FROM $table_name");
}

    //Check if any ratings
    if(mysqli_num_rows($result) > 0){
        //Ratings array
        $ratings_arr['success'] = true;
        $ratings_arr['ratings'] = array();

                    
        while($row = mysqli_fetch_assoc($result)){
            extract($row);

            $rating_item = array(
                "id" => $row["b4y_id"],
                "marketId" => $row["marketId"],
                "selectionId" => $row["selectionId"],
                "number" => $row["number"],
                "name" => $row["name"],
                "trainer" => $row["trainer"],
                "jockey" => $row["jockey"],
                "age" => $row["age"],
                "weight" => $row["weight"],
                "dslr" => $row["dslr"],
                "odds" => $row["odds"],
                "volume" => $row["volume"],
                "ip_low" => $row["ip_low"],
                "bsp" => $row["bsp"],
                "position" => $row["position"],
                "status" => $row["status"],
                "b4y_rating" => $row["b4y_rating"]
            );
            //Push to "ratings"
            array_push($ratings_arr['ratings'], $rating_item);
        }
        echo json_encode($ratings_arr, 200);

                    
    }else {
        $ratings_arr['success'] = false;
        $ratings_arr['ratings'] = array();
        echo json_encode($ratings_arr, 500);
    }
mysqli_close($conn);
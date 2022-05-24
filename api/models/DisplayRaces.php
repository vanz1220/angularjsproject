<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

DEFINE('HOST', 'localhost');
DEFINE('USER', 'bet4youco_cron');
DEFINE('PASSWORD', 'QhQ90JlHdOPN');
DEFINE('DB', 'bet4youco_data');

$table_name = 'b4y_races';
$conn = mysqli_connect(HOST, USER, PASSWORD, DB) or die('unable to connect DB');

$day = '';
if (isset($_GET['day'])) {
    $day= $_GET['day'];
    $result = mysqli_query($conn, "SELECT * FROM $table_name WHERE date_time >= DATE('".$day."') AND date_time <= DATE('".$day."') + 1 ");
}
else{
    $result = mysqli_query($conn, "SELECT * FROM $table_name");
}

    //Check if any ratings
    if(mysqli_num_rows($result) > 0){
        //Ratings array
        $ratings_arr['success'] = true;
        $ratings_arr['races'] = array();

                    
        while($row = mysqli_fetch_assoc($result)){
            extract($row);

            $rating_item = array(
                "id" => $row["b4y_id"],
                "marketId" => $row["marketId"],
                "date" => $row["date_time"],
                "venue" => $row["venue"]
            );
            //Push to "ratings"
            array_push($ratings_arr['races'], $rating_item);
        }
        echo json_encode($ratings_arr, 200);

                    
    }else {
        $ratings_arr['success'] = false;
        $ratings_arr['races'] = array();
        echo json_encode($ratings_arr, 500);
    }
mysqli_close($conn);

    

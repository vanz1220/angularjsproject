<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

DEFINE('HOST', 'localhost');
DEFINE('USER', 'root');
DEFINE('PASSWORD', '');
DEFINE('DB', 'horse_rating');

$table_name = 'horse_rate';
$conn = mysqli_connect(HOST, USER, PASSWORD, DB) or die('unable to connect DB');

$day = '';
if (isset($_GET['day'])) {
    $day= $_GET['day'];
    
    $result = mysqli_query($conn, "SELECT * FROM $table_name WHERE date='".$day."'");
    
}else{
    
    $result = mysqli_query($conn, "SELECT * FROM $table_name");
    
}
if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_assoc($result)){
        $id = $row["id"];
        $marketId = $row["marketId"];
        $date = $row["date"];
        $selectionId = $row["selectionId"];
        $rating = $row["rating"];
        
        echo "ID: $id\nMarket ID: $marketId\nDate: $date\nSelection ID: $selectionId\nRating: $rating\n\n";
    }
}
mysqli_close($con);

    

<?php

    require_once "db2.php";
    require_once "b4y_runners.php";

    $db = new DB2("b4y_cron");

    if ($db->link()->connect_errno > 0) {
        echo "Something went wrong " . $db->link()->connect_error;
        return false;
    }

    $query = "SELECT * FROM b4y_races WHERE date(date_time) = curdate()";

    $marketIds = $db->query($query, ["return" => "rows", "key" => "marketId"]);

    if (!empty($marketIds)) {

        foreach($marketIds as $marketId => $market_data) {
            echo $marketId;
            get_runners($marketId, $db);
        }
    } else {
        echo "Could not retrieve markets";
        error_log("Could not retrieve markets");
    }
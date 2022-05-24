<?php

    require_once "db2.php";
    require_once "b4y_runners.php";
    require_once "b4y_helpers.php";

    echo "Starting\n<br>\n";

    $db = new DB2("b4y_cron");
    $from = new DateTime("2022-01-01");
    $to =  new DateTime("2022-05-15");
    $one_day = DateInterval::createFromDateString("1 day");
    $current = $from;


    while($current <= $to) {
        echo "\n\n<br><br>" . $current->format("Y-m-d");
        echo backfill_data($current, $db);
        $current->add($one_day);
        sleep(10);
    }

    function backfill_data($current, $db) {


        if ($db->link()->connect_errno > 0) {
            echo "Something went wrong " . $db->link()->connect_error;
            return false;
        }
    
        $today = $current->format("Y-m-d");
    
        $races = ls_curl("?action=getRaces&date=" . $today, "races");
    
        if (empty($races) || !is_array($races)) {
            echo("Something went wrong getting race data at $today : " . (new DateTime)->getTimestamp());
            error_log("Something went wrong getting race data at $today : " . (new DateTime)->getTimestamp());
            return false;
        }
    
        $query = "INSERT INTO b4y_races (marketId, date_time, venue) VALUES (?,?,?)";
    
        foreach ($races as $race) {
            $inserted = $db->query($query, ["param" => [$race["marketId"], $race["date_time"], $race["venue"]], "return" => "insert_id"]);
            echo "Race $inserted:\n";
    
            get_runners($race["marketId"], $db);
        }

    }


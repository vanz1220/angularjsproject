<?php


    require_once "db2.php";

    echo json_encode(get_markets($_REQUEST['date'] ?? null));

    function get_markets($date) {

        $db = new DB2("b4y_cron");

        if (!empty($date)) {
            if (!filter_var($date, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => '/^[12][0-9][0-9][0-9]-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/']])) {
                return json_encode(["success" => false, "error" => "Invalid date input"]);
            }
        } else {
            return ["success" => false, "error" => "Missing date input"];
            
        }

        $query = "SELECT * FROM b4y_races WHERE date(date_time) = ?";

        $markets = $db->query($query, ["param" => [$date], "return" => "rows", "key" => "marketId"]);

        return ["success" => true, "data" => $markets];

    }
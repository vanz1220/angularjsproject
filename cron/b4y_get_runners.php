<?php


    require_once "db2.php";

    echo json_encode(get_runners($_REQUEST['marketId'] ?? null));

    function get_runners($marketId) {

        $db = new DB2("b4y_cron");

        if (!empty($marketId)) {
            if (!filter_var($marketId, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => '/^[0-9]\.[0-9]{5,12}$/']])) {
                return json_encode(["success" => false, "error" => "Invalid marketId input"]);
            }
        } else {
            return ["success" => false, "error" => "Missing marketId input"];
            
        }

        $query = "SELECT * FROM b4y_runners WHERE marketId = ?";

        $runners = $db->query($query, ["param" => [$marketId], "return" => "rows", "key" => "selectionId"]);

        return ["success" => true, "data" => $runners];

    }
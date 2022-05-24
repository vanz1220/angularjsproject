<?php

    require_once "db2.php";

    $db = new DB2("b4y_cron");

    echo json_encode(set_runner_rating($_REQUEST['rating'] ?? null, $_REQUEST['marketId'] ?? null, $_REQUEST['selectionId'] ?? null, $db));

    function set_runner_rating($rating, $marketId, $selectionId, $db) {

        if (!empty($marketId)) {
            if (!filter_var($marketId, FILTER_VALIDATE_REGEXP, ["options" => ["regexp" => '/^[0-9]\.[0-9]{5,12}$/']])) {
                return ["success" => false, "error" => "Invalid marketId input"];
            }
        } else {
            return ["success" => false, "error" => "Missing marketId input"]; 
        }

        if (!empty($selectionId)) {
            if (!is_numeric($selectionId)) {
                return ["success" => false, "error" => "Invalid selectionId input"]; 
            }
        } else {
            return ["success" => false, "error" => "Missing selectionId input"];
        }

        if (!empty($rating)) {
            if (!is_numeric($rating)) {
                return ["success" => false, "error" => "Invalid rating input"]; 
            }
        } else {
            return ["success" => false, "error" => "Missing rating input"];
        }

        $query = "UPDATE b4y_runners SET b4y_rating = ? WHERE marketId = ? AND selectionId = ?";

        $success = $db->query($query, ["param" => [$rating, $marketId, $selectionId], "return" => "affected_rows"]);

        return ["success" => !empty($success)];
    }

/*     function test_market($marketId, $db) {
        $query = "SELECT id FROM b4y_races WHERE marketId = ?";

        $valid = $db->query($query, ["param" => [$marketId], "return" => "row"]);

        return !empty($valid);
    }

    function test_selection($marketId, $selectionId, $db) {
        $query = "SELECT id FROM b4y_runners WHERE marketId = ? AND selectionId";

        $valid = $db->query($query, ["param" => [$selectionId], "return" => "row"]);

        return !empty($valid);
    } */
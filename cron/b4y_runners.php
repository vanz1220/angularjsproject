<?php

    require_once "b4y_helpers.php";

    function get_runners($marketId, $db) {

        $runners = ls_curl("?action=getRaceRunners&marketId=" . $marketId, "runners");

        if (empty($runners) || !is_array($runners)) {
            echo("Something went wrong getting runner data for market $marketId");
            error_log("Something went wrong getting runner data for market $marketId");
            return false;
        }

        $query = "INSERT INTO b4y_runners (
                        marketId,
                        selectionId, number, name,
                        trainer, jockey, age,
                        weight, dslr, silk,
                        odds, volume, ip_low,
                        bsp, position, status,
                        created
                    ) VALUES (
                        ?,
                        ?,?,?,
                        ?,?,?,
                        ?,?,?,
                        ?,?,?,
                        ?,?,?,
                        now()
                    ) ON DUPLICATE KEY UPDATE
                        odds = ?,
                        volume = ?,
                        ip_low = ?,
                        bsp = ?,
                        position = ?,
                        status = ?,
                        updated = now()
                        
                ";

        foreach ($runners as $idx => $runner) {
            $runner_id = $db->query($query, ["param" => [
                    $marketId,
                    $runner["selectionId"], $runner["number"] ?? null, $runner["name"],
                    $runner["trainer"] ?? null, $runner["jockey"] ?? null, $runner["age"] ?? null,
                    $runner["weight"] ?? null, $runner["dslr"] ?? null, $runner["silk"] ?? null,
                    $runner["odds"] ?? null, $runner["volume"] ?? null, $runner["ip_low"] ?? null,
                    $runner["bsp"] ?? null, $runner["position"] ?? null, $runner["status"] ?? null,
                    $runner["odds"] ?? null, $runner["volume"] ?? null, $runner["ip_low"] ?? null,
                    $runner["bsp"] ?? null, $runner["position"] ?? null, $runner["status"] ?? null
                ],
                "return" => "affected_rows"
            ]);
            echo "\tRunner $runner_id";
        }

    }
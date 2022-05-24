<?php

    header('Access-Control-Allow-Origin: *');
   
    ini_set( 'precision', 17 );
    ini_set( 'serialize_precision', -1 );

    $cons = [
        "b4y_local" => [
            "host" => "localhost",
            "user"  => "root",
            "password" => "wc6xcdZnvPeupsYb",
            "database" => "bet4youco_wp592",
            "port" => 3308
        ],
        "b4y" => [
            "host" => "localhost",
            "user"  => "bet4youco_wp592",
            "password" => "p2S2(S4p!Y')",
            "database" => "bet4youco_wp592"
        ],
        "b4y_cron" => [
            "host" => "localhost",
            "user"  => "bet4youco_cron",
            "password" => "QhQ90JlHdOPN",
            "database" => "bet4youco_data"
        ]
    ];
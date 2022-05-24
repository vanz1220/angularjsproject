<?php
    
    function ls_curl($suffix, $field) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.hedgerpro.co.uk/api/rpc/remote/b4y.php" . $suffix);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        
        $curl_error = NULL;
        if(curl_errno($ch)) $curl_error = curl_error($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($curl_error != NULL) {
            error_log($curl_error);
            //return array("error" => $curl_error, "success" => false);
        }
        if ($code != 200 && $code != 400 && $code != 500 && $code != 401 && $code != 404) {
            error_log($code); 
            //return array("error" => $code, "success" => false);
        }

        $json = json_decode($response, true);

        if ($json["success"] && !empty($json[$field])) {
            return $json[$field];
        } else {
            error_log("No race data available.");
        }
    }
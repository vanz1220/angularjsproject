<?php
    include_once("config.php");

    class DB2 {

        private $link;
        private $conn;

        function __construct($conn) {
            global $cons;

            $this->link = null;
            $this->conn = $cons[isset($conn) ? $conn : "rr"];
            $this->connect();
        }

        public function connect() {
            if(!isset($this->link)) {
                $this->link = new mysqli($this->conn['host'], $this->conn['user'], $this->conn['password'], $this->conn['database'], $this->conn['port'] ?? null);
            }
            if($this->link === false) {
                return false;
            }
            $this->link->options(MYSQLI_OPT_CONNECT_TIMEOUT, 60);
            $this->link->options(MYSQLI_OPT_INT_AND_FLOAT_NATIVE, TRUE);
            $this->link->set_charset('utf8');

            return $this->link;
        }

        public function link() {
            return $this->link;
        }

        public function conn() {
            return $this->conn;
        }

        public function last_id() {
            return $this->link->insert_id;
        }

        public function error() {
            return $this->link->error;
        }

        public function escape($value) {
            return $this->link->real_escape_string($value);
        }

        public function query($query, $options) {

            if(isset($_REQUEST['query'])) {
                $this->print_query($query, isset($options['param']) ? $options['param'] : null);  
            }

            if(isset($options['param']) && count($options['param']) > 0) {

                $stmt = $this->link->prepare($query);

                if($stmt !== false) {

                    $types = "";
                    foreach($options['param'] as $param) {
                        $types .= is_float($param) ? "d" : (is_int($param) ? "i" : "s");
                    }

                    $stmt->bind_param($types, ...$options['param']);  

                    $exec = $stmt->execute();
                    if($stmt->errno == 0) {
                        if(isset($options['return'])) {
                            $ret = $this->resp($options['return'] == "insert_id" || $options['return'] == "affected_rows" ? $stmt : $stmt->get_result(), $options);
                            $stmt->close();
                            return $ret;
                        }
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }

            } else {

                $result = $this->link->query($query);
                if(isset($options['return'])) {
                    return $this->resp($result, $options);
                }

            }
        }

        function resp($result, $options) {

            if(isset($options['return'])) {

                if($result == false) return null;

                if($options['return'] == "insert_id") 
                    return $result->insert_id; 

                if($options['return'] == "affected_rows") 
                    return $result->affected_rows; 

                $rows = [];

                while(($row = ($options['return'] == "array" ? $result->fetch_row() : $result->fetch_object())) == true) {
                    $row = json_decode(json_encode($row), isset($options['json_type']) ? $options['json_type'] : true);
                    if(isset($options['key'])) {
                        $rows[$row[$options['key']]] = isset($options['value']) ? $row[$options['value']] : $row;
                        if($options['return'] == "row") return $rows[$row[$options['key']]];
                    } else {
                        $rows[] = $row[0] ?? $row; 
                        if($options['return'] == "row") return $rows[0];
                    }
                }

                return isset($rows) ? $rows : null; // all rows default

            }
        }

		// finds raceId with value 1.23456 in the `race` table: find_id("race", "raceId", "1.23456");
        public function find_id($table, $uq_field, $uq_value) {

            if (is_array($uq_field) == false) {
                $uq_field = [$uq_field];
                $uq_value = [$uq_value];
            }
            $wheres = [];
            for ($x = 0; $x < count($uq_field); $x++) {
                $wheres[] = "`" . $uq_field[$x] . "` = '" . $uq_value[$x] . "'";
            }
            $result = $this->query("SELECT id FROM `{$table}` WHERE " . implode(" AND ", $wheres), ['return' => 'row']);

            if(isset($result['id'])) {
                return $result['id'];
            } else {
                return null;
            }
        }

		// if running in browser prints query to screen for fixed IP addresses!
        function print_query($q, $param) {
            if(isset($param)) {
                foreach($param as $p) {
                    $from = '/'.preg_quote("?", '/').'/';
                    $q = preg_replace($from, "'" . $p . "'", $q, 1);
                }
            }
            if(isset($_REQUEST['query']) || isset($argv[1])) {
               echo $q . "<br><br>";   
            }
            if(isset($_REQUEST['debug']) || isset($argv[2])) {
               error_log($q);
            }
        }

    } 
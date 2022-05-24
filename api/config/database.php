<?php
    class Database {
        //DB Params
        private $host = 'localhost';
        private $db_name = 'bet4youco_wp592';
        private $username = 'bet4youco_wp592';
        private $password = 'p2S2(S4p!Y';
        private $conn;

        //DB Connect
        public function connect() {
            $this->conn = null;

            try{
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo 'Connection Error: ' .$e->getMessage();
            }

            return $this->conn;
        }
    }
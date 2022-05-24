<?php
    class Rating{

        //DB Stuff
        private $conn;
        private $table = 'b4y_runners_rating';

        //Constructor with DB
        public function __construct($db){
            $this->conn = $db;
        }

        //Get All Ratings
        Public function read(){
            //Create query
            $query = 'SELECT * from  ' . $this->table;

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }

        //Get Runner Ratings
        Public function getRunnerRatings($date_time, $marketId){
            //Create query
            $query = 'SELECT * from  ' . $this->table .' WHERE date_time='. urldecode($date_time) .' AND marketId=' .urldecode($marketId);

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }

        //Get Single
        Public function read_single(){
            //Create query
            $query = 'SELECT * from  ' . $this->table . ' WHERE ID=1';

            //Prepare statement
            $stmt = $this->conn->prepare($query);

            //Execute query
            $stmt->execute();

            return $stmt;
        }
        public function create(){
            //Create Query
            $query = 'INSERT INTO ' . 
                $this->table . '
            SET
                marketId = :marketId,
                date_time = :date_time,
                selectionId = :selectionId,
                runners = :runners,
                rating = :rating';

                //Prepare statement
                $stmt = $this->conn->prepare($query);

                //Clean Data
                $this->classified_venues = htmlspecialchars(strip_tags($this->classified_venues));
                $this->marketId = htmlspecialchars(strip_tags($this->marketId));
                $this->date_time = htmlspecialchars(strip_tags($this->date_time));
                $this->selectionId = htmlspecialchars(strip_tags($this->selectionId));
                $this->runners = htmlspecialchars(strip_tags($this->runners));
                $this->rating = htmlspecialchars(strip_tags($this->rating));

                //Bind data
                $stmt->bindParam(':classified_venues', $this->classified_venues);
                $stmt->bindParam(':marketId', $this->marketId);
                $stmt->bindParam(':date_time', $this->date_time);
                $stmt->bindParam(':selectionId', $this->selectionId);
                $stmt->bindParam(':runners', $this->runners);
                $stmt->bindParam(':rating', $this->rating);

                //Execute query
                if($stmt->execute()){
                    return true;
                }

                //Print Error if something goes wrong
                printf("Error: %s.\n",$stmt->error);

                return false;
            }
    }
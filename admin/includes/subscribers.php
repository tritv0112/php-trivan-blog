<?php

    class Subscriber {

        // DB Stuff
        private $conn;
        private $table = 'blog_subscriber';

        // Subscriber Properties
        public $n_sub_id;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Read multi records
        public function read() {
            $sql = "SELECT * FROM $this->table";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // Delete category
        public function delete() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_sub_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':get_id', $this->n_sub_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

    }

?>
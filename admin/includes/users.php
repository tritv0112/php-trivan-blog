<?php

    class User {

        // DB Stuff
        private $conn;
        private $table = 'blog_user';

        // Blog Categories Properties
        public $n_user_id;	
        public $v_username;	
        public $v_password;	
        public $v_fullname;	
        public $v_phone;	
        public $v_email;	
        public $v_image;	
        public $v_message;	
        public $d_date_updated;	
        public $d_time_updated;	

        // Last id insert
        public $last_insert_id;

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

        // Read one record
        public function read_single() {
            $sql = "SELECT * FROM $this->table WHERE n_user_id = :get_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            // Set Properties
            $this->n_user_id = $row['n_user_id'];
            $this->v_username = $row['v_username'];
            $this->v_password = $row['v_password'];
            $this->v_fullname = $row['v_fullname'];
            $this->v_phone = $row['v_phone'];
            $this->v_email = $row['v_email'];
            $this->v_image = $row['v_image'];
            $this->v_message = $row['v_message'];
            $this->d_date_updated = $row['d_date_updated'];
            $this->d_time_updated = $row['d_time_updated'];
        }

        // Create user
        public function create() {
            // Create query
            $query = "INSERT INTO $this->table
                      SET n_user_id = :user_id,
                          v_username = :username, 
                          v_password = :password, 
                          v_fullname = :fullname, 
                          v_phone = :phone, 
                          v_email = :email, 
                          v_image = :image, 
                          v_message = :message, 
                          d_date_updated = :date_updated, 
                          d_time_updated = :time_updated";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_message = htmlspecialchars(strip_tags($this->v_message));

            // Bind data
            $stmt->bindParam(':user_id', $this->n_user_id);
            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);
            $stmt->bindParam(':fullname', $this->v_fullname);
            $stmt->bindParam(':phone', $this->v_phone);
            $stmt->bindParam(':email', $this->v_email);
            $stmt->bindParam(':image', $this->v_image);
            $stmt->bindParam(':message', $this->v_message);
            $stmt->bindParam(':date_updated', $this->d_date_updated);
            $stmt->bindParam(':time_updated', $this->d_time_updated);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        // Update user
        public function update() {
            // Create query
            $query = "UPDATE $this->table
                      SET v_username = :username, 
                          v_password = :password, 
                          v_fullname = :fullname, 
                          v_phone = :phone, 
                          v_email = :email, 
                          v_image = :image, 
                          v_message = :message, 
                          d_date_updated = :date_updated, 
                          d_time_updated = :time_updated
                      WHERE
                          n_user_id = :get_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_username = htmlspecialchars(strip_tags($this->v_username));
            $this->v_password = htmlspecialchars(strip_tags($this->v_password));
            $this->v_fullname = htmlspecialchars(strip_tags($this->v_fullname));
            $this->v_phone = htmlspecialchars(strip_tags($this->v_phone));
            $this->v_email = htmlspecialchars(strip_tags($this->v_email));
            $this->v_image = htmlspecialchars(strip_tags($this->v_image));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);
            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);
            $stmt->bindParam(':fullname', $this->v_fullname);
            $stmt->bindParam(':phone', $this->v_phone);
            $stmt->bindParam(':email', $this->v_email);
            $stmt->bindParam(':image', $this->v_image);
            $stmt->bindParam(':message', $this->v_message);
            $stmt->bindParam(':date_updated', $this->d_date_updated);
            $stmt->bindParam(':time_updated', $this->d_time_updated);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;
        }

        // Delete user
        public function delete() {

            // Create query
            $query = "DELETE FROM $this->table 
                      WHERE n_user_id = :get_id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->v_message = htmlspecialchars(strip_tags($this->v_message));

            // Bind data
            $stmt->bindParam(':get_id', $this->n_user_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
            // Print error if something goes wrong
            printf("Error: %s. \n$stmt->error");
            return false;

        }

        public function last_id() {
            $this->last_insert_id = $this->conn->lastInsertId();
            return $this->last_insert_id;
        }

        // Read login
        public function login() {
            $sql = "SELECT * FROM $this->table WHERE v_username = :username AND v_password = :password";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':username', $this->v_username);
            $stmt->bindParam(':password', $this->v_password);
            $stmt->execute();

            return $stmt;
        }

    }

?>
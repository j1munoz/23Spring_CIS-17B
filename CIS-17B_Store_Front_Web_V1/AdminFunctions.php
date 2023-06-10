<?php
    class Admin {
        // Properpties
        public $username;
        
        // Methods 
        function setUsername($username) {$this->username = $username;}
        function connectToDB() {
            // Connect to the database, return the connection
            $hostName = "localhost";
            $dbUser = "root";
            $dbPassword = "";
            $dbName = "store_front";
            $conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

            if(!$conn) {
                die("Error");
            }
            return $conn;
        }
        function addUser($username, $email, $password) {
            // Create the connection and hash the password
            $conn = $this->connectToDB();
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO entity_users (username, email, password) VALUES ('$username', '$email', '$password')";
            if(mysqli_query($conn, $sql)) {
            }
            else {echo mysqli_error($conn);}
            mysqli_close($conn);
        }
        
        function verifyNewUser($username, $email, $password, $confirm) {
            $errors = array();
            $username = $this->testInput($username);
            $email = $this->testInput($email);
            $password = $this->testInput($password);
            $confirm = $this->testInput($confirm);
        
            // Search for any errors
            if(empty($username) OR empty($email) OR empty($password) OR empty($confirm)) {
                array_push($errors, "All fields are required.");
            }
            else if ($this->checkDuplicate($username, 1) > 0) {
                array_push($errors, "This username already exists.");
            }
            else if (strlen($password) < 8) {
                array_push($errors, "Password must be 8 characters minimum.");
            }
            
            else if ($password !== $confirm) {
                array_push($errors, "Failed to confirm password.");
            }
            else if ($this->checkDuplicate($email, 2) > 0) {
                array_push($errors, "This email is already in use.");
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Invalid email format.");
            }
            
            return $errors; 
        }
        
        function verifyLogin($username, $password, $level) {
            // Declare Variables
            $errors = array();
            $username = $this->testInput($username);
            $password = $this->testInput($password);
            
            // Search for a match
            $conn = $this->connectToDB();
            if($level == 0) {$sql = "SELECT * FROM entity_users WHERE username = '$username'";}
            else{$sql = "SELECT * FROM entity_admin WHERE username = '$username'";}
            $result = mysqli_query($conn, $sql);
            $userFound = mysqli_fetch_assoc($result);
            if($userFound) {
                if(password_verify($password, $userFound["password"])) {
                    array_push($errors, "Success");
                }
                else {array_push($errors, "The username or password does not exist.");}
            }
            else {array_push($errors, "The username or password does not exist.");}
            return $errors;
        }
        
        function checkDuplicate($check, $field) {
            // Start the connection
            $conn = $this->connectToDB();
            
            // Execute the statement by level
            if ($field == 1) {$sql = "SELECT * FROM entity_users WHERE username = '$check'";}
            else if($field == 2) {$sql = "SELECT * FROM entity_users WHERE email = '$check'";}
            else if ($field == 3) {$sql = "SELECT * FROM enum_items WHERE name = '$check'";}
            $result = mysqli_query($conn, $sql);
            $dupe = mysqli_num_rows($result);
            mysqli_close($conn);
            return $dupe;
        }
        
        function testInput($input) {
            // Test the input
            $input = trim($input);
            $input = stripcslashes($input);
            $input = htmlspecialchars($input);
            return $input;
        }
        
        function getItems() {
            // Connect to DB and assign a new array
            $conn = $this->connectToDB();
            $items = array();
            
            // Get all items from the enum_items table, and push back each record into the array
            $sql = "SELECT * FROM enum_items";
            $result = mysqli_query($conn, $sql);
            while($itemFound = mysqli_fetch_assoc($result)) {array_push($items, $itemFound);}
            
            // Close the connection and return the array of items
            mysqli_close($conn);
            return $items;
        }
        
    }
    
    $admin = new Admin();

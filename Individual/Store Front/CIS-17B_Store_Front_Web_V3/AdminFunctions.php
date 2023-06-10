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
        
        function addNewItem($name, $price, $stock, $description) {
            // Create the connection and round the price to 2 decimal places
            $conn = $this->connectToDB();
            $price = round($price, 2);
            
            $sql = "INSERT INTO enum_items (name, stock, price, description) VALUES ('$name', '$stock', '$price', '$description')";
            if(mysqli_query($conn, $sql)) {
            }
            else {echo mysqli_error($conn);}
            mysqli_close($conn);
        }
        
        function modifyItem($name, $price, $stock, $description, $id) {
            $conn = $this->connectToDB();
            // Create the sql statement
            $set = "";
            $value = "(";
            $column = "(";
            
            // Test the inputs
            $name = $this->testInput($name);
            $stock = $this->testInput($stock);
            $description = $this->testInput($description);
            
            // Verify to see what needs to be modified
            if(!empty($name)) {$set .= "name = '$name', ";}
            if(!empty($stock)) { $set .= "stock = $stock, ";}
            if($price != 0) {$set .= "price = $price, ";}
            if(!empty($description)) {$set .= "description = '$description', ";}
            
            // If there as been a modification, execute the sql string
            if(strlen($set) > 1) {
                $set = substr_replace($set, "", strlen($set) - 2);
                $sql = "UPDATE enum_items SET $set WHERE id_item = $id";
                if(mysqli_query($conn, $sql)) {
                    echo '<p class="modifiedMessage">Item modified successfully.</p>';
                }
                else {echo mysqli_error($conn);}
            }
            mysqli_close($conn);
        }
        
        function deleteItem($id) {
            $conn = $this->connectToDB();
            $sql = "DELETE FROM enum_items WHERE id_item = $id";
            if(mysqli_query($conn, $sql)) {
            }
            else {echo 'Error deleting item: '.mysqli_error($conn);}
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
        
        function verifyNewItem($name, $price, $stock, $description) {
            // Start the connection and test each input
            $conn = $this->connectToDB();
            $errors = array();
            $name = $this->testInput($name);
            $price = $this->testInput($price);
            $stock = $this->testInput($stock);
            $description = $this->testInput($description);
            
            // Verify if item name already exists, else add the new item
            if(empty($name) OR empty($price) OR empty($stock) OR empty($description)) {
                array_push($errors, "All fields must be filled.");
            }
            else {
                $dupes = $this->checkDuplicate($name, 3);
                if($dupes > 0) {
                    array_push($errors, "This item already exists.");
                    return $errors;
                }
                array_push($errors, "Success");
                return $errors;
            }
            
            mysqli_close($conn);
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
        
        function storeToDB($user, $found) {
            $conn = $this->connectToDB();
            
            // Search for the users id first
            $sql = "SELECT * FROM entity_users WHERE username = '$found'";
            $result = mysqli_query($conn, $sql);
            $userFound = mysqli_fetch_assoc($result);
            if($userFound) {
                $userId = $userFound["id_user"];
                $itemData = json_decode($user, true);
                for($i = 0; $i < sizeof($itemData); $i++) {
                    // Store data into entity_orders table
                    $itemId = $itemData[$i]["itemId"];
                    $sql = "INSERT INTO entity_orders (id_user, id_item) VALUES ('$userId', '$itemId')";
                    mysqli_query($conn, $sql);
                    
                    // Get the amount of rows from the entity_orders table
                    $sql = "SELECT * FROM entity_orders";
                    $result = mysqli_query($conn, $sql);
                    $orderId = mysqli_num_rows($result);
                    
                    // Store data to xref tables
                    $sql = "INSERT INTO xref_orders_items (id_orders, id_items) VALUES ('$orderId', '$itemId')";
                    mysqli_query($conn, $sql);
                    $sql = "INSERT INTO xref_orders_users (id_user, id_order) VALUES ('$userId', '$orderId')";
                    mysqli_query($conn, $sql);
                    
                    // Update the stock amount for the each item bought
                    $sql = "SELECT stock FROM enum_items WHERE id_item = '$itemId'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $newStock = $row["stock"];
                    $newStock -= 1;
                    $sql = "UPDATE enum_items SET stock = '$newStock' WHERE id_item = '$itemId'";
                    mysqli_query($conn, $sql);
                }
            }
            else {echo 'Error: '.mysqli_error($conn);}
            
            mysqli_close($conn);
        }
        
        function getUserOrderHistory($username) {
            $conn = $this->connectToDB();
            
            // Search for the user id
            $sql = "SELECT * FROM entity_users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);
            $userFound = mysqli_fetch_assoc($result);
            if($userFound) {
                $userId = $userFound["id_user"];
                $sql = "SELECT `entity_users`.`username` AS `Username`, `enum_items`.`name` AS `Item_Name`, `enum_items`.`price` AS `Price`, `enum_items`.`description` AS `Description` FROM `store_front`.`xref_orders_users` AS `xref_orders_users`, `store_front`.`entity_users` AS `entity_users`, `store_front`.`entity_orders` AS `entity_orders`, `store_front`.`xref_orders_items` AS `xref_orders_items`, `store_front`.`enum_items` AS `enum_items` WHERE `xref_orders_users`.`id_user` = `entity_users`.`id_user` AND `entity_orders`.`id_orders` = `xref_orders_users`.`id_order` AND `entity_orders`.`id_user` = `xref_orders_users`.`id_user` AND `xref_orders_items`.`id_items` = `entity_orders`.`id_item` AND `xref_orders_items`.`id_orders` = `entity_orders`.`id_orders` AND `enum_items`.`id_item` = `xref_orders_items`.`id_items`";
                $result = mysqli_query($conn, $sql);
                $orders = array();
                while($recordFound = mysqli_fetch_assoc($result)) {array_push($orders, $recordFound);}
                return $orders;
            }
            else {echo 'Error: '.mysqli_error($conn);}
                
        }
        
        function getAllOrders() {
            $conn = $this->connectToDB();
            
            // Get all the orders
            $sql = "SELECT `entity_users`.`username` AS `Username`, `enum_items`.`name` AS `Item_Name`, `enum_items`.`price` AS `Price`, `enum_items`.`description` AS `Description` FROM `store_front`.`xref_orders_users` AS `xref_orders_users`, `store_front`.`entity_users` AS `entity_users`, `store_front`.`entity_orders` AS `entity_orders`, `store_front`.`xref_orders_items` AS `xref_orders_items`, `store_front`.`enum_items` AS `enum_items` WHERE `xref_orders_users`.`id_user` = `entity_users`.`id_user` AND `entity_orders`.`id_orders` = `xref_orders_users`.`id_order` AND `entity_orders`.`id_user` = `xref_orders_users`.`id_user` AND `xref_orders_items`.`id_items` = `entity_orders`.`id_item` AND `xref_orders_items`.`id_orders` = `entity_orders`.`id_orders` AND `enum_items`.`id_item` = `xref_orders_items`.`id_items`";
            $result = mysqli_query($conn, $sql);
            $orders = array();
            while($recordFound = mysqli_fetch_assoc($result)) {array_push($orders, $recordFound);}
            return $orders;
        }
    }
    
    $admin = new Admin();

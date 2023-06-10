<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>User Signup</title>
    </head>
    <body>
        <div id="box">
            <h1>User Signup</h1>
            <form action="UserSignup.php" method="post">
                <?php
                    if(isset($_POST["Submit"])) {
                        $username = $_POST["Username"];
                        $password = $_POST["Password"];
                        $confirm = $_POST["Confirm"];
                        $hours = $minutes = $seconds = 0;
                        $error = array();
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        
                        if(empty($username) OR empty($password) OR empty($confirm)) {
                            array_push($error, "All fields are required");
                        }
                        
                        if(strlen($password) < 8) {
                            array_push($error, "Password must be 8 characters minimum");
                        }
                        
                        if($password !== $confirm) {
                            array_push($error, "Passwords do not match");
                        }
                        
                        require_once "database.php";
                        $check = "SELECT * FROM users WHERE username = '$username'";
                        $result = mysqli_query($conn, $check);
                        $rowCount = mysqli_num_rows($result);
                        if($rowCount > 0) {
                            array_push($error, "Username already exists.");
                        }
                        
                        if(count($error) > 0) {
                            foreach ($error as $errors) {
                                echo "<p>$errors</p>";
                            }
                        }
                        else {
                            $sql = "INSERT INTO users (username, password, hours, minutes, seconds) VALUES ('$username', '$password_hash', '$hours', '$minutes', '$seconds')";
                            $stmt = mysqli_stmt_init($conn);
                            $run = mysqli_stmt_prepare($stmt, $sql);
                            if($run) {
                                mysqli_execute($stmt);
                                echo '<p>Signup Successful</p>';
                            }
                            else {
                                echo '<p>Could not signup due to server errors.</p>';
                            }
                            mysqli_close($conn);
                            header("UserLogin.php");
                        }
                    }
                ?>
                <label for="username">Username</label><br>
                <input name="Username" type="text" id="username" placeholder="Enter here..." class="menuBtn"><br><br>
                <label for="password">Password</label><br>
                <input name="Password" type="password" id="password" placeholder="Enter here..." class="menuBtn"><br><br>
                <label for="confirm">Confirm Password</label><br>
                <input id="confirm" name="Confirm" type="password" placeholder="Confirm Password..." class="menuBtn"><br><br>
                <input type="button" value="&laquo; Previous" onclick="history.back()" class="enter">
                <input name="Submit" type="submit" id="submit" class="enter" value="Submit &raquo;"><br><br>
            </form>
        </div>
    </body>
</html>
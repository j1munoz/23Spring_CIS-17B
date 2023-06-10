<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    if(isset($_POST["Submit"])) {
        $username = $_POST["Username"];
        $password = $_POST["Password"];
        $error = array();
                        
        if(empty($username) OR empty($password)) {
            array_push($error, "All fields are required");
        }
        else {
            require_once "database.php";
            $check = "SELECT * FROM admin WHERE username = '$username'";
            $result = mysqli_query($conn, $check);
            $userFound = mysqli_fetch_assoc($result);
            if($userFound) {
                if(password_verify($_POST['Password'], $userFound['password'])) {
                    mysqli_close($conn);
                    session_start();
                    $_SESSION["admin"] = $username;
                    header("Location: AdminPage.php");
                    exit();
                }
                else {
                    array_push($error, "The username or password does not exist.");
                }
            }
            else {
                array_push($error, "The username or password does not exist.");
            }
            mysqli_close($conn);
        }
                        
        if(count($error) > 0) {
            foreach($error as $errors) {
                echo "<p>$errors</p><br>";
            }
        }
    }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <title>Admin Login</title>
    </head>
    <body>
        <div id="box">
            <h1>Admin Login</h1>
            <form action="./AdminLogin.php" method="post">
                <label for="username">Username</label><br>
                <input name="Username" type="text" id="username" placeholder="Enter here..." class="menuBtn" required><br><br>
                <label for="password">Password</label><br>
                <input name="Password" type="password" id="password" placeholder="Enter here..." class="menuBtn" required><br><br>
                <input type="button" onclick="history.back()" class="enter" value="&laquo; Previous">
                <input name="Submit" type="submit" id="submit" class="enter" value="Submit &raquo;"><br><br>
            </form>
        </div>
    </body>
</html>
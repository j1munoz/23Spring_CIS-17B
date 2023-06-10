<!DOCTYPE html>
<?php
    if(isset($_POST["Submit"])) {
        require_once 'AdminFunctions.php';
        $errors = $admin->verifyLogin($_POST["username"], $_POST["password"], 0);
        
        if($errors[0] === "Success") {
            session_start();
            $_SESSION['loggedin'] = $_POST["username"];
            header("Location: index.php");
        }
        else {
            echo "<p>$errors[0]</p>";
        }
    }
?>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
        <title>User Login</title>
    </head>
    <body>
        <div class="login-signup">
            <h1>User Login</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="spacing">
                    <input type="text" name="username" class="text-field" placeholder=" ">
                    <span class="username-ph">Username</span><br>
                    <div class="underline"></div>   
                </div>
                <div class="spacing">
                    <input type="password" name="password" class="text-field" placeholder=" ">
                    <span class="password-ph" style="top: 412px;">Password</span><br>
                    <div class="underline"></div>
                </div>
                <div class="spacing">
                    <input type="button" class="login-signup-btn" onclick="history.back()" value="Reutrn">
                    <input class="login-signup-btn" type="submit" name="Submit">
                    <h3 class="admin-login">Are you an admin? <a href="AdminLogin.php">Login here.</a></h3>
                </div>
            </form>
        </div>
    </body>
</html>

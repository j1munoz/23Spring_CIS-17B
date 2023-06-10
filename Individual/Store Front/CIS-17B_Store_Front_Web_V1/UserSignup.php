<!DOCTYPE html>
<?php
    if(isset($_POST["Submit"])) {
        require_once 'AdminFunctions.php';
        $errors = $admin->verifyNewUser($_POST["username"], $_POST["email"], $_POST["password"],$_POST["confirm"]);
        
        if(count($errors) > 0) {
            foreach($errors as $error) {
                echo "<p>$error</p>";
            }
        }
        else {
            $admin->addUser($_POST["username"], $_POST["email"], $_POST["password"]);
            session_start();
            $_SESSION['loggedin'] = $_POST["username"];
            header("Location: index.php");
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
        <title>User Signup</title>
    </head>
    <body>
        <div class="login-signup">
            <h1>Sign Up</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div class="spacing">
                    <input type="text" name="username" class="text-field" placeholder=" ">
                    <span class="username-ph">Username</span><br>
                    <div class="underline"></div>   
                </div>
                <div class="spacing">
                    <input type="email" name="email" class="text-field" placeholder=" ">
                    <span class="email-ph">Email</span><br>
                    <div class="underline"></div>
                </div>
                <div class="spacing">
                    <input type="password" name="password" class="text-field" placeholder=" ">
                    <span class="password-ph">Password</span><br>
                    <div class="underline"></div>
                </div>
                <div class="spacing">
                    <input type="password" name="confirm" class="text-field" placeholder=" ">
                    <span class="confirm-ph">Confirm Password</span><br>
                    <div class="underline"></div>
                </div>
                <div class="spacing">
                    <input type="button" class="login-signup-btn" onclick="history.back()" value="Reutrn">
                    <input class="login-signup-btn" type="submit" name="Submit" value="Sign Up">
                </div>
            </form>
        </div>
    </body>
</html>

<!DOCTYPE html>
<?php
    if(isset($_POST["Submit"])) {
        require_once 'AdminFunctions.php';
        $errors = $admin->verifyLogin($_POST["username"], $_POST["password"], 1);
        
        if($errors[0] === "Success") {
            session_start();
            $_SESSION['loggedin-1'] = $_POST["username"];
            header("Location: AdminPage.php");
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
        <title>Admin Login</title>
    </head>
    <body>
        <div class="login-signup">
            <h1>Admin Login</h1>
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
                    <input type="button" class="login-signup-btn" onclick="history.back()" value="Previous">
                    <input class="login-signup-btn" type="submit" name="Submit" value="Sign in">
                </div>
            </form>
        </div>
    </body>
</html>
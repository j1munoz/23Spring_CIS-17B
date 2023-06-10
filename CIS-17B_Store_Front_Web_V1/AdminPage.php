<?php
    session_start();
    require_once 'AdminFunctions.php';
    $found = $_SESSION['loggedin-1'];
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="UserModel.js"></script>
        <script type="text/javascript" src="UserController.js"></script>
        <script type="text/javascript" src="UserView.js"></script>
        <title>Admin Page</title>
    </head>
    <body>
        <div class="navBar">
            <h1>The Shop</h1>
            <a href="logout.php" id="signup-viewcart">Logout</a>
            <a href="AdminPage.php" id="view-all-orders">View All Orders</a>
        </div>
        <div id="items-area" class="itemsArea">
        </div>
    </body>
</html>

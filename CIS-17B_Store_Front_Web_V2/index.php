<?php
    session_start();
    require_once 'AdminFunctions.php';
    if(!empty($_SESSION['loggedin'])) {
        $found = $_SESSION['loggedin'];
    }
    else {$found = "none";}
    
    // Get the items
    $items = $admin->getItems();
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
        <script type="text/javascript" src="cookieFunctions.js"></script>
        <script type="text/javascript" src="UserModel.js"></script>
        <script type="text/javascript" src="UserController.js"></script>
        <script type="text/javascript" src="UserView.js"></script>
        <title>Home</title>
    </head>
    <body>
        <div class="navBar">
            <h1>The Shop</h1>
            <a href="UserLogin.php" id="login-logout">Login</a>
            <a href="UserSignup.php" id="signup-viewcart">Signup</a>
        </div>
        <div id="no-items" class="noitems">
            There are currently no items available.
        </div>
        <div class="cartMessage" id="cart-message"></div>
        <div id="grid-container" class="gridContainer"></div>
    </body>
    <script>
        // New controller object
        let cont = new UserController(<?php echo json_encode($found); ?>, <?php echo json_encode($items) ?>);
        
        // Show the top right corner of the screen
        cont.requestShowRight();
        
        // Send a request to show the catalog
        cont.requestShowItems(0);
    </script>
</html>

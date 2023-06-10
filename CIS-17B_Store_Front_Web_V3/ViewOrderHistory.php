<?php
    session_start();
    require_once 'AdminFunctions.php';
    $found = "";
    if(!empty($_SESSION['loggedin'])) {
        $found = $_SESSION['loggedin'];
        $orders = $admin->getUserOrderHistory($found);
    }
    else {$found = "none";}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="cookieFunctions.js"></script>
        <script type="text/javascript" src="UserModel.js"></script>
        <script type="text/javascript" src="UserController.js"></script>
        <script type="text/javascript" src="UserView.js"></script>
        <title>Order History</title>
    </head>
    <body>
        <div class="navBar">
            <h1>The Shop</h1>
            <h1 class="viewOrdersMessage">Order History</h1>
            <a href="index.php">Return to Home Page</a>
        </div>
        <div id="no-items-in-cart"></div>
        <div id="grid-container" class="gridContainer" style="margin-top: 200px"></div>
    </body>
    <script>
        // New controller object
        let cont = new UserController(<?php echo json_encode($found) ?>, <?php echo json_encode($orders) ?>);
        
        // Send a request to view the user's order history
        cont.requestUserOrderHistory();
    </script>
</html>

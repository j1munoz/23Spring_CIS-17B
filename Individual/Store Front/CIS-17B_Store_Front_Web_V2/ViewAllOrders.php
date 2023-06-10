<?php
    session_start();
    require_once 'AdminFunctions.php';
    
    // Get all records
    $orders = $admin->getAllOrders();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="styles.css">
        <script type="text/javascript" src="UserModel.js"></script>
        <script type="text/javascript" src="UserController.js"></script>
        <script type="text/javascript" src="UserView.js"></script>
        <title>Home</title>
    </head>
    <body>
        <div class="navBar">
            <h1>The Shop</h1>
            <h1 class="viewOrdersMessage">All Orders</h1>
            <a href="AdminPage.php">Return to Admin Page</a>
        </div>
        <div id="grid-container" class="gridContainer" style="margin-top: 200px"></div>
    </body>
    <script>
        // New controller object
        let cont = new UserController("none", <?php echo json_encode($orders) ?>);
        
        // Display all orders
        cont.requestShowAllOrders();
    </script>
</html>
<?php
    session_start();
    require_once 'AdminFunctions.php';
    $cart = "found";
    $found = "";
    if(!empty($_SESSION['loggedin'])) {
        $found = $_SESSION['loggedin'];
    }
    else {$found = "none";}

    // Terminate if the user buys their cart
    if(isset($_POST["BuyCart"])) {
        $send = $found;
        $admin->storeToDB($_COOKIE[$found."-cart"], $send);
        unset($_COOKIE[$found."-cart"]);
        setcookie(($found."-cart"), "", time() - 3600, '/');
        $cart = "none";
    }
    else {
        if(!isset($_COOKIE[$found."-cart"])) {
            $cart = "none";
        }
        else {
            $cart = $_COOKIE[$found."-cart"];
        }
    }
?>
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
            <h1 class="viewOrdersMessage">Viewing Your Cart</h1>
            <a href="index.php">Return to Home Page</a>
            <a href="ViewOrderHistory.php">View Order History</a>
        </div>
        <div id="no-items-in-cart"></div>
        <div id="buy-items" class="buyItems">
            <h2>Would you like to buy the items in your cart?</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="button" value="Cancel" id="close-buy" name="cancel" class="buyItemsBtn" onclick="cont.requestBuyMenu('close')">
                <input type="submit" name="BuyCart" value="Purchase" class="buyItemsBtn">
                <input type="number" hidden value="1" name="temp">
            </form>
        </div>
        <div id="buy-cart-btn-area" style="visibility: visible;"><input type="button" class="buyCartBtn" id="buy-cart-button" value="Purchase Items From Cart" onclick="cont.requestBuyMenu('open')"></div>
        <div class="cartMessage" id="cart-message"></div>
        <div id="grid-container" class="gridContainer" style="margin-top: 200px"></div>
    </body>
    <script>
        // New controller object
        let cont = new UserController(<?php echo json_encode($found); ?>, <?php echo json_encode($cart); ?>);
        
        // Display the user's cart
        cont.requestViewCart(<?php echo json_encode($cart); ?>);
    </script>
</html>

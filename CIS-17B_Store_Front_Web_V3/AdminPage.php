<?php
    session_start();
    require_once 'AdminFunctions.php';
    $found = $_SESSION['loggedin-1'];
    
    if(isset($_POST["AddItem"])) {  // Add a new item
        $errors = $admin->verifyNewItem($_POST["name"], $_POST["price"], $_POST["stock"], $_POST["description"]);
        if($errors[0] == "Success") {
            $admin->addNewItem($_POST["name"], $_POST["price"], $_POST["stock"], $_POST["description"]);
        }
        else {echo $errors[0];}
    }
    else if(isset($_POST["EditItem"])) {    // Edit item
        $admin->modifyItem($_POST["name"], $_POST["price"], $_POST["stock"], $_POST["description"], $_POST["id"]);
    }
    else if(isset($_POST["DeleteItem"])) {  // Delete item
        $admin->deleteItem($_POST["id"]);
    }
    
    // Get the data for all items
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
        <script type="text/javascript" src="UserModel.js"></script>
        <script type="text/javascript" src="UserController.js"></script>
        <script type="text/javascript" src="UserView.js"></script>
        <title>Admin Page</title>
    </head>
    <body>
        <div class="navBar">
            <h1>The Shop</h1>
            <a href="logout.php" id="signup-viewcart">Logout</a>
            <a href="ViewAllOrders.php" id="view-all-orders">View All Orders</a>
        </div>
        <div id="items-area" class="itemsArea">
            <div id="no-items" class="noitems">
                There are currently no items. Click on the button below to add an item.
            </div>
            <div id="show-items" class="showItems">
                <div id="show-items-btn-area"><input type="button" id="add-items-btn" class="addItemsBtn" value="Add A New Item" onclick="cont.requestToggleMenu(0)"></div>
                <div id="add-item-menu" class="addItemMenu">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                        <input id="item-name" type="text" name="name">
                        <label for="item-name">Item Name</label><br>
                        <input id="item-price" type="number" step=".01" name="price">
                        <label for="item-price">Price</label><br>
                        <input id="item-stock" type="number" name="stock">
                        <label for="item-stock">Stock Amount</label><br>
                        <input id="item-description" type="text" name="description">
                        <label for="item-description">Description</label><br>
                        <input type="button" value="Exit" id="exit-add-item-menu" onclick="cont.requestToggleMenu(0)">
                        <input type="submit" name="AddItem" value="Confirm">
                    </form>
                </div>
            </div>
            <div id="grid-container" class="gridContainer"></div>
            <div class="editDeleteItem">
                <form id="edit-delete-item" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <h3 id="item-name-header"></h3>
                    <label for="edit-name">Enter New Name</label>
                    <input type="text" name="name" id="edit-name"><br><br>
                    <label for="edit-price">Enter New Price</label>
                    <input type="number" step=".01" name="price" value="0" min="0" id="edit-price"><br><br>
                    <label for="edit-stock">Enter New Stock Amount</label>
                    <input type="number" name="stock" min="0" id="edit-stock"><br><br>
                    <label for="edit-description">Enter New Description</label>
                    <input type="text" name="description" id="edit-description"><br><br>
                    <input type="button" class="editBtns" value="Exit" id="exit-edit-item-menu" onclick="cont.requestToggleMenu(2)">
                    <input type="submit" class="editBtns" value="Confirm Changes" name="EditItem">
                    <input type="button" class="editBtns" value="Delete" id="hide-delete-menu" onclick="cont.requestToggleMenu(1)">
                    <div id="hidden-id"></div>
                    <div class="deleteItemMenu" id="delete-item-menu">
                        <div>
                            <h3>Are you sure you want to delete this item?</h3><br>
                            <input type="button" class="editBtns" value="Exit" id="exit-delete-item-menu" onclick="cont.requestToggleMenu(1)">
                            <input type="submit" name="DeleteItem" class="editBtns" value="Delete Item">
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <script>
        // New controller object
        let cont = new UserController(<?php echo json_encode($found) ?>, <?php echo json_encode($items) ?>);
        
        // Display the items
        cont.requestShowItems(1);
    </script>
</html>

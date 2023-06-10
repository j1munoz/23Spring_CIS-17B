class UserView {
    displayItems(items, level) {
        if(items.length < 1) {
            document.getElementById("no-items").style.visibility = "visible";
        }
        else {
            let html = "";
            let str = "";
            for(let i = 0; i < items.length; i++) {
                let idName = items[i].name;
                idName = idName.split(' ').join('_');
                if(level == 0) {
                    if(items[i].stock == 0) {str = '<div class="gridItem"><h1>'+items[i].name+'</h1><br><h3>Price: $'+items[i].price+'</h3><br><h3>Stock Amount: SOLD OUT</h3><br><p>Description: '+items[i].description+'</p></div>';}
                    else {str = '<div class="gridItem"><h1>'+items[i].name+'</h1><br><h3>Price: $'+items[i].price+'</h3><br><h3>Stock Amount: '+items[i].stock+'</h3><br><p>Description: '+items[i].description+'</p><br><input type="button" id="'+idName+'-add" class="editItemBtn" value="Add to Cart" onclick="cont.requestAddToCart('+i+')"></div>';}
                }
                else {
                    str = '<div class="gridItem"><h1>'+items[i].name+'</h1><br><h3>Price: $'+items[i].price+'</h3><br><h3>Stock Amount: '+items[i].stock+'</h3><br><p>Description: '+items[i].description+'</p><br><input type="button" id="'+idName+'-edit" class="editItemBtn" value="Edit" onclick="cont.requestEditItemMenu('+i+')"></div>';
                }
                html += str;
            }
            document.getElementById("grid-container").innerHTML = html;
        }
    }
    
    verifyUser(username) {
        if(username !== "none") {
            document.getElementById("login-logout").innerHTML = "Logout";
            document.getElementById("login-logout").href = "logout.php";
            document.getElementById("signup-viewcart").innerHTML = "View Cart";
            document.getElementById("signup-viewcart").href = "viewcart.php";
        }
    }
    
    displayCart(request, cart) {
        let html = " ";
        if(request == "none") {
           document.getElementById("buy-cart-btn-area").style.visibility = "hidden";
           document.getElementById("no-items-in-cart").innerHTML = '<div id="no-items" class="noitems" style="top: 25%; visibility: visible">There are currently no items in your cart.</div>';
        }
        else {
            cart = JSON.parse(cart);
            let show = document.getElementById("buy-cart-btn-area");
            show.classList.toggle("show");
            for(let i = 0; i < cart.length; i++) {
               let idName = cart[i].itemName;
               idName = idName.split(' ').join('_');
               let str = '<div class="gridItem"><h1>'+cart[i].itemName+'</h1><br><h3>Price: $'+cart[i].itemPrice+'</h3><br><br><p>Description: '+cart[i].itemDescription+'</p><br><input type="button" id="'+idName+'-remove" onclick="cont.requestRemoveFromCart('+i+')" class="editItemBtn" value="Remove From Cart"></div>';
               html += str;
           }
       }
       document.getElementById("grid-container").innerHTML = html;
    }
    
    displayAddedToCartMsg(verify) {
        if(verify == "existing") {
            document.getElementById("cart-message").innerHTML = "Item added to cart successfully.";
            document.getElementById("cart-message").classList.toggle("showCartMessage");
            setTimeout(function(){document.getElementById("cart-message").innerHTML = ""; document.getElementById("cart-message").classList.toggle("showCartMessage");}, 5000);
        }
        else if(verify == "new"){
            document.getElementById("cart-message").innerHTML = "Item added to cart successfully.";
            setTimeout(function(){document.getElementById("cart-message").innerHTML = "";}, 5000);
        }
    }
    
    displayBuyMenu(closeOpen) {
        if(closeOpen == "open") {document.getElementById("buy-items").style.visibility = "visible";}
        else document.getElementById("buy-items").style.visibility = "hidden";
    }
    
    displayUserOrderHistory(request, orders, username) {
        if(request == "none") {document.getElementById("no-items-in-cart").innerHTML = '<div id="no-items" class="noitems" style="top: 25%; visibility: visible">You have not ordered anything.</div>';}
        else {
            let html = " ";
            for(let i = 0; i < orders.length; i++) {
                if(username == orders[i].Username) {
                    let str = '<div class="gridItem"><h1>Item Name: '+orders[i].Item_Name+'</h1><br><h3>Price: $'+orders[i].Price+'</h3><br><br><p>Description: '+orders[i].Description+'</p><br></div>';
                    html += str;
                }
            }
            document.getElementById("grid-container").innerHTML = html;
        }
    }
    
    displayToggleMenu(level) {
        if(level == 0) document.getElementById("add-item-menu").classList.toggle("show");
        else if(level == 1) document.getElementById("delete-item-menu").classList.toggle("showDelete");
        else if(level == 2) document.getElementById("edit-delete-item").classList.toggle("show");
    }
    
    displayEditItemMenu(index, items) {
        document.getElementById("edit-delete-item").classList.toggle("show");
        document.getElementById("item-name-header").innerHTML = items[index].name;
        document.getElementById("hidden-id").innerHTML = '<input type="number" name="id" value="'+items[index].id_item+'" style="visibility: hidden">';
    }
    
    displayAllOrders(orders) {
        let html = "";
        for(let i = 0; i < orders.length; i++) {
            let str = '<div class="gridItem"><h2>Item Name: '+orders[i].Item_Name+'</h2><br><h3>Price: $'+orders[i].Price+'</h3><br><br><p>Description: '+orders[i].Description+'</p><br><p class="orderedBy">Ordered by: '+orders[i].Username+'</p></div>';
            html += str;
        }
        document.getElementById("grid-container").innerHTML = html;
    } 
}
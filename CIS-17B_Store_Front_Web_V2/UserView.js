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
                    else {str = '<div class="gridItem"><h1>'+items[i].name+'</h1><br><h3>Price: $'+items[i].price+'</h3><br><h3>Stock Amount: '+items[i].stock+'</h3><br><p>Description: '+items[i].description+'</p><br><input type="button" id="'+idName+'-add" class="editItemBtn" value="Add to Cart"></div>';}
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
            document.getElementById("signup-viewcart").href = "index.php";
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
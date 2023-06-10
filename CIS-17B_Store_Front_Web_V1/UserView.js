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
}
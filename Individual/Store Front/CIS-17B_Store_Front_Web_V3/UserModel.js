class UserModel{
    constructor(name) {
            this.username = name;
        }

        attemptAddCart(index, item) {
            let items = item;
            let username = this.username;
            let name = items[index].name;
            let id_item = items[index].id_item;
            let price = items[index].price;
            let description = items[index].description;
            let stock = items[index].stock;
                if(username == "none") {window.location.href = "http://localhost/CIS-17B_Store_Front_Web/UserLogin.php"; return "none";}
                else {
                    if(stock != 0) {
                        let checkCreate = checkCookie(username+"-cart");
                        if(checkCreate == "none") {
                            let obj = [{itemName: name, itemId: id_item, itemPrice: price, itemDescription: description}];
                            let stringObj = JSON.stringify(obj);
                            setCookie(username+"-cart", stringObj, 7);
                            return "new";
                        }
                        else {
                            let cart = [];
                            checkCreate = JSON.parse(checkCreate);
                            cart = checkCreate;
                            let addNew = {itemName: name, itemId: id_item, itemPrice: price, itemDescription: description};
                            cart.push(addNew);
                            let jsonStr = JSON.stringify(cart);
                            setCookie(username+"-cart", jsonStr, 7);
                            return "existing";
                        }
                    }
                }
            
        }

        verifyCart(cart) {
            if(cart === "none") return "none";
            return "true";
        }

        removeItem(index, cart) {
            cart = JSON.parse(cart);
            let tmpCart = [];
            tmpCart = cart;
            tmpCart.splice(index, 1);
               if(Array.isArray(tmpCart) && tmpCart.length) {
                   setCookie(this.username+"-cart", JSON.stringify(tmpCart), 7);
                   return true;
               }
               else {
                   deleteCookie(this.username+"-cart", JSON.stringify(tmpCart));
                   return "none";
               }
        }

        updateCart() {
            if(checkCookie(this.username+"-cart") != "none") return getCookie(this.username+"-cart");
            else return "none";
        }

        verifyUserOrderHistory(orders) {
            return (orders.length < 1) ? "none" : true;
        }
}
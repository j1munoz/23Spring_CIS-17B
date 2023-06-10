class UserController {
    constructor(username, items) {
        this.username = username;
        this.items = items;
        this.view = new UserView();
        this.model = new UserModel(username);
    }
    
    requestShowRight() {
        this.view.verifyUser(this.username);
    }
    
    requestShowItems(level) {
        this.view.displayItems(this.items, level);
    }
    
    requestAddToCart(index) {
        let request = this.model.attemptAddCart(index, this.items);
        this.view.displayAddedToCartMsg(request);
    }
    
    requestRemoveFromCart(index) {
        let request = this.model.removeItem(index, this.cart);
        this.cart = this.model.updateCart();
        this.view.displayCart(request, this.cart);
    }
    
    requestViewCart(cart) {
        this.cart = cart;
        let request = this.model.verifyCart(cart); 
        this.view.displayCart(request, cart);
    }
    
    requestBuyMenu(closeOpen) {
        this.view.displayBuyMenu(closeOpen);
    }
    
    requestUserOrderHistory() {
        let request = this.model.verifyCart(this.items);
        this.view.displayUserOrderHistory(request, this.items, this.username);
    }
    
    requestEditItemMenu(index) {
        this.view.displayEditItemMenu(index, this.items);
    }
    
    requestToggleMenu(level) {
        this.view.displayToggleMenu(level);
    }
    
    requestShowAllOrders() {
        this.view.displayAllOrders(this.items);
    }
}
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
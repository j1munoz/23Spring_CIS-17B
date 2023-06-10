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
}
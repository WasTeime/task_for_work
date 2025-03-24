class Product {
    constructor(id, name, price, quantity, totalQuantity) {
        this.id = id;
        this.name = name;
        this.price = price;
        this.quantity = quantity;
        this.totalQuantity = totalQuantity;
    }

    // Методы для работы с продуктом
    updateQuantity(newQuantity) {
        if (newQuantity >= 0) {
            this.quantity = newQuantity;
        }
    }

    getTotalPrice() {
        return this.price * this.quantity;
    }
}

export default Product

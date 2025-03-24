class Cart {
    constructor() {
        this.cartKeyInStorage = 'cart'
        this.idOfCartCountElement = 'cart-count'
        this.cart = this.loadCart()
    }

    loadCart() {
        const cart = localStorage.getItem(this.cartKeyInStorage)
        return cart ? JSON.parse(cart) : []
    }

    getCart() {
        return this.cart
    }

    getCountProducts() {
        return this.cart.length
    }

    updateCartCountUI() {
        let cartCount = document.getElementById('cart-count')
        cartCount.textContent = window.cartInstance.getCountProducts()
    }
    /*
    [{productId,
    productName,
    productQuantity
    productPrice for one item}]
    sum - общая сумма корзины
     */

    /*
    1) нажали кнопку добавить продукт
    2) формируется объект с количеством 1
    3) добавляется в корзину
    4) появляется кнопка для изменения количества продукта
    4.1) если пользователь нажимает на + или -, тогда формируется новый объект с другим количеством и отправляется в метод addCToCart
     */

    //добавляет несуществующий товар в корзину, если товар есть то уввеличивает его количество на quantity
    //если товара нет в корзине возвращает true, иначе false
    addToCart(product, quantity = 1) {
        const findedProduct = this.findProductInCart(product.id)
        if (!findedProduct) {
            this.cart.push({...product, quantity: 1})
        } else {
            findedProduct.quantity += quantity
            findedProduct.totalQuantity = product.totalQuantity
        }
        this.saveCart()
    }

    //если найден возвращает product, если нет такого продукта, то false
    findProductInCart(productId) {
        const findedProduct = this.cart.find(item => item.id == productId)
        return findedProduct !== undefined ? findedProduct : false
    }

    //если продукт найден, то обновляем количество, если нет, то возвращаем false
    changeQuantity(productId, quantity = 1) {
        const findedProduct = this.findProductInCart(productId)
        if (findedProduct) {
            findedProduct.quantity = quantity
            this.saveCart()
            return true
        }
        return false
    }

    saveCart() {
        localStorage.setItem(this.cartKeyInStorage, JSON.stringify(this.cart));
        window.cartInstance.updateCartCountUI()
    }

    deleteFromCart(productId) {
        this.cart = this.cart.filter(item => item.id !== productId);
        this.saveCart();
    }

    deleteCart() {
        localStorage.removeItem(this.cartKeyInStorage)
        this.cart = [];
        window.cartInstance.updateCartCountUI()
    }
}
window.cartInstance = new Cart();
export default Cart;


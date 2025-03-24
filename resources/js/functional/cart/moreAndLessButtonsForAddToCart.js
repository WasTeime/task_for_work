import Product from '@/types/Product'

// Функция добавления товара в корзину
function addToCart(productId, productName, productPrice, totalQuantity) {
    const product = new Product(productId, productName, productPrice, 1, totalQuantity);
    // const product = { id: productId, name: productName, price: productPrice, totalQuantity: totalQuantity };
    window.cartInstance.addToCart(product);

    // Обновляем интерфейс
    updateCartUI(productId);
}

// Функция изменения количества товара
function changeQuantity(productId, delta) {
    const cart = window.cartInstance;
    const product = cart.findProductInCart(productId);

    if (product) {
        const newQuantity = product.quantity + delta;
        if (newQuantity > 0 && newQuantity <= product.totalQuantity) {
            cart.changeQuantity(productId, newQuantity);
        } else if (newQuantity === 0) {
            cart.deleteFromCart(productId);
        }

        // Обновляем интерфейс
        updateCartUI(productId);
    }
}

// Функция обновления интерфейса
function updateCartUI(productId) {
    const cart = window.cartInstance;
    const product = cart.findProductInCart(productId);

    const addButton = document.getElementById(`add-to-cart-button-${productId}`);
    const quantityContainer = document.getElementById(`quantity-buttons-${productId}`);
    const quantitySpan = document.getElementById(`product-quantity-${productId}`);

    if (product) {
        // Если товар в корзине, показываем кнопки изменения количества
        addButton.style.display = 'none';
        quantityContainer.style.display = 'flex';
        quantitySpan.textContent = product.quantity;
    } else {
        // Если товара нет в корзине, показываем кнопку "Добавить в корзину"
        addButton.style.display = 'block';
        quantityContainer.style.display = 'none';
    }
}
window.changeQuantity = changeQuantity
window.addToCart = addToCart
document.addEventListener('DOMContentLoaded', () => {
    const productId = document.getElementsByClassName('product-id')[0].id
    updateCartUI(productId);
});

function renderCart() {
    const cart = window.cartInstance.getCart();
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotalElement = document.getElementById('cart-total');

    // Очищаем контейнер
    cartItemsContainer.innerHTML = '';

    let total = 0;

    console.log(cart)
    // Перебираем товары в корзине
    cart.forEach(product => {
        const itemTotal = product.price * product.quantity;
        total += itemTotal;

        // Создаем HTML для товара
        const itemHTML = `
                        <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow">
                            <div>
                                <h3 class="text-lg font-semibold">${product.name}</h3>
                                <p class="text-gray-600">${product.price} руб. x ${product.quantity}</p>
                            </div>
                            <div class="flex items-center space-x-4">
                                <button
                                    onclick="changeQuantity(${product.id}, -1)"
                                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                                >
                                    -
                                </button>
                                <span>${product.quantity}</span>
                                <button
                                    onclick="changeQuantity(${product.id}, 1)"
                                    class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                                >
                                    +
                                </button>
                                <button
                                    onclick="removeFromCart(${product.id})"
                                    class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors"
                                >
                                    Удалить
                                </button>
                            </div>
                        </div>
                    `;

        // Добавляем товар в контейнер
        cartItemsContainer.innerHTML += itemHTML;
    });

    // Обновляем общую стоимость
    cartTotalElement.textContent = total;
}

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
        renderCart();
    }
}

function removeFromCart(productId) {
    window.cartInstance.deleteFromCart(productId)
    renderCart()
}

// Функция для оформления заказа
async function checkout() {
    const cart = window.cartInstance;
    if (cart.getCountProducts() <= 0) {
        alert('Корзина пуста!')
        return;
    }

    const total = document.getElementById('cart-total').textContent
    let comment = document.getElementById('order-comment').value

    try {
        const response = await fetch('/orders/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                cart: cart.getCart(), // Отправляем данные корзины
                comment: comment,
                total: total
            })
        });

        const data = await response.json();

        if (data.success) {
            cart.deleteCart();
            window.location.href = data.redirectUrl;
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Ошибка при оформлении заказа:', error);
        alert('Произошла ошибка при оформлении заказа.');
    }
}

window.changeQuantity = changeQuantity;
window.checkout = checkout;
window.removeFromCart = removeFromCart;

// При загрузке страницы отображаем корзину
document.addEventListener('DOMContentLoaded', renderCart);

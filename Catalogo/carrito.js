let cart = JSON.parse(localStorage.getItem('cart')) || [];

function updateCartCount() {
    document.getElementById('cartCount').textContent = cart.reduce((acc, item) => acc + item.quantity, 0);
}

function redirectToPayment() {
    if (cart.length === 0) {
        alert('El carrito está vacío. Añade productos antes de pagar.');
        return;
    }
    // Reemplaza '/ruta-de-pago' con la ruta deseada
    window.location.href = '/PagosPug/index.html';
}


function addToCart(product) {
    const existing = cart.find(item => item.id === product.id);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({ ...product, quantity: 1 });
    }
    saveCart();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    saveCart();
}

function changeQuantity(productId, quantity) {
    const product = cart.find(item => item.id === productId);
    if (product) {
        product.quantity = quantity > 0 ? quantity : 1;
        saveCart();
    }
}

function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCart();
    updateCartCount();
}

function updateCart() {
    const cartTable = document.querySelector('#cartTable tbody');
    cartTable.innerHTML = '';
    let total = 0;

    cart.forEach(item => {
        const row = document.createElement('tr');
        total += item.price * item.quantity;

        row.innerHTML = `
            <td><img src="${item.image}" alt="${item.name}" style="width: 50px;"></td>
            <td>${item.name}</td>
            <td>$${item.price}</td>
            <td>
                <input type="number" value="${item.quantity}" min="1" onchange="changeQuantity(${item.id}, this.value)">
            </td>
            <td>$${item.price * item.quantity}</td>
            <td>
                <button onclick="removeFromCart(${item.id})">Eliminar</button>
            </td>
        `;
        cartTable.appendChild(row);
    });

    document.getElementById('cartTotal').textContent = `Total: $${total}`;
}

function showCart() {
    document.getElementById('cartModal').style.display = 'block';
    updateCart();
}

function closeCart() {
    document.getElementById('cartModal').style.display = 'none';
}

document.getElementById('viewCartButton').addEventListener('click', showCart);

document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', () => {
        const productElement = button.closest('.product');
        const product = {
            id: parseInt(productElement.dataset.id),
            name: productElement.dataset.name,
            price: parseFloat(productElement.dataset.price),
            image: productElement.querySelector('img').src
        };
        addToCart(product);
    });
});

// Inicialización
updateCartCount();

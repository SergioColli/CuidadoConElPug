// Función para cargar productos al carrito
function loadCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const tablaCarrito = document.getElementById("tabla-carrito");
    const totalGeneral = document.getElementById("total-general");

    // Limpiar la tabla
    tablaCarrito.innerHTML = '';

    // Verificar si el carrito está vacío
    if (cart.length === 0) {
        tablaCarrito.innerHTML = `<tr><td colspan="6">Tu carrito está vacío.</td></tr>`;
        totalGeneral.textContent = 'Total: $0';
        return;
    }

    let total = 0;

    // Llenar la tabla con los productos
    cart.forEach((producto, index) => {
        const subtotal = producto.price * producto.quantity;
        total += subtotal;

        const fila = document.createElement('tr');
        fila.innerHTML = `
            <td><img src="${producto.image}" alt="${producto.name}" class="product-image"></td>
            <td>${producto.name}</td>
            <td>$${producto.price}</td>
            <td>${producto.quantity}</td>
            <td>$${subtotal}</td>
            <td>
                <button class="btn-remove" data-index="${index}">Eliminar</button>
            </td>
        `;
        tablaCarrito.appendChild(fila);
    });

    // Actualizar el total
    totalGeneral.textContent = `Total: $${total}`;

    // Añadir eventos a los botones de eliminar
    document.querySelectorAll('.btn-remove').forEach(button => {
        button.addEventListener('click', removeFromCart);
    });
}

// Función para eliminar un producto del carrito
function removeFromCart(event) {
    const index = event.target.getAttribute('data-index');
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1); // Eliminar el producto por índice
    localStorage.setItem("cart", JSON.stringify(cart));
    loadCart(); // Recargar el carrito
}

// Función para vaciar el carrito y simular la compra
function buyCart() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];

    if (cart.length === 0) {
        alert("Tu carrito está vacío. No puedes realizar una compra.");
        return;
    }

    // Preparar datos de la compra
    const purchaseData = {
        products: cart,
        totalAmount: document.getElementById("total-general").textContent.replace('Total: $', ''),
        date: new Date().toISOString(),
    };

    console.log("Compra realizada:", purchaseData);

    // Vaciar el carrito
    localStorage.removeItem("cart");
    alert("¡Compra realizada con éxito!");
    window.location.href = "index.html"; // Redirigir al inicio
}

// Añadir el evento al botón de "Comprar"
document.getElementById("buyButton").addEventListener("click", buyCart);

// Cargar los productos al cargar la página
document.addEventListener("DOMContentLoaded", loadCart);
// Función para regresar a la página de inicio
function goBackToHome() {
    window.location.href = "iisstart.htm"; // Cambia el enlace según tu estructura
}

// Añadir el evento al botón de "Regresar"
document.getElementById("backButton").addEventListener("click", goBackToHome);

// Elementos del DOM
const carritoTabla = document.querySelector("#carrito tbody");
const totalGeneral = document.getElementById("total-general");

// Cargar productos del localStorage
function cargarCarrito() {
    const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
    carritoTabla.innerHTML = ""; // Limpiar tabla antes de renderizar
    let total = 0;

    carrito.forEach((producto, index) => {
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${producto.nombre}</td>
            <td>${producto.precio}</td>
            <td>
                <input type="number" min="1" value="${producto.cantidad}" data-index="${index}" class="cantidad-input">
            </td>
            <td>${(producto.precio * producto.cantidad).toFixed(2)}</td>
            <td>
                <button class="eliminar-btn" data-index="${index}">Eliminar</button>
            </td>
        `;

        carritoTabla.appendChild(fila);
        total += producto.precio * producto.cantidad;
    });

    totalGeneral.textContent = `Total: $${total.toFixed(2)}`;
}

// Actualizar cantidad de un producto
carritoTabla.addEventListener("input", (e) => {
    if (e.target.classList.contains("cantidad-input")) {
        const index = e.target.getAttribute("data-index");
        const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
        carrito[index].cantidad = parseInt(e.target.value, 10) || 1;
        localStorage.setItem("carrito", JSON.stringify(carrito));
        cargarCarrito(); // Recargar tabla
    }
});

// Eliminar un producto del carrito
carritoTabla.addEventListener("click", (e) => {
    if (e.target.classList.contains("eliminar-btn")) {
        const index = e.target.getAttribute("data-index");
        const carrito = JSON.parse(localStorage.getItem("carrito")) || [];
        carrito.splice(index, 1); // Eliminar producto
        localStorage.setItem("carrito", JSON.stringify(carrito));
        cargarCarrito(); // Recargar tabla
    }
});

// Inicializar carrito al cargar la página
document.addEventListener("DOMContentLoaded", cargarCarrito);

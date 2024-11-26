// Detección del tipo de tarjeta
function detectCardType() {
  const cardNumber = document.getElementById("card-number").value;
  const cardLogo = document.getElementById("card-logo");

  if (/^4/.test(cardNumber)) {
      cardLogo.src = "/PagosPug/iconos_tarjetas/Visa.png"; // Ruta al logo de Visa
      cardLogo.alt = "Visa";
  } else if (/^5[1-5]/.test(cardNumber)) {
      cardLogo.src = "/PagosPug/iconos_tarjetas/mastercard.png"; // Ruta al logo de MasterCard
      cardLogo.alt = "MasterCard";
  } else if (/^3[47]/.test(cardNumber)) {
      cardLogo.src = "/PagosPug/iconos_tarjetas/amex.png"; // Ruta al logo de American Express
      cardLogo.alt = "American Express";
  } else {
      cardLogo.src = ""; // Sin logo
      cardLogo.alt = "";
  }
}
// Función para obtener el carrito desde localStorage
function getCart() {
    const cart = localStorage.getItem('cart');
    return cart ? JSON.parse(cart) : [];
}

// Función para calcular el total del carrito
function calculateTotal(cart) {
    return cart.reduce((total, item) => total + item.price * item.quantity, 0);
}

// Cargar el total en el área de pago
function loadTotalAmount() {
    const cart = getCart();
    const total = calculateTotal(cart);
    const totalPaymentInput = document.getElementById('total-payment');
    totalPaymentInput.value = `$${total.toFixed(2)}`;
}

// Procesar el pago
function processPayment() {
    const cart = getCart();
    const total = calculateTotal(cart);

    const cardNumber = document.getElementById("card-number").value.trim();
    const cardholderName = document.getElementById("cardholder-name").value.trim();
    const expirationDate = document.getElementById("expiration-date").value.trim();
    const cvv = document.getElementById("cvv").value.trim();
    const billingAddress = document.getElementById("billing-address").value.trim();

    // Validar campos
    if (!cardNumber || cardNumber.length < 16) {
        alert("Por favor, ingrese un número de tarjeta válido.");
        return;
    }
    if (!cardholderName) {
        alert("Por favor, ingrese el nombre del titular.");
        return;
    }
    if (!expirationDate) {
        alert("Por favor, seleccione una fecha de expiración.");
        return;
    }
    if (!cvv || cvv.length !== 3) {
        alert("Por favor, ingrese un CVV válido.");
        return;
    }
    if (!billingAddress) {
        alert("Por favor, ingrese una dirección de facturación.");
        return;
    }

    // Simulación de éxito
    alert(`¡Pago de $${total.toFixed(2)} procesado con éxito!`);
}

// Cargar el total al cargar la página
window.onload = loadTotalAmount;

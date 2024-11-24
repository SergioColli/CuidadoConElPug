// script.js

// script.js

function detectCardType() {
  const cardInput = document.getElementById("card-number");
  const cardLogo = document.getElementById("card-logo");
  const cardNumber = cardInput.value;

  // Regex para detectar el tipo de tarjeta
  const visaRegex = /^4[0-9]{0,15}$/; // Visa comienza con 4
  const masterCardRegex = /^5[1-5][0-9]{0,14}$/; // Mastercard comienza con 51-55
  const amexRegex = /^3[47][0-9]{0,13}$/; // American Express comienza con 34 o 37
  const discoverRegex = /^6(?:011|5[0-9]{2})[0-9]{0,12}$/; // Discover comienza con 6011 o 65

  if (visaRegex.test(cardNumber)) {
    cardLogo.src = "../iconos_tarjetas/Visa.png";
    cardLogo.style.display = "inline";
  } else if (masterCardRegex.test(cardNumber)) {
    cardLogo.src = "../iconos_tarjetas/mastercard.png";
    cardLogo.style.display = "inline";
  } else if (amexRegex.test(cardNumber)) {
    cardLogo.src = "../iconos_tarjetas/americanexpress.png";
    cardLogo.style.display = "inline";
  } else if (discoverRegex.test(cardNumber)) {
    cardLogo.src = "../iconos_tarjetas/discover.png";
    cardLogo.style.display = "inline";
  } else if (cardNumber.length > 0) {
    // Si no es reconocida pero se ingresan números
    cardLogo.src = "../iconos_tarjetas/generico.jpg";
    cardLogo.style.display = "inline";
  } else {
    cardLogo.style.display = "none"; // Oculta el logo si no hay entrada
  }
}

function processPayment() {
  const cardNumber = document.getElementById("card-number").value;
  const cardholderName = document.getElementById("cardholder-name").value;
  const expirationDate = document.getElementById("expiration-date").value;
  const cvv = document.getElementById("cvv").value;
  const billingAddress = document.getElementById("billing-address").value;

  if (!cardNumber || !cardholderName || !expirationDate || !cvv || !billingAddress) {
    alert("Por favor, completa todos los campos.");
    return;
  }

  alert("¡Pago procesado con éxito!");
}

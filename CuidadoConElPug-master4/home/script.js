// Filtrar productos en función de los criterios seleccionados
function filterProducts() {
  const genderFilter = document.getElementById("gender").value.toLowerCase();
  const sizeFilter = document.getElementById("size").value.toLowerCase();
  const typeFilter = document.getElementById("type").value.toLowerCase();
  const products = document.querySelectorAll(".product");

  products.forEach((product) => {
    const productGender = product.getAttribute("data-gender").toLowerCase();
    const productSize = product.getAttribute("data-size").toLowerCase();
    const productType = product.getAttribute("data-type").toLowerCase();

    const matchesGender = !genderFilter || productGender === genderFilter;
    const matchesSize = !sizeFilter || productSize === sizeFilter;
    const matchesType = !typeFilter || productType.includes(typeFilter);

    product.style.display = matchesGender && matchesSize && matchesType ? "block" : "none";
  });
}

// Función para buscar productos por nombre
function searchProducts() {
  const searchInput = document.getElementById("searchInput").value.toLowerCase();
  const products = document.querySelectorAll(".product");

  products.forEach((product) => {
    const productName = product.getAttribute("data-name").toLowerCase();
    product.style.display = productName.includes(searchInput) ? "block" : "none";
  });
}

// Función para eliminar un producto
function eliminarProducto(button) {
  // Selecciona la tarjeta del producto
  const productCard = button.parentElement;

  // Obtén el nombre del producto
  const productName = productCard.getAttribute("data-name");

  // Elimina el producto del DOM
  productCard.remove();

  // Actualiza el almacenamiento local
  let products = JSON.parse(localStorage.getItem("products")) || [];
  products = products.filter(product => product.name !== productName);
  localStorage.setItem("products", JSON.stringify(products));

  alert("Producto eliminado correctamente.");
}

// Función para mostrar la vista previa de la imagen seleccionada
function previewImage(event) {
  const imagePreview = document.getElementById("imagePreview");
  const file = event.target.files[0];

  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imagePreview.src = e.target.result;
      imagePreview.style.display = "block";
    };
    reader.readAsDataURL(file);
  } else {
    imagePreview.style.display = "none";
  }
}

// Añadir un nuevo producto al almacenamiento local
function addProduct(event) {
  event.preventDefault();

  const name = document.getElementById("name").value;
  const gender = document.getElementById("gender").value;
  const size = document.getElementById("size").value;
  const type = document.getElementById("type").value;
  const price = document.getElementById("price").value;
  const imageFile = document.getElementById("productImage").files[0];
  let imageSrc = "default-image.jpg";

  if (imageFile) {
    const reader = new FileReader();
    reader.onload = function(e) {
      imageSrc = e.target.result;
      saveProduct({ name, gender, size, type, price, image: imageSrc });
    };
    reader.readAsDataURL(imageFile);
  } else {
    saveProduct({ name, gender, size, type, price, image: imageSrc });
  }
}

// Guardar el producto en el almacenamiento local
function saveProduct(product) {
  const products = JSON.parse(localStorage.getItem("products")) || [];
  products.push(product);
  localStorage.setItem("products", JSON.stringify(products));
  alert("Producto añadido correctamente!");
  window.location.href = "iisstart.htm";
}

// Cargar productos desde localStorage en el catálogo
function loadProducts() {
  const products = JSON.parse(localStorage.getItem("products")) || [];
  const catalog = document.querySelector(".catalog");

  catalog.innerHTML = "";

  products.forEach(product => {
    const productCard = document.createElement("div");
    productCard.classList.add("product");
    productCard.setAttribute("data-name", product.name);
    productCard.setAttribute("data-gender", product.gender);
    productCard.setAttribute("data-size", product.size);
    productCard.setAttribute("data-type", product.type);

    productCard.innerHTML = `
      <img src="${product.image}" alt="${product.name}">
      <h4>${product.name}</h4>
      <p>Talla: ${product.size}</p>
      <p>Precio: $${product.price}</p>
      <button onclick="eliminarProducto(this)" class="delete-button">Eliminar</button>
    `;
    catalog.appendChild(productCard);
  });
}

// Cargar productos en el catálogo al cargar la página
if (window.location.pathname.endsWith("iisstart.htm")) {
  document.addEventListener("DOMContentLoaded", loadProducts);
}



function showSubcategories(category) {
  const subcategories = {
      mujer: ["Ofertas -30%", "Playeras", "Jeans", "Sudaderas y Suéteres", "Chamarras y Chalecos", "Pantalones", "Camisas", "Zapatos"],
      hombre: ["Ofertas -30%", "Playeras", "Jeans", "Sudaderas y Suéteres", "Chamarras y Chalecos", "Pantalones", "Camisas", "Bermudas"],
      niños: ["Playeras", "Jeans", "Pijamas", "Chamarras", "Zapatos"]
  };

  const subcategoryList = document.getElementById("subcategory-list");
  subcategoryList.innerHTML = subcategories[category].map(item => `<button class="subcategory-btn">${item}</button>`).join("");
  document.getElementById("subcategories").classList.remove("hidden");
}

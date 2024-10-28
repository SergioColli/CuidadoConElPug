const products = [];

function addProduct() {
    // Obtener valores de los campos
    const name = document.getElementById('product-name').value;
    const price = document.getElementById('product-price').value;
    const description = document.getElementById('product-description').value;

    // Verificar que todos los campos estén llenos
    if (name === '' || price === '' || description === '') {
        alert('Por favor complete todos los campos');
        return;
    }

    // Crear un nuevo producto
    const product = {
        name: name,
        price: price,
        description: description
    };

    // Agregar el producto a la lista de productos
    products.push(product);

    // Limpiar los campos
    document.getElementById('product-name').value = '';
    document.getElementById('product-price').value = '';
    document.getElementById('product-description').value = '';

    // Actualizar la lista de productos
    displayProducts();
}

function displayProducts() {
    const productList = document.getElementById('product-list');
    productList.innerHTML = ''; // Limpiar la lista

    // Recorrer los productos y mostrarlos en la interfaz
    products.forEach((product, index) => {
        const productDiv = document.createElement('div');
        productDiv.classList.add('product');

        productDiv.innerHTML = `
            <h3>${product.name}</h3>
            <p>Precio: $${product.price}</p>
            <p>${product.description}</p>
            <button onclick="buyProduct(${index})">Comprar</button>
        `;

        productList.appendChild(productDiv);
    });
}

function buyProduct(index) {
    const product = products[index];
    alert(`Has comprado: ${product.name} por $${product.price}`);
}

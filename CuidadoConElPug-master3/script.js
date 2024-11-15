const products = [];

function addProduct() {
    const name = document.getElementById('product-name').value;
    const price = document.getElementById('product-price').value;
    const description = document.getElementById('product-description').value;
    const image = document.getElementById('product-image').value;

    if (name === '' || price === '' || description === '' || image === '') {
        alert('Por favor complete todos los campos');
        return;
    }

    const product = {
        name: name,
        price: price,
        description: description,
        image: image
    };

    products.push(product);
    clearFields();
    displayProducts();
}

function clearFields() {
    document.getElementById('product-name').value = '';
    document.getElementById('product-price').value = '';
    document.getElementById('product-description').value = '';
    document.getElementById('product-image').value = '';
}

function displayProducts() {
    const productList = document.getElementById('product-list');
    productList.innerHTML = '';

    products.forEach((product, index) => {
        const productDiv = document.createElement('div');
        productDiv.classList.add('product');

        productDiv.innerHTML = `
            <h3>${product.name}</h3>
            <p>Precio: $${product.price}</p>
            <p>${product.description}</p>
            <img src="${product.image}" alt="${product.name}" style="width: 100px;">
            <button onclick="removeProduct(${index})">Quitar</button>
        `;

        productList.appendChild(productDiv);
    });
}

function removeProduct(index) {
    products.splice(index, 1);
    displayProducts();
}

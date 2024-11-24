// Asegurarse de que el DOM está cargado antes de ejecutar el código
document.addEventListener('DOMContentLoaded', () => {
    const products = document.querySelectorAll('.product');
  
    // Definir la función de filtro de productos
    function filterProducts() {
      // Obtener los valores seleccionados en los filtros
      const gender = document.getElementById('gender').value.toLowerCase();
      const size = document.getElementById('size').value.toLowerCase();
      const type = document.getElementById('type').value.toLowerCase();
    
      // Filtrar los productos
      products.forEach(product => {
        // Leer los atributos del producto
        const productGender = product.getAttribute('data-gender');
        const productSize = product.getAttribute('data-size');
        const productType = product.getAttribute('data-type');
    
        // Comparar con los filtros seleccionados
        const matchesGender = !gender || productGender === gender;
        const matchesSize = !size || productSize === size;
        const matchesType = !type || productType === type;
    
        // Mostrar u ocultar el producto según los filtros
        if (matchesGender && matchesSize && matchesType) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
    }
  
    // Exponer la función al objeto window para que sea global
    window.filterProducts = filterProducts;
  
    // Definir la función de búsqueda de productos
    window.searchProducts = function () {
      const searchValue = document.getElementById('searchInput').value.toLowerCase();
  
      products.forEach((product) => {
        const productName = product.querySelector('h3').textContent.toLowerCase();
  
        if (productName.includes(searchValue)) {
          product.style.display = 'block';
        } else {
          product.style.display = 'none';
        }
      });
    };
  });
  

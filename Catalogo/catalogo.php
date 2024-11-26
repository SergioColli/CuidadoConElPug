<!DOCTYPE html>
<html lang="es">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="EstiloP.css">
   <title>Cuidado Con El Puc</title>	
   <link rel="icon" href="pugsito.ico">
</head>
<body>
    <header>
        <a class="pugsito2" href="/home/">
            <img src="pugsito.png" alt="pugsitoimg">
            <h3>Cuidado Con El Puc</h3>
        </a>
        <nav>
            <a href="/home/" class="nav-link">Inicio</a>
            <a href="/Nosotros/" class="nav-link">Sobre Nosotros</a>
            <a href="https://www.facebook.com/luisenrique.pucbarajas.5" class="nav-link">Contacto</a>
            <a href="/Iniciarsexcion/inicio-sesion.html" class="nav-link">Empezar</a>
        </nav>
    </header>
   
    <div class="Carro">
        <button id="viewCartButton">
            <img src="/Carrito.png" alt="Carro">
            <span id="cartCount">0</span>
        </button>
    </div>

    <div class="add-product">
        <a href="/SubirProductos/añadir.html" class="add-product-btn">Añadir Nuevo Producto</a>
    </div>

    <h1>Catálogo de Productos</h1>

    <!-- Filtros de búsqueda -->
    <div class="filters">
        <label for="gender">Sexo:</label>
        <select id="gender" onchange="filterProducts()">
            <option value="">Todos</option>
            <option value="hombre">Hombre</option>
            <option value="mujer">Mujer</option>
        </select>

        <label for="size">Talla:</label>
        <select id="size" onchange="filterProducts()">
            <option value="">Todas</option>
            <option value="S">S</option>
            <option value="M">M</option>
            <option value="L">L</option>
            <option value="XL">XL</option>
        </select>

        <label for="type">Tipo:</label>
        <select id="type" onchange="filterProducts()">
            <option value="">Todos</option>
            <option value="jeans">Jeans</option>
            <option value="pantalones">Pantalones</option>
            <option value="camisas">Camisas</option>
            <option value="boxers">Boxers</option>
            <option value="chaquetas">Chaquetas</option>
            <option value="pijamas">Pijamas</option>
            <option value="trajes">Trajes</option>
            <option value="vestidos">Vestidos</option>
        </select>

        <label for="searchInput">Buscar:</label>
        <input type="text" id="searchInput" oninput="filterProducts()" placeholder="Buscar por nombre">
    </div>

    <!-- Catálogo de productos -->
    <div class="catalog">
        <?php
        include 'db.php'; // Conexión a la base de datos

        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product' 
                         data-id='" . $row['id'] . "' 
                         data-name='" . htmlspecialchars($row['nombre'], ENT_QUOTES) . "' 
                         data-price='" . $row['precio'] . "' 
                         data-gender='" . strtolower($row['sexo']) . "' 
                         data-size='" . strtolower($row['talla']) . "' 
                         data-type='" . strtolower($row['tipo']) . "'>
                        <img src='/SubirProductos/imagenes/" . basename($row['imagen']) . "' alt='" . htmlspecialchars($row['nombre'], ENT_QUOTES) . "'>
                        <h3>" . htmlspecialchars($row['nombre']) . "</h3>
                        <p>Precio: $" . $row['precio'] . "</p>
                        <button class='add-to-cart-btn'>Añadir al Carrito</button>
                      </div>";
            }
        } else {
            echo "<p>No hay productos disponibles en este momento.</p>";
        }

        $conn->close();
        ?>
    </div>

    <!-- Carrito -->
    <div id="cartModal" style="display: none;">
        <h2>Carrito de Compras</h2>
        <table id="cartTable">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Se llena dinámicamente con JavaScript -->
            </tbody>
        </table>
        <h3 id="cartTotal">Total: $0</h3>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <button class="close-cart" onclick="closeCart()">Cerrar</button>
            <button class="pay-btn" onclick="redirectToPayment()">Pagar</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="Filtros.js"></script> <!-- Tu script de filtros -->
    <script src="carrito.js"></script> <!-- Script del carrito -->
</body>
</html>

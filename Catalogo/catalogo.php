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
        <button id="myButton1">
            <img src="Carrito.png" alt="Carro">
        </button>
    </div>

    <h2>PROXIMAMENTE</h2>
    <a href="/Catalogo/">Ir al Catálogo</a>

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
        <input type="text" id="searchInput" oninput="searchProducts()" placeholder="Buscar por nombre">
    </div>

    <!-- Enlace a la página para añadir productos -->
    <a href="/SubirProductos/añadir.html" class="add-product-btn">Añadir Nuevo Producto</a>

  <!-- Catálogo de productos -->
<div class="catalog">
  <?php
  include 'db.php'; // Conexión a la base de datos

  $sql = "SELECT * FROM productos";
  $result = $conn->query($sql);

  if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "<div class='product' data-gender='" . strtolower($row['sexo']) . "' data-size='" . strtolower($row['talla']) . "' data-type='" . strtolower($row['tipo']) . "'>";
      echo "<img src='/SubirProductos/imagenes/" . basename($row['imagen']) . "' alt='" . $row['nombre'] . "'>";
      echo "<h3>" . $row['nombre'] . "</h3>";
      echo "<p>Precio: $" . $row['precio'] . "</p>";
      echo "<button class='add-to-cart-btn'>Añadir al Carrito</button>";
      echo "</div>";
    }
  } else {
    echo "<p>No hay productos disponibles en este momento.</p>";
  }

  $conn->close();
  ?>
</div>

    <script src="Filtros.js"></script>
</body>
</html>
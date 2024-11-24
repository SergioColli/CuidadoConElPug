<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir conexión a la base de datos
include 'db.php';

try {
    // Verificar método de solicitud
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de solicitud no permitido.");
    }

    // Capturar datos del formulario
    $nombre = $_POST['name'] ?? null;
    $sexo = $_POST['gender'] ?? null;
    $talla = $_POST['size'] ?? null;
    $tipo = $_POST['type'] ?? null;
    $precio = $_POST['price'] ?? null;

    // Validar campos obligatorios
    if (!$nombre || !$sexo || !$talla || !$tipo || !$precio) {
        throw new Exception("Faltan campos obligatorios en el formulario.");
    }

    // Validar imagen
    if (!isset($_FILES['productImage']) || $_FILES['productImage']['error'] !== 0) {
        throw new Exception("Error al subir la imagen.");
    }

    // Procesar la imagen
    $target_dir = "imagenes/";
    if (!is_dir($target_dir)) {
        throw new Exception("La carpeta 'imagenes/' no existe.");
    }

    $target_file = $target_dir . basename($_FILES['productImage']['name']);
    if (!move_uploaded_file($_FILES['productImage']['tmp_name'], $target_file)) {
        throw new Exception("Error al mover la imagen a la carpeta 'imagenes/'.");
    }

    // Insertar datos en la base de datos
    $sql = "INSERT INTO productos (nombre, sexo, talla, tipo, precio, imagen)
            VALUES ('$nombre', '$sexo', '$talla', '$tipo', '$precio', '$target_file')";

    if (!$conn->query($sql)) {
        throw new Exception("Error al guardar en la base de datos: " . $conn->error);
    }

    echo "Producto añadido correctamente. <a href='/home/index.php'>Ver catálogo</a>";

} catch (Exception $e) {
    // Mostrar mensaje de error
    echo "Se produjo un error: " . $e->getMessage();
}

$conn->close();
?>


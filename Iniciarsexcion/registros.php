<?php
include 'db.php'; // Incluir la conexión a la base de datos 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Encriptar la contraseña

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
        alert('Usuario registrado con éxito');
        window.location.href = 'inicio-sesion.html';
      </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Cerrar la conexión
}
?>

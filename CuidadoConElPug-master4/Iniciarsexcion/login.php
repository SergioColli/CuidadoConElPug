<?php
session_start(); // Inicia la sesión al comienzo
include 'db.php'; // Incluir la conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar si el email existe usando consultas preparadas
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // 's' significa tipo string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Guardar el usuario en la sesión
            $_SESSION['usuario_id'] = $user['id']; // Almacena el ID del usuario en la sesión
            $_SESSION['usuario_email'] = $user['email']; // Almacena el email del usuario en la sesión

            // Redirigir a la página deseada
            header("Location: /perfil/perfil.html");
            exit(); 
        } else {
            echo "<script>alert('Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('No existe una cuenta con este correo');</script>";
    }

    $stmt->close(); // Cierra el statement
}
$conn->close(); // Cierra la conexión
?>

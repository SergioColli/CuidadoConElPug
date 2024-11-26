<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de la conexión a la base de datos
$servername = "database-1.choesk2e6xa8.us-east-2.rds.amazonaws.com";
$username = "OmarROA";
$password = "Pelana78123";
$dbname = "registros";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener las tablas disponibles
$tablas = ['poliza', 'usuarios', 'deducible'];

// Inicializar variables
$tabla1 = isset($_POST['tabla1']) ? $_POST['tabla1'] : '';
$tabla2 = isset($_POST['tabla2']) ? $_POST['tabla2'] : '';
$campos1 = [];
$campos2 = [];
$tabla_creada = '';
$estructura_tabla_creada = [];

// Cargar los campos de la primera tabla seleccionada
if (!empty($tabla1)) {
    $sql = "DESCRIBE $tabla1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $campos1[] = $row['Field'];
        }
    }
}

// Cargar los campos de la segunda tabla seleccionada
if (!empty($tabla2)) {
    $sql = "DESCRIBE $tabla2";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $campos2[] = $row['Field'];
        }
    }
}

// Crear una nueva tabla combinada (si se envió el formulario)
if (isset($_POST['crear_tabla']) && !empty($_POST['nombre_tabla']) && (!empty($_POST['campos_tabla1']) || !empty($_POST['campos_tabla2']))) {
    $nombre_tabla = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['nombre_tabla']);
    $campos_tabla1 = isset($_POST['campos_tabla1']) ? $_POST['campos_tabla1'] : [];
    $campos_tabla2 = isset($_POST['campos_tabla2']) ? $_POST['campos_tabla2'] : [];

    $sql_crear = "CREATE TABLE $nombre_tabla (";

    // Agregar los campos seleccionados de la primera tabla
    foreach ($campos_tabla1 as $campo) {
        $sql_tipo = "DESCRIBE $tabla1";
        $result_tipo = $conn->query($sql_tipo);
        while ($fila_tipo = $result_tipo->fetch_assoc()) {
            if ($fila_tipo['Field'] == $campo) {
                $tipo = $fila_tipo['Type'];
                $sql_crear .= "$campo $tipo, ";
            }
        }
    }

    // Agregar los campos seleccionados de la segunda tabla
    foreach ($campos_tabla2 as $campo) {
        $sql_tipo = "DESCRIBE $tabla2";
        $result_tipo = $conn->query($sql_tipo);
        while ($fila_tipo = $result_tipo->fetch_assoc()) {
            if ($fila_tipo['Field'] == $campo) {
                $tipo = $fila_tipo['Type'];
                $sql_crear .= "$campo $tipo, ";
            }
        }
    }

    $sql_crear = rtrim($sql_crear, ', ') . ') ENGINE=InnoDB;';

    // Crear la tabla
    if ($conn->query($sql_crear)) {
        $tabla_creada = $nombre_tabla;
        $mensaje = "Tabla '$nombre_tabla' creada exitosamente.";

        // Obtener la estructura de la tabla recién creada
        $sql_estructura = "DESCRIBE $tabla_creada";
        $result_estructura = $conn->query($sql_estructura);
        if ($result_estructura && $result_estructura->num_rows > 0) {
            while ($row = $result_estructura->fetch_assoc()) {
                $estructura_tabla_creada[] = $row;
            }
        }
    } else {
        $mensaje = "Error al crear la tabla: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combinar Tablas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4faff;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            background-color: #0078D7;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        table th {
            background-color: #0078D7;
            color: white;
        }
        button {
            background-color: #0078D7;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Combinar Tablas</h1>
</div>

<div class="container">
    <!-- Mostrar mensaje -->
    <?php if (isset($mensaje)): ?>
        <div class="box">
            <strong><?php echo $mensaje; ?></strong>
        </div>
    <?php endif; ?>

    <!-- Selección de tablas base -->
    <div class="box">
        <h3>Seleccionar Tablas Base</h3>
        <form method="POST" action="">
            <label for="tabla1">Primera Tabla:</label>
            <select name="tabla1" id="tabla1" onchange="this.form.submit()">
                <option value="">Seleccione una tabla</option>
                <?php foreach ($tablas as $tabla): ?>
                    <option value="<?php echo $tabla; ?>" <?php echo $tabla1 == $tabla ? 'selected' : ''; ?>>
                        <?php echo ucfirst($tabla); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="tabla2">Segunda Tabla:</label>
            <select name="tabla2" id="tabla2" onchange="this.form.submit()">
                <option value="">Seleccione una tabla</option>
                <?php foreach ($tablas as $tabla): ?>
                    <option value="<?php echo $tabla; ?>" <?php echo $tabla2 == $tabla ? 'selected' : ''; ?>>
                        <?php echo ucfirst($tabla); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <!-- Mostrar la tabla recién creada -->
    <?php if (!empty($estructura_tabla_creada)): ?>
        <div class="box">
            <h3>Estructura de la Tabla: <?php echo ucfirst($tabla_creada); ?></h3>
            <table>
                <thead>
                    <tr>
                        <th>Campo</th>
                        <th>Tipo</th>
                        <th>Nulo</th>
                        <th>Clave</th>
                        <th>Por Defecto</th>
                        <th>Extras</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estructura_tabla_creada as $fila): ?>
                        <tr>
                            <td><?php echo $fila['Field']; ?></td>
                            <td><?php echo $fila['Type']; ?></td>
                            <td><?php echo $fila['Null']; ?></td>
                            <td><?php echo $fila['Key']; ?></td>
                            <td><?php echo $fila['Default']; ?></td>
                            <td><?php echo $fila['Extra']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>


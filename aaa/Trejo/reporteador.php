<?php
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

// Determinar qué tabla mostrar
$tabla_seleccionada = isset($_GET['tabla']) ? $_GET['tabla'] : 'poliza';
$filtro_columna = isset($_POST['columna']) ? $_POST['columna'] : '';
$filtro_valor = isset($_POST['valor']) ? $_POST['valor'] : '';
$filtro_operador = isset($_POST['operador']) ? $_POST['operador'] : '';

// Construir consulta SQL dinámica
if ($tabla_seleccionada == 'poliza') {
    $sql = "SELECT id_poliza AS ID, id_cliente AS Cliente, fecha_inicio AS Inicio, fecha_final AS Final FROM poliza";
} elseif ($tabla_seleccionada == 'usuarios') {
    $sql = "SELECT id AS ID, nombre AS Nombre, email AS Email, fecha_registro AS Registro FROM usuarios";
} elseif ($tabla_seleccionada == 'deducible') {
    $sql = "SELECT id_deducible AS ID, descripcion AS Descripción, monto AS Monto FROM deducible";
}

// Agregar filtros a la consulta si se seleccionaron
if (!empty($filtro_columna) && !empty($filtro_valor)) {
    $operador_sql = ($filtro_operador == 'igual') ? '=' : (($filtro_operador == 'no_igual') ? '<>' : 'LIKE');
    $filtro_valor = $operador_sql == 'LIKE' ? "%$filtro_valor%" : $filtro_valor;
    $sql .= " WHERE $filtro_columna $operador_sql '$filtro_valor'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aseguradora de Autos</title>
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
        .content {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .box {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            min-width: 300px;
        }
        .box h3 {
            color: #0078D7;
            margin-bottom: 15px;
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
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .form-container select, .form-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .form-container button {
            background-color: #0078D7;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .form-container button:hover {
            background-color: #005bb5;
        }
        .link {
            text-decoration: none;
            color: #0078D7;
            font-weight: bold;
        }
        .link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>Aseguradora de Autos</h1>
</div>

<div class="content">
    <!-- Columna 1: Tablas disponibles -->
    <div class="box">
        <h3>Tablas</h3>
        <ul>
            <li><a href="?tabla=poliza" class="link">Póliza</a></li>
            <li><a href="?tabla=usuarios" class="link">Usuarios</a></li>
        </ul>
    </div>

    <!-- Columna 2: Información sobre la tabla -->
    <div class="box">
        <h3>Tabla <?php echo ucfirst($tabla_seleccionada); ?></h3>
        <table>
            <thead>
                <tr>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        foreach ($row as $columna => $valor) {
                            echo "<th>" . htmlspecialchars($columna) . "</th>";
                        }
                        $result->data_seek(0);
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        foreach ($row as $valor) {
                            echo "<td>" . htmlspecialchars($valor) . "</td>";
                        }
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay registros disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Columna 3: Filtros -->
    <div class="box">
        <h3>Filtro Numérico</h3>
        <form method="POST" action="?tabla=<?php echo $tabla_seleccionada; ?>">
            <label for="columna">Columna:</label>
            <select name="columna" id="columna">
                <?php
                if ($tabla_seleccionada == 'poliza') {
                    echo '<option value="id_poliza">ID Póliza</option>';
                    echo '<option value="id_cliente">ID Cliente</option>';
                    echo '<option value="fecha_inicio">Fecha Inicio</option>';
                    echo '<option value="fecha_final">Fecha Final</option>';
                } elseif ($tabla_seleccionada == 'usuarios') {
                    echo '<option value="id">ID</option>';
                    echo '<option value="nombre">Nombre</option>';
                    echo '<option value="email">Email</option>';
                    echo '<option value="fecha_registro">Fecha Registro</option>';
                } elseif ($tabla_seleccionada == 'deducible') {
                    echo '<option value="id_deducible">ID</option>';
                    echo '<option value="descripcion">Descripción</option>';
                    echo '<option value="monto">Monto</option>';
                }
                ?>
            </select>
            <label for="operador">Operador:</label>
            <select name="operador" id="operador">
                <option value="igual">Igual a</option>
                <option value="no_igual">No igual a</option>
                <option value="like">Contiene</option>
            </select>
            <input type="text" name="valor" placeholder="Ingrese valor" value="<?php echo htmlspecialchars($filtro_valor); ?>">
            <button type="submit">Filtrar</button>
        </form>
    </div>
</div>

</body>
</html>

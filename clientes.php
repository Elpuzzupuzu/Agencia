<?php
// Procesamiento del formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    $servername = "localhost";
    $username = "root";
    $password = "1234"; // Cambia esto si tienes una contraseña para tu servidor MySQL
    $dbname = "agencia";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    switch ($accion) {
        case 'insertar':
            // Proceso de inserción de cliente
            // Código existente para insertar un cliente
            break;

        case 'buscar':
            // Proceso de búsqueda de cliente
            // Código existente para buscar un cliente por ID
            break;

        case 'eliminar':
            // Proceso de eliminación de cliente
            // Código existente para eliminar un cliente por ID
            break;

        case 'desencriptar':
            // Proceso de desencriptación de datos de clientes
            $sql = "CALL sp_desencriptar_datos()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<h2>Clientes Desencriptados</h2>';
                echo '<table border="1">';
                echo '<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Teléfono</th><th>Celular</th><th>Correo</th><th>Dirección</th><th>Identificación</th></tr>';
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["nombre_desencriptado"] . '</td>';
                    echo '<td>' . $row["apellido_desencriptado"] . '</td>';
                    echo '<td>' . $row["telefono_desencriptado"] . '</td>';
                    echo '<td>' . $row["celular_desencriptado"] . '</td>';
                    echo '<td>' . $row["correo_desencriptado"] . '</td>';
                    echo '<td>' . $row["direccion_desencriptado"] . '</td>';
                    echo '<td>' . $row["identificacion_desencriptado"] . '</td>';
                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo "0 resultados";
            }
            break;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div id="clienteForm">
        <h1>Gestión de Clientes</h1>
        <form method="POST" action="clientes.php">
            <label for="accion">Acción:</label>
            <select name="accion" id="accion">
                <option value="insertar">Insertar Cliente</option>
                <option value="buscar">Buscar Cliente</option>
                <option value="eliminar">Eliminar Cliente</option>
                <option value="desencriptar">Desencriptar Clientes</option>
            </select>

            <div id="form-insertar" class="form-section">
                <h2>Insertar Cliente</h2>
                <!-- Campos de inserción de cliente -->
            </div>

            <div id="form-buscar-eliminar" class="form-section">
                <h2>Buscar/Eliminar Cliente</h2>
                <!-- Campos de búsqueda/eliminación de cliente -->
            </div>

            <button type="submit">Enviar</button>
        </form>
    </div>

    <script>
        document.getElementById('accion').addEventListener('change', function () {
            var action = this.value;
            document.getElementById('form-insertar').style.display = action === 'insertar' ? 'block' : 'none';
            document.getElementById('form-buscar-eliminar').style.display = (action === 'buscar' || action === 'eliminar') ? 'block' : 'none';
        });

        // Inicialización para mostrar el formulario correcto al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            var action = document.getElementById('accion').value;
            document.getElementById('form-insertar').style.display = action === 'insertar' ? 'block' : 'none';
            document.getElementById('form-buscar-eliminar').style.display = (action === 'buscar' || action === 'eliminar') ? 'block' : 'none';
        });
    </script>
</body>
</html>

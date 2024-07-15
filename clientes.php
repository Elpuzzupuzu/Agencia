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
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $celular = $_POST['celular'];
            $correo = $_POST['correo'];
            $direccion = $_POST['direccion'];
            $identificacion = $_POST['identificacion'];

            $sql = "CALL sp_insertar_cliente(?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $nombre, $apellido, $telefono, $celular, $correo, $direccion, $identificacion);
            $stmt->execute();
            $stmt->close();

            echo "Cliente insertado correctamente.";
            break;

        case 'buscar':
            $id_cliente = $_POST['id_cliente'];

            $sql = "CALL sp_buscar_cliente_por_id(?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_cliente);
            $stmt->execute();
            $result = $stmt->get_result();
            $cliente = $result->fetch_assoc();
            $stmt->close();

            if ($cliente) {
                echo "Cliente encontrado: " . json_encode($cliente);
            } else {
                echo "Cliente no encontrado.";
            }
            break;

        case 'eliminar':
            $id_cliente = $_POST['id_cliente'];

            $sql = "CALL sp_eliminar_cliente(?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_cliente);
            $stmt->execute();
            $stmt->close();

            echo "Cliente eliminado correctamente.";
            break;

        case 'desencriptar':
            $sql = "CALL sp_desencriptar_datos()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre_desencriptado"] . " " . $row["apellido_desencriptado"] . 
                        " - Teléfono: " . $row["telefono_desencriptado"] . 
                        " - Celular: " . $row["celular_desencriptado"] . 
                        " - Correo: " . $row["correo_desencriptado"] . 
                        " - Dirección: " . $row["direccion_desencriptado"] . 
                        " - Identificación: " . $row["identificacion_desencriptado"] . "<br>";
                }
            } else {
                echo "0 resultados";
            }
            break;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
</head>
<body>
    <h1>Gestión de Clientes</h1>
    <form method="POST" action="clientes.php">
        <label for="accion">Acción:</label>
        <select name="accion" id="accion">
            <option value="insertar">Insertar Cliente</option>
            <option value="buscar">Buscar Cliente</option>
            <option value="eliminar">Eliminar Cliente</option>
            <option value="desencriptar">Desencriptar Clientes</option>
        </select>

        <div id="form-insertar" style="display:none;">
            <h2>Insertar Cliente</h2>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre"><br>

            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido"><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono"><br>

            <label for="celular">Celular:</label>
            <input type="text" name="celular" id="celular"><br>

            <label for="correo">Correo:</label>
            <input type="email" name="correo" id="correo"><br>

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion"><br>

            <label for="identificacion">Identificación:</label>
            <input type="text" name="identificacion" id="identificacion"><br>
        </div>

        <div id="form-buscar-eliminar" style="display:none;">
            <h2>Buscar/Eliminar Cliente</h2>
            <label for="id_cliente">ID Cliente:</label>
            <input type="text" name="id_cliente" id="id_cliente"><br>
        </div>

        <button type="submit">Enviar</button>
    </form>

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

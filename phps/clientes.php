<?php
$servername = "localhost";
$username = "root";
$password = "1234"; // Cambia esto a tu contraseña
$dbname = "agencia"; // Cambia esto a tu nombre de base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action == 'insertar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $celular = $_POST['celular'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $identificacion = $_POST['identificacion'];
    insertarCliente($nombre, $apellido, $telefono, $celular, $correo, $direccion, $identificacion);
} elseif ($action == 'mostrar') {
    mostrarClientesDesencriptados();
} elseif ($action == 'eliminar') {
    $id_cliente = $_POST['id_cliente'];
    eliminarCliente($id_cliente);
} elseif ($action == 'buscar') {
    $id_cliente = $_POST['id_cliente'];
    buscarClientePorId($id_cliente);
}

// Función para insertar un cliente
function insertarCliente($nombre, $apellido, $telefono, $celular, $correo, $direccion, $identificacion) {
    global $conn;

    $stmt = $conn->prepare("CALL sp_insertar_cliente(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $apellido, $telefono, $celular, $correo, $direccion, $identificacion);

    if ($stmt->execute()) {
        echo "Cliente insertado correctamente.<br>";
    } else {
        echo "Error al insertar el cliente: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

// Función para desencriptar y mostrar todos los clientes
function mostrarClientesDesencriptados() {
    global $conn;

    $sql = "CALL sp_desencriptar_datos()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre_desencriptado"] . " - Apellido: " . $row["apellido_desencriptado"] . " - Teléfono: " . $row["telefono_desencriptado"] . " - Celular: " . $row["celular_desencriptado"] . " - Correo: " . $row["correo_desencriptado"] . " - Dirección: " . $row["direccion_desencriptado"] . " - Identificación: " . $row["identificacion_desencriptado"] . "<br>";
        }
    } else {
        echo "0 resultados.<br>";
    }
}

// Función para eliminar un cliente por ID
function eliminarCliente($id) {
    global $conn;

    $stmt = $conn->prepare("CALL sp_eliminar_cliente(?)");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Cliente eliminado correctamente.<br>";
    } else {
        echo "Error al eliminar el cliente: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

// Función para buscar un cliente por ID
function buscarClientePorId($id) {
    global $conn;

    $stmt = $conn->prepare("CALL sp_buscar_cliente_por_id(?)");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "ID: " . $row["id"] . " - Nombre: " . $row["nombre_desencriptado"] . " - Apellido: " . $row["apellido_desencriptado"] . " - Teléfono: " . $row["telefono_desencriptado"] . " - Celular: " . $row["celular_desencriptado"] . " - Correo: " . $row["correo_desencriptado"] . " - Dirección: " . $row["direccion_desencriptado"] . " - Identificación: " . $row["identificacion_desencriptado"] . "<br>";
            }
        } else {
            echo "No se encontró el cliente.<br>";
        }
    } else {
        echo "Error al buscar el cliente: " . $stmt->error . "<br>";
    }

    $stmt->close();
}

$conn->close();
?>

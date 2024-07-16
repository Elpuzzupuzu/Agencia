<?php
include('conec.php'); // Asegúrate de que la conexión a la base de datos es correcta

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica y obtiene los datos del formulario
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $id_contrato = isset($_SESSION['id_contrato']) ? $_SESSION['id_contrato'] : null; // Obtén el ID del contrato de la sesión
    $id_cuenta = isset($_SESSION['id_cuenta']) ? $_SESSION['id_cuenta'] : null; // Obtén el ID de la cuenta de la sesión
    $id_turno = isset($_POST['turno']) ? $_POST['turno'] : '';
    $capacitacion = isset($_POST['capacitacion']) ? 1 : 0; // Convertir checkbox a valor booleano
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';
    $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';
    $cpostal = isset($_POST['codigo_postal']) ? $_POST['codigo_postal'] : '';
    $id_prestacion = isset($_POST['id_prestacion']) ? $_POST['id_prestacion'] : '';

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL sp_insertar_empleado(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conection->prepare($sql);

    if (!$stmt) {
        die('Error en la preparación de la consulta: ' . $conection->error);
    }

    // Asegurarse de que `direccion` se vincule como una cadena de texto (`s` en bind_param)
    $stmt->bind_param("ssiiiisssi", $nombre, $apellido, $id_contrato, $id_cuenta, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $id_prestacion);

    if ($stmt->execute()) {
        // Obtener el ID del empleado recién insertado
        $resultado = $conection->query("SELECT LAST_INSERT_ID() as id");
        $row = $resultado->fetch_assoc();
        $id_empleado = $row['id'];

        $_SESSION['id_empleado'] = $id_empleado;
        $_SESSION['mensaje'] = "Empleado registrado correctamente. ID: $id_empleado";

        $stmt->close();
    } else {
        $_SESSION['mensaje'] = "Error al registrar empleado: " . $stmt->error;
    }

    header("Location: form_empleado.php");
    exit();
}

$conection->close();
?>


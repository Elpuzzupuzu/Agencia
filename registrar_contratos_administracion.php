<?php
// Incluir la conexión a la base de datos
include("conec.php");
session_start(); // Iniciar la sesión

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $id_empleado = intval($_POST['id_empleado']); // Convertir a entero
    $sueldo = floatval($_POST['sueldo']); // Convertir a flotante
    
    // Preparar la consulta SQL para insertar datos
    $stmt = $conection->prepare("CALL insertarContratoAdministracion(?, ?)");

    // Verificar si la consulta se preparó correctamente
    if ($stmt === false) {
        die('Error al preparar la consulta: ' . $conection->error);
    }

    // Asociar parámetros y ejecutar la consulta
    $stmt->bind_param("id", $id_empleado, $sueldo); // 'i' para entero, 'd' para double

    try {
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Registro exitoso."; // Guardar el mensaje en la sesión
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['mensaje'] = "Error al registrar: " . $e->getMessage(); // Guardar el mensaje de error en la sesión
    }

    // Cerrar la consulta
    $stmt->close();
    // Cerrar la conexión
    $conection->close();

    // Redirigir después de completar la operación
    header('Location: form_vendedor.php');
    exit;
}
?>
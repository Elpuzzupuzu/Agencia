<?php
// Incluir la conexión a la base de datos
include("conec.php");
session_start(); // Iniciar la sesión

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $nombre = htmlspecialchars($_POST['nombre']);
    $apellido = htmlspecialchars($_POST['apellido']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $celular = htmlspecialchars($_POST['celular']);
    $correo = htmlspecialchars($_POST['correo']);
    $direccion =htmlspecialchars($_POST['direccion']) ; // Convertir a entero 
    $identificacion = htmlspecialchars($_POST['identificacion']);
    

    // Preparar la consulta SQL para insertar datos
    $stmt = $conection->prepare("CALL sp_insertar_cliente(?, ?, ?, ?, ?, ?, ?)");

    // Verificar si la consulta se preparó correctamente
    if ($stmt === false) {
        die('Error al preparar la consulta: ' . $conection->error);
    }

    // Asociar parámetros y ejecutar la consulta
    $stmt->bind_param("sssssss", $nombre, $apellido, $telefono, $celular, $correo, $direccion, $identificacion);
    if ($stmt->execute()) {
        $_SESSION['mensaje'] = "Registro exitoso."; // Guardar el mensaje en la sesión
    } else {
        $_SESSION['mensaje'] = "Error al registrar: " . $stmt->error; // Guardar el mensaje de error en la sesión
    }

    // Cerrar la consulta
    $stmt->close();
    // Cerrar la conexión
    $conection->close();

    // Redirigir después de completar la operación
    header('Location: form_cliente.php');
    exit;
}
?>
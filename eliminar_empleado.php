<?php
session_start(); // Iniciar sesión para manejar mensajes

include "conec.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Llamar al procedimiento almacenado para eliminar el músico
    $sql = $conection->prepare("CALL sp_eliminar_empleado(?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conection->error);
    }
    $sql->bind_param("i", $id);
    
    if ($sql->execute()) {
        // Establecer el mensaje de éxito en la sesión
        $_SESSION['mensaje'] = "El músico con ID $id ha sido eliminado correctamente.";

        // Redirigir de vuelta a la página de búsqueda por ID
        header('Location: form_buscar_por_id.php');
        exit;
    } else {
        die('Error al ejecutar la consulta: ' . $sql->error);
    }
}
?>

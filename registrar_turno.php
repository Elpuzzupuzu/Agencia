<?php
// Incluir el archivo de conexión
include("conec.php"); // Asegúrate de proporcionar la ruta correcta a tu archivo de conexión

// Procesamiento del formulario al enviar (método POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turnoId = $_POST['turno'];

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL sp_insertar_turno(?)";
    $stmt = $conection->prepare($sql);
    $stmt->bind_param("s", $turnoId);

    if ($stmt->execute()) {
        echo "Turno registrado correctamente.";
    } else {
        echo "Error al registrar turno: " . $stmt->error;
    }

    $stmt->close();
}

// Cerrar la conexión al finalizar
$conection->close();
?>

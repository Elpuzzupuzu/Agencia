<?php
// Incluir el archivo de conexión
include 'conec.php'; // Asegúrate de que el nombre del archivo de conexión sea correcto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id_vendedor = $_POST['id_vendedor'];
    $id_auto = $_POST['id_auto'];

    // Preparar y ejecutar el procedimiento almacenado para insertar la venta
    $stmt = $conection->prepare("CALL sp_insertar_venta(?, ?)");
    $stmt->bind_param("ii", $id_vendedor, $id_auto);

    if ($stmt->execute()) {
        echo "Venta insertada correctamente.";
    } else {
        echo "Error al insertar la venta: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conection->close();
}
?>

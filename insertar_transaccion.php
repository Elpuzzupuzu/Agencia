<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Obtener datos del formulario
$numero_transaccion = $_POST['numero_transaccion'];
$id_metodo_pago = $_POST['id_metodo_pago'];
$id_cliente = $_POST['id_cliente'];
$monto = $_POST['monto'];

// Preparar y ejecutar el procedimiento almacenado
$stmt = $conection->prepare("CALL sp_insertar_transaccion(AES_ENCRYPT(?, 'abc'), ?, ?, ?)");
$stmt->bind_param("siii", $numero_transaccion, $id_metodo_pago, $id_cliente, $monto);

if ($stmt->execute()) {
    echo "Transacción insertada correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conection->close();
?>

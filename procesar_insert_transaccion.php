<?php
// Incluir el archivo de conexión
include 'conec.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_transaccion = $_POST['numero_transaccion'];
    $id_metodo_pago = $_POST['id_metodo_pago'];
    $id_cliente = $_POST['id_cliente'];
    $monto = $_POST['monto'];

    // Preparar y ejecutar el procedimiento almacenado para insertar la transacción
    $stmt = $conection->prepare("CALL sp_insertar_transaccion(?, ?, ?, ?)");
    $stmt->bind_param("sidi", $numero_transaccion, $id_metodo_pago, $id_cliente, $monto);

    if ($stmt->execute()) {
        echo "Transacción insertada correctamente.";
    } else {
        echo "Error al insertar la transacción: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conection->close();
}
?>

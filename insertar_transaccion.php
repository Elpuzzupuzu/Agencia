<?php
// Incluir el archivo de conexión
include 'conec.php'; // Asegúrate de que el nombre del archivo de conexión sea correcto

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $numero_transaccion = $_POST['numero_de_transaccion'];
    $id_metodo_pago = $_POST['id_metodo_de_pago'];
    $id_cliente = $_POST['id_cliente'];
    $monto = $_POST['monto'];

    // Preparar y ejecutar el procedimiento almacenado para insertar la transacción
    $stmt = $conection->prepare("CALL sp_insertar_transaccion(?, ?, ?, ?)");
    $stmt->bind_param("sidi", $numero_transaccion, $id_metodo_pago, $id_cliente, $monto);

    if ($stmt->execute()) {
        // Si la inserción fue exitosa, redirigir al formulario de venta
        header("Location: form_venta.php"); // Cambia 'venta_formulario.php' al nombre de tu archivo de formulario de venta
        exit();
    } else {
        echo "Error al insertar la transacción: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conection->close();
}
?>

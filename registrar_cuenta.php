<?php
include('conec.php'); // Asegúrate de que la conexión a la base de datos es correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_cuenta = $_POST['cuenta'];

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL sp_insertar_cuenta(?)";
    $stmt = $conection->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $numero_cuenta);

        if ($stmt->execute()) {
            // Obtener el ID de la cuenta recién insertada
            $resultado = $conection->query("SELECT LAST_INSERT_ID() as id");
            $row = $resultado->fetch_assoc();
            $id_cuenta = $row['id'];

            session_start();
            $_SESSION['id_cuenta'] = $id_cuenta;
            $_SESSION['mensaje'] = "Cuenta registrada correctamente. ID: $id_cuenta";
        } else {
            session_start();
            $_SESSION['mensaje'] = "Error al registrar cuenta: " . $stmt->error;
        }

        $stmt->close();
    } else {
        session_start();
        $_SESSION['mensaje'] = "Error en la preparación de la consulta: " . $conection->error;
    }

    header("Location: form_empleado.php");
    exit();
}

$conection->close();
?>

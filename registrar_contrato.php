<?php
include('conec.php'); // Asegúrate de que la conexión a la base de datos es correcta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_contrato = $_POST['nombre'];
    $fecha_contrato = $_POST['fechacontrato'];

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL sp_insertar_contrato(?, ?)";
    $stmt = $conection->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $numero_contrato, $fecha_contrato);

        if ($stmt->execute()) {
            // Obtener el ID del contrato recién insertado
            $resultado = $conection->query("SELECT LAST_INSERT_ID() as id");
            $row = $resultado->fetch_assoc();
            $id_contrato = $row['id'];

            session_start();
            $_SESSION['id_contrato'] = $id_contrato;
            $_SESSION['mensaje'] = "Contrato registrado correctamente. ID: $id_contrato";
        } else {
            session_start();
            $_SESSION['mensaje'] = "Error al registrar contrato: " . $stmt->error;
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

<?php
// Evitar el caché del navegador
header("Cache-Control: no cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

include("conec.php");

$errors = []; // Array para almacenar errores de validación

// Función para validar datos (puedes expandir esta función según tus necesidades de validación)
function validarDatos($datos) {
    if (empty($datos['nombre'])) {
        return 'El nombre es obligatorio.';
    }
    if (empty($datos['apellido'])) {
        return 'El apellido es obligatorio.';
    }
    if (empty($datos['turno'])) {
        return 'El turno es obligatorio.';
    }
    return ''; // Devuelve cadena vacía si no hay errores
}

// Función para ejecutar el procedimiento almacenado de actualización
function actualizarEmpleado($conexion, $id, $nombre, $apellido, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $infonavit, $seguro_social, $afore, $vacaciones) {
    $sql = $conexion->prepare("CALL sp_editar_empleado(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conexion->error);
    }
    // Convertir los valores booleanos a enteros (0 o 1) para MySQL
    $capacitacion = isset($capacitacion) && $capacitacion ? 1 : 0;
    $infonavit = isset($infonavit) && $infonavit ? 1 : 0;
    $seguro_social = isset($seguro_social) && $seguro_social ? 1 : 0;
    $afore = isset($afore) && $afore ? 1 : 0;
    $vacaciones = isset($vacaciones) && $vacaciones ? 1 : 0;

    $sql->bind_param("issiisssiiii", $id, $nombre, $apellido, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $infonavit, $seguro_social, $afore, $vacaciones);

    if ($sql->execute()) {
        return true; // Éxito en la ejecución del procedimiento almacenado
    } else {
        die('Error al ejecutar la consulta: ' . $sql->error);
    }
}

// Manejo del formulario POST para actualizar el empleado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $id_turno = !empty($_POST['turno']) ? intval($_POST['turno']) : null;
    $capacitacion = isset($_POST['capacitacion']) ? 1 : 0; // Checkbox en HTML envía si está seleccionado o no
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $cpostal = $_POST['cpostal'];
    $infonavit = isset($_POST['infonavit']) ? 1 : 0; // Checkbox en HTML envía si está seleccionado o no
    $seguro_social = isset($_POST['seguro-social']) ? 1 : 0; // Checkbox en HTML envía si está seleccionado o no
    $afore = isset($_POST['afore']) ? 1 : 0; // Checkbox en HTML envía si está seleccionado o no
    $vacaciones = isset($_POST['vacaciones']) ? 1 : 0; // Checkbox en HTML envía si está seleccionado o no

    // Validación de datos
    $validacion = validarDatos($_POST);
    if (!empty($validacion)) {
        $errors[] = $validacion;
    }

    // Llamar al procedimiento almacenado para actualizar el empleado
    if (empty($errors)) {
        if (actualizarEmpleado($conection, $id, $nombre, $apellido, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $infonavit, $seguro_social, $afore, $vacaciones)) {
            // Almacenar mensaje de éxito en sesión
            session_start();
            $_SESSION['mensaje'] = "Empleado se actualizó correctamente.";

            // Redirigir de vuelta a la página de búsqueda por ID
            header('Location: form_buscar_por_id_empleado.php');
            exit;
        } else {
            $errors[] = "Error al actualizar el empleado.";
        }
    }
}

// Obtener datos del empleado para prellenar el formulario en caso de GET o error de validación
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = $conection->prepare("CALL sp_buscar_empleado_por_id(?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conection->error);
    }
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        $result = $sql->get_result();
        $empleado = $result->fetch_object();
        if (!$empleado) {
            die('No se encontró ningún empleado con ese ID.');
        }
    } else {
        die('Error al ejecutar la consulta: ' . $sql->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center p-3">Editar Empleado</h1>
        <?php if (isset($empleado)) { ?>
            <form class="col-4 p-3" action="editar_empleado.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($empleado->id); ?>">
                <h3 class="text-center text-secondary">Editar empleado</h3>
                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($errors as $error) { ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars(isset($_POST['nombre']) ? $_POST['nombre'] : $empleado->nombre); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars(isset($_POST['apellido']) ? $_POST['apellido'] : $empleado->apellido); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="turno" class="form-label">Turno</label>
                    <select class="form-select" id="turno" name="turno" required>
                        <option value="1" <?php echo (isset($_POST['turno']) && $_POST['turno'] == 1) || $empleado->id_turno == 1 ? 'selected' : ''; ?>>Mañana</option>
                        <option value="2" <?php echo (isset($_POST['turno']) && $_POST['turno'] == 2) || $empleado->id_turno == 2 ? 'selected' : ''; ?>>Tarde</option>
                        <option value="3" <?php echo (isset($_POST['turno']) && $_POST['turno'] == 3) || $empleado->id_turno == 3 ? 'selected' : ''; ?>>Noche</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Capacitación</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="capacitacion" name="capacitacion" <?php echo (isset($_POST['capacitacion']) && $_POST['capacitacion']) || $empleado->capacitacion ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="capacitacion">
                            ¿Tiene capacitación?
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo htmlspecialchars(isset($_POST['direccion']) ? $_POST['direccion'] : $empleado->direccion); ?>">
                </div>
                <div class="mb-3">
                    <label for="ciudad" class="form-label">Ciudad</label>
                    <input type="text" class="form-control" name="ciudad" value="<?php echo htmlspecialchars(isset($_POST['ciudad']) ? $_POST['ciudad'] : $empleado->ciudad); ?>">
                </div>
                <div class="mb-3">
                    <label for="cpostal" class="form-label">Código Postal</label>
                    <input type="text" class="form-control" name="cpostal" value="<?php echo htmlspecialchars(isset($_POST['cpostal']) ? $_POST['cpostal'] : $empleado->cpostal); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Infonavit</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="infonavit" name="infonavit" <?php echo (isset($_POST['infonavit']) && $_POST['infonavit']) || $empleado->infonavit ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="infonavit">
                            ¿Tiene Infonavit?
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Seguro Social</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="seguro-social" name="seguro-social" <?php echo (isset($_POST['seguro-social']) && $_POST['seguro-social']) || $empleado->seguro_social ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="seguro-social">
                            ¿Tiene Seguro Social?
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Afore</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="afore" name="afore" <?php echo (isset($_POST['afore']) && $_POST['afore']) || $empleado->afore ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="afore">
                            ¿Tiene Afore?
                        </label>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Vacaciones</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="vacaciones" name="vacaciones" <?php echo (isset($_POST['vacaciones']) && $_POST['vacaciones']) || $empleado->vacaciones ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="vacaciones">
                            ¿Tiene Vacaciones?
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        <?php } else { ?>
            <p>No se ha proporcionado un ID de empleado válido.</p>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9oVn2YfMl/8kP07PLgY4w6gB+5ke6xQ0fX9eSAZ5Le+k+E5aMCw5S5YvvF4vopC1" crossorigin="anonymous"></script>
</body>
</html>


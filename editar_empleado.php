<?php
// Evitar el caché del navegador
header("Cache-Control: no cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

include "conec.php";

$errors = []; // Array para almacenar errores de validación

// Función para validar datos (puedes expandir esta función según tus necesidades de validación)
function validarDatos($datos) {
    if (empty($datos['nombre'])) {
        return 'El nombre es obligatorio.';
    }
    if (empty($datos['apellido'])) {
        return 'El apellido es obligatorio.';
    }
    return ''; // Devuelve cadena vacía si no hay errores
}

// Función para ejecutar el procedimiento almacenado de actualización
function actualizarMusico($conexion, $id, $nombre, $apellido, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $id_prestacion) {
    $sql = $conexion->prepare("CALL sp_editar_empleado(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conexion->error);
    }
    $sql->bind_param("issiisssi", $id, $nombre, $apellido, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $id_prestacion);

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
    $id_turno = !empty($_POST['fechanacimiento']) ? $_POST['fechanacimiento'] : null;
    $capacitacion = $_POST['estado'];;
    $direccion = $_POST['nacionalidad'];
    $ciudad = $_POST['nacionalidad'];
    $cpostal = $_POST['nacionalidad'];
    $id_prestacion = $_POST['instrumento']; // 


    // Validación de datos
    $validacion = validarDatos($_POST);
    if (!empty($validacion)) {
        $errors[] = $validacion;
    }

    // Llamar al procedimiento almacenado para actualizar el músico
    if (empty($errors)) {
        if (actualizarMusico($conection, $id, $nombre, $apellido, $id_turno, $capacitacion, $direccion, $ciudad, $cpostal, $id_prestacion)) {
            // Almacenar mensaje de éxito en sesión
            session_start();
            $_SESSION['mensaje'] = "Empleado se actualizó correctamente.";

            // Redirigir de vuelta a la página de búsqueda por ID
            header('Location: form_buscar_empleado_por_id.php');
            exit;
        } else {
            $errors[] = "Error al actualizar el empleado.";
        }
    }
}

// Obtener datos del músico para prellenar el formulario en caso de GET o error de validación
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = $conection->prepare("CALL sp_buscar_empleado_por_id(?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conection->error);
    }
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        $result = $sql->get_result();
        $musico = $result->fetch_object();
        if (!$musico) {
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
    <title>Editar Músico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center p-3">Editar Músico</h1>
        <?php if (isset($musico)) { ?>
            <form class="col-4 p-3" action="editar_empleado.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $musico->id_musico; ?>">
                <h3 class="text-center text-secondary">Editar empleado</h3>
                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($errors as $error) { ?>
                            <p><?php echo $error; ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : $musico->nombre; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="apellido" value="<?php echo isset($_POST['apellido']) ? $_POST['apellido'] : $musico->apellido; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="id_turno" class="form-label">turno</label>
                    <select class="form-select" id="instrumento" name="instrumento" required>
                        <option value="1" <?php echo (isset($_POST['turno']) && $_POST['instrumento'] == 1) || $musico->id_turno == 1 ? 'selected' : ''; ?>>mañana</option>
                        <option value="2" <?php echo (isset($_POST['turno']) && $_POST['instrumento'] == 2) || $musico->id_turno == 2 ? 'selected' : ''; ?>>tarde</option>
                        <option value="3" <?php echo (isset($_POST['turno']) && $_POST['instrumento'] == 3) || $musico->id_turno == 3 ? 'selected' : ''; ?>>noche</option>
                        <option value="4" <?php echo (isset($_POST['turno']) && $_POST['instrumento'] == 4) || $musico->id_turno == 4 ? 'selected' : ''; ?>>turno a </option>
                        <option value="5" <?php echo (isset($_POST['turno']) && $_POST['instrumento'] == 5) || $musico->id_turno == 5 ? 'selected' : ''; ?>>turno b</option>
                        
                    </select>
                </div>


                <div class="mb-3">
                    <label for="capacitacion" class="form-label">turno</label>
                    <select class="form-select" id="capacitacion" name="capacitacion" required>
                        <option value="0" <?php echo (isset($_POST['capacitacion']) && $_POST['capacitacion'] == 0) || $musico->capacitacion == 0 ? 'selected' : ''; ?>>capacitado</option>
                        <option value="1" <?php echo (isset($_POST['capacitacion']) && $_POST['capacitacion'] == 1) || $musico->capacitacion == 1 ? 'selected' : ''; ?>>No capacitado</option>
                        
                    </select>
                </div>

                <div class="mb-3">
                    <label for="direccion" class="form-label">direccion</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo isset($_POST['direccion']) ? $_POST['direccion'] : $musico->direccion; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="ciudad" class="form-label">ciudad</label>
                    <input type="text" class="form-control" name="ciudad" value="<?php echo isset($_POST['ciudad']) ? $_POST['ciudad'] : $musico->ciudad; ?>" required>
                </div>

                <div class="mb-3">
                    <label for="cpostal" class="form-label">codigo postal</label>
                    <input type="text" class="form-control" name="cpostal" value="<?php echo isset($_POST['cpostal']) ? $_POST['cpostal'] : $musico->cpostal; ?>" required>
                </div>



                <div class="mb-3">
                    <label for="prestacion" class="form-label">prestacion</label>
                    <select class="form-select" id="capacitaciobn" name="prestacion" required>
                        <option value="1" <?php echo (isset($_POST['prestacion']) && $_POST['prestacion'] == 1) || $musico->prestacion == 1 ? 'selected' : ''; ?>>seguro medico</option>
                        <option value="2" <?php echo (isset($_POST['prestacion']) && $_POST['prestacion'] == 2) || $musico->prestacion == 2 ? 'selected' : ''; ?>>bono anual</option>
                        
                    </select>
                </div>



                <div class="mb-3">
                    <label for="genero" class="form-label">Género</label>
                    <input type="text" class="form-control" name="genero" value="<?php echo isset($_POST['genero']) ? $_POST['genero'] : $musico->genero; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nacionalidad" class="form-label">Nacionalidad</label>
                    <input type="text" class="form-control" name="nacionalidad" value="<?php echo isset($_POST['nacionalidad']) ? $_POST['nacionalidad'] : $musico->nacionalidad; ?>" required>
                </div>
               
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </form>
        <?php } else { ?>
            <p>No se encontró el empleado especificado.</p>
        <?php } ?>
    </div>

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Deshabilitar la navegación hacia atrás del navegador
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
</body>
</html>
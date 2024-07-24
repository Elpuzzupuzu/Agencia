
<?php
// Evitar el caché del navegador
header("Cache-Control: no cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

include("conec.php");

$errors = []; // Array para almacenar errores de validación

// Función para validar datos (puedes expandir esta función según tus necesidades de validación)
function validarDatos($datos) {
    if (empty($datos['numero_de_serie'])) {
        return 'El nombre es obligatorio.';
    }
    if (empty($datos['id_estado'])) {
        return 'El apellido es obligatorio.';
    }
    if (empty($datos['id_modelo'])) {
        return 'El turno es obligatorio.';
    }
    return ''; // Devuelve cadena vacía si no hay errores
}

// Función para ejecutar el procedimiento almacenado de actualización
function actualizarAuto($conexion, $id, $numero_de_serie, $id_estado, $id_marca, $id_modelo, $numero_cilindros, $disponibilidad, $precio, $numero_puertas, $color, $id_seguro, $id_servicio, $id_garantia, $costo, $descuento, $costo_de_venta) {
    $sql = $conexion->prepare("CALL UpdateAuto(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conexion->error);
    }
    // Convertir los valores booleanos a enteros (0 o 1) para MySQL
    $capacitacion = isset($capacitacion) && $capacitacion ? 1 : 0;
    $infonavit = isset($infonavit) && $infonavit ? 1 : 0;
    $seguro_social = isset($seguro_social) && $seguro_social ? 1 : 0;
    $afore = isset($afore) && $afore ? 1 : 0;
    $vacaciones = isset($vacaciones) && $vacaciones ? 1 : 0;

    $sql->bind_param("isiiiiiiisiiiiii", $id, $numero_de_serie, $id_estado, $id_marca, $id_modelo, $numero_cilindros, $disponibilidad, $precio, $numero_puertas, $color, $id_seguro, $id_servicio, $id_garantia, $costo, $descuento, $costo_de_venta);

    if ($sql->execute()) {
        return true; // Éxito en la ejecución del procedimiento almacenado
    } else {
        die('Error al ejecutar la consulta: ' . $sql->error);
    }
}

// Manejo del formulario POST para actualizar el empleado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $numero_de_serie = $_POST['numero_de_serie'];
    $id_estado = !empty($_POST['id_estado']) ? intval($_POST['id_estado']) : null;
    $id_marca = !empty($_POST['id_marca']) ? intval($_POST['id_marca']) : null;
    $id_modelo = !empty($_POST['id_modelo']) ? intval($_POST['id_modelo']) : null;
    $numero_cilindros = !empty($_POST['numero_cilindros']) ? intval($_POST['numero_cilindros']) : null;
    $disponibilidad = isset($_POST['disponibilidad']) ? 1 : 0; // Checkbox en HTML envía si está seleccionado o no
    $precio = !empty($_POST['precio']) ? intval($_POST['precio']) : null;
    $numero_puertas = !empty($_POST['numero_puertas']) ? intval($_POST['numero_puertas']) : null;
    $color = $_POST['color'];
    $id_seguro = !empty($_POST['id_seguro']) ? intval($_POST['id_seguro']) : null;
    $id_servicio = !empty($_POST['id_servicio']) ? intval($_POST['id_servicio']) : null;
    $id_garantia = !empty($_POST['id_garantia']) ? intval($_POST['id_garantia']) : null;
    $costo = !empty($_POST['costo']) ? intval($_POST['costo']) : null;
    $descuento = !empty($_POST['descuento']) ? intval($_POST['descuento']) : null;
    $costo_de_venta = !empty($_POST['costo_de_venta']) ? intval($_POST['costo_de_venta']) : null;


    // Validación de datos
    $validacion = validarDatos($_POST);
    if (!empty($validacion)) {
        $errors[] = $validacion;
    }

    // Llamar al procedimiento almacenado para actualizar el empleado
    if (empty($errors)) {
        if (actualizarAuto($conection, $id, $numero_de_serie, $id_estado, $id_marca, $id_modelo, $numero_cilindros, $disponibilidad, $precio, $numero_puertas, $color, $id_seguro, $id_servicio, $id_garantia, $costo, $descuento, $costo_de_venta)) {
            // Almacenar mensaje de éxito en sesión
            session_start();
            $_SESSION['mensaje'] = "Auto se actualizó correctamente.";

            // Redirigir de vuelta a la página de búsqueda por ID
            header('Location: form_buscar_por_id_auto.php');
            exit;
        } else {
            $errors[] = "Error al actualizar el Auto.";
        }
    }
}

// Obtener datos del empleado para prellenar el formulario en caso de GET o error de validación
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = $conection->prepare("CALL GetAutoById(?)");
    if ($sql === false) {
        die('Error en la preparación de la consulta SQL: ' . $conection->error);
    }
    $sql->bind_param("i", $id);
    if ($sql->execute()) {
        $result = $sql->get_result();
        $empleado = $result->fetch_object();
        if (!$empleado) {
            die('No se encontró ningún auto con ese ID.');
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
    <title>Editar Auto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center p-3">Editar Auto</h1>
        <?php if (isset($empleado)) { ?>
            <form class="col-4 p-3" action="update_auto.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($empleado->id); ?>">
                <h3 class="text-center text-secondary">Editar Auto</h3>
                <?php if (!empty($errors)) { ?>
                    <div class="alert alert-danger" role="alert">
                        <?php foreach ($errors as $error) { ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>
                <div class="mb-3">
                    <label for="numero_de_serie" class="form-label">Numero de serie</label>
                    <input type="text" class="form-control" name="numero_de_serie" value="<?php echo htmlspecialchars(isset($_POST['numero_de_serie']) ? $_POST['numero_de_serie'] : $empleado->numero_de_serie); ?>" required>
                </div>
               
                <div class="mb-3">
                    <label for="id_estado" class="form-label">Estado del auto</label>
                    <select class="form-select" id="id_estado" name="id_estado" required>
                        <option value="1" <?php echo (isset($_POST['id_estado']) && $_POST['id_estado'] == 1) || $empleado->id_estado == 1 ? 'selected' : ''; ?>>nuevo</option>
                        <option value="2" <?php echo (isset($_POST['id_estado']) && $_POST['id_estado'] == 2) || $empleado->id_estado == 2 ? 'selected' : ''; ?>>seminuevo</option>
                        <option value="3" <?php echo (isset($_POST['id_estado']) && $_POST['id_estado'] == 3) || $empleado->id_estado == 3 ? 'selected' : ''; ?>>en servicio</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_marca" class="form-label">Marca</label>
                    <select class="form-select" id="id_estado" name="id_estado" required>
                        <option value="1" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 1) || $empleado->id_marca == 1 ? 'selected' : ''; ?>>Toyota</option>
                        <option value="2" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 2) || $empleado->id_marca == 2 ? 'selected' : ''; ?>>Honda</option>
                        <option value="3" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 3) || $empleado->id_marca == 3 ? 'selected' : ''; ?>>Ford</option>
                        <option value="4" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 4) || $empleado->id_marca == 4 ? 'selected' : ''; ?>>Chevrolet</option>
                        <option value="5" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 5) || $empleado->id_marca == 5 ? 'selected' : ''; ?>>Nissan</option>
                        <option value="6" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 6) || $empleado->id_marca == 6 ? 'selected' : ''; ?>>Volkswagen</option>
                        <option value="7" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 7) || $empleado->id_marca == 7 ? 'selected' : ''; ?>>BMW</option>
                        <option value="8" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 8) || $empleado->id_marca == 8 ? 'selected' : ''; ?>>Mercedes-Benz</option>
                        <option value="9" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 9) || $empleado->id_marca == 9 ? 'selected' : ''; ?>>Audi</option>
                        <option value="10" <?php echo (isset($_POST['id_marca']) && $_POST['id_marca'] == 10) || $empleado->id_marca == 10 ? 'selected' : ''; ?>>Hyundai</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_modelo" class="form-label">Modelo</label>
                    <select class="form-select" id="id_modelo" name="id_modelo" required>
                        <option value="1" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 1) || $empleado->id_marca == 1 ? 'selected' : ''; ?>>Toyota</option>
                        <option value="2" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 2) || $empleado->id_marca == 2 ? 'selected' : ''; ?>>Honda</option>
                        <option value="3" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 3) || $empleado->id_marca == 3 ? 'selected' : ''; ?>>Ford</option>
                        <option value="4" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 4) || $empleado->id_marca == 4 ? 'selected' : ''; ?>>Chevrolet</option>
                        <option value="5" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 5) || $empleado->id_marca == 5 ? 'selected' : ''; ?>>Nissan</option>
                        <option value="6" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 6) || $empleado->id_marca == 6 ? 'selected' : ''; ?>>Volkswagen</option>
                        <option value="7" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 7) || $empleado->id_marca == 7 ? 'selected' : ''; ?>>BMW</option>
                        <option value="8" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 8) || $empleado->id_marca == 8 ? 'selected' : ''; ?>>Mercedes-Benz</option>
                        <option value="9" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 9) || $empleado->id_marca == 9 ? 'selected' : ''; ?>>Audi</option>
                        <option value="10" <?php echo (isset($_POST['id_modelo']) && $_POST['id_modelo'] == 10) || $empleado->id_marca == 10 ? 'selected' : ''; ?>>Hyundai</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="numero_cilindros" class="form-label">Numero de cilindros</label>
                    <input type="number" class="form-control" name="numero_cilindros" value="<?php echo htmlspecialchars(isset($_POST['numero_cilindros']) ? $_POST['numero_cilindros'] : $empleado->numero_cilindros); ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Disponibilidad</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="capacitacion" name="disponibilidad" <?php echo (isset($_POST['disponibilidad']) && $_POST['disponibilidad']) || $empleado->disponibilidad ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="disponibilidad">
                            ¿Esta disponible?
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">precio</label>
                    <input type="number" class="form-control" name="precio" value="<?php echo htmlspecialchars(isset($_POST['precio']) ? $_POST['precio'] : $empleado->precio); ?>">
                </div>

                <div class="mb-3">
                    <label for="numero_puertas" class="form-label">numero de puertas</label>
                    <input type="number" class="form-control" name="numero_puertas" value="<?php echo htmlspecialchars(isset($_POST['numero_puertas']) ? $_POST['numero_puertas'] : $empleado->numero_puertas); ?>">
                </div>

                <div class="mb-3">
                    <label for="color" class="form-label">color</label>
                    <input type="text" class="form-control" name="color" value="<?php echo htmlspecialchars(isset($_POST['color']) ? $_POST['color'] : $empleado->color); ?>">
                </div>

                <div class="mb-3">
                    <label for="id_seguro" class="form-label">Modelo</label>
                    <select class="form-select" id="id_seguro" name="id_seguro" required>
                        <option value="1" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 1) || $empleado->id_marca == 1 ? 'selected' : ''; ?>>Seguro Basico</option>
                        <option value="2" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 2) || $empleado->id_marca == 2 ? 'selected' : ''; ?>>Seguro Extendido</option>
                        <option value="3" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 3) || $empleado->id_marca == 3 ? 'selected' : ''; ?>>Seguro Completo</option>
                        <option value="4" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 4) || $empleado->id_marca == 4 ? 'selected' : ''; ?>>Seguro de Responsabilidad</option>
                        <option value="5" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 5) || $empleado->id_marca == 5 ? 'selected' : ''; ?>>Seguro Premium</option>
                        <option value="6" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 6) || $empleado->id_marca == 6 ? 'selected' : ''; ?>>Seguro Estandar</option>
                        <option value="7" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 7) || $empleado->id_marca == 7 ? 'selected' : ''; ?>>Seguro Avanzado</option>
                        <option value="8" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 8) || $empleado->id_marca == 8 ? 'selected' : ''; ?>>Seguro Economico</option>
                        <option value="9" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 9) || $empleado->id_marca == 9 ? 'selected' : ''; ?>>Seguro Personalizado</option>
                        <option value="10" <?php echo (isset($_POST['id_seguro']) && $_POST['id_seguro'] == 10) || $empleado->id_marca == 10 ? 'selected' : ''; ?>>Seguro Parcial</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_servicio" class="form-label">Servicio</label>
                    <select class="form-select" id="id_servicio" name="id_servicio" required>
                        <option value="1" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 1) || $empleado->id_servicio == 1 ? 'selected' : ''; ?>>Mantenimiento</option>
                        <option value="2" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 2) || $empleado->id_servicio == 2 ? 'selected' : ''; ?>>Reparacion</option>
                        <option value="3" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 3) || $empleado->id_servicio == 3 ? 'selected' : ''; ?>>Inspeccion</option>
                        <option value="4" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 4) || $empleado->id_servicio == 4 ? 'selected' : ''; ?>>Lavado</option>
                        <option value="5" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 5) || $empleado->id_servicio == 5 ? 'selected' : ''; ?>>Alineacion</option>
                        <option value="6" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 6) || $empleado->id_servicio == 6 ? 'selected' : ''; ?>>Balanceo</option>
                        <option value="7" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 7) || $empleado->id_servicio == 7 ? 'selected' : ''; ?>>Cambio de aceite</option>
                        <option value="8" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 8) || $empleado->id_servicio == 8 ? 'selected' : ''; ?>>Diagnostico</option>
                        <option value="9" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 9) || $empleado->id_servicio == 9 ? 'selected' : ''; ?>>Pintura</option>
                        <option value="10" <?php echo (isset($_POST['id_servicio']) && $_POST['id_servicio'] == 10) ||$empleado->id_servicio == 10 ? 'selected' : ''; ?>>Aire acondicionado</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="id_garantia" class="form-label">Garantia</label>
                    <select class="form-select" id="id_garantia" name="id_garantia" required>
                        <option value="1" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 1) || $empleado->id_garantia == 1 ? 'selected' : ''; ?>>Garantia Extendida</option>
                        <option value="2" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 2) || $empleado->id_garantia == 2 ? 'selected' : ''; ?>>Garantia Limitada</option>
                        <option value="3" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 3) || $empleado->id_garantia == 3 ? 'selected' : ''; ?>>Garantia de Fabrica</option>
                        <option value="4" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 4) || $empleado->id_garantia == 4 ? 'selected' : ''; ?>>Garantia Completa</option>
                        <option value="5" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 5) || $empleado->id_garantia == 5 ? 'selected' : ''; ?>>Garantia Premium</option>
                        <option value="6" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 6) || $empleado->id_garantia == 6 ? 'selected' : ''; ?>>Garantia Estandar</option>
                        <option value="7" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 7) || $empleado->id_garantia == 7 ? 'selected' : ''; ?>>Garantia Avanzada</option>
                        <option value="8" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 8) || $empleado->id_garantia == 8 ? 'selected' : ''; ?>>Garantia Economica</option>
                        <option value="9" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 9) || $empleado->id_garantia == 9 ? 'selected' : ''; ?>>Garantia Personalizada</option>
                        <option value="10" <?php echo (isset($_POST['id_garantia']) && $_POST['id_garantia'] == 10) ||$empleado->id_garantia == 10 ? 'selected' : ''; ?>>Garantia Temporal</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label for="costo" class="form-label">Costo</label>
                    <input type="number" class="form-control" name="costo" value="<?php echo htmlspecialchars(isset($_POST['costo']) ? $_POST['costo'] : $empleado->costo); ?>">
                </div>

                <div class="mb-3">
                    <label for="descuento" class="form-label">descuento</label>
                    <input type="number" class="form-control" name="descuento" value="<?php echo htmlspecialchars(isset($_POST['descuento']) ? $_POST['descuento'] : $empleado->descuento); ?>">
                </div>

                <div class="mb-3">
                    <label for="costo_de_venta" class="form-label">Costo de venta</label>
                    <input type="number" class="form-control" name="costo_de_venta" value="<?php echo htmlspecialchars(isset($_POST['costo_de_venta']) ? $_POST['costo_de_venta'] : $empleado->costo_de_venta); ?>">
                </div>


              
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        <?php } else { ?>
            <p>No se ha proporcionado un ID de AUTO válido.</p>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-9oVn2YfMl/8kP07PLgY4w6gB+5ke6xQ0fX9eSAZ5Le+k+E5aMCw5S5YvvF4vopC1" crossorigin="anonymous"></script>
</body>
</html>
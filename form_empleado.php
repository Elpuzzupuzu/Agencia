<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registro de Empleado</h1>

        <!-- Formulario para registrar contrato -->
        <form class="col-4 p-3" action="registrar_contrato.php" method="POST">
            <h3 class="text-center text-secondary">Registrar contrato</h3>
            <div class="mb-3">
                <label for="nombre_contrato" class="form-label">Número de Contrato</label>
                <input type="text" class="form-control" id="nombre_contrato" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="fecha_contrato" class="form-label">Fecha de Contrato</label>
                <input type="date" class="form-control" id="fecha_contrato" name="fechacontrato" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar contrato</button>
        </form>

        <!-- Formulario para registrar cuenta -->
        <form class="col-4 p-3" action="registrar_cuenta.php" method="POST">
            <h3 class="text-center text-secondary">Registrar cuenta</h3>
            <div class="mb-3">
                <label for="cuenta" class="form-label">Número de Cuenta</label>
                <input type="text" class="form-control" id="cuenta" name="cuenta" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar cuenta</button>
        </form>

        <!-- Formulario para registrar empleado -->
        <form class="col-4 p-3" action="registrar_empleado.php" method="POST">
            <h3 class="text-center text-secondary">Registrar empleado</h3>
            <div class="mb-3">
                <label for="nombre_empleado" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre_empleado" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="turno" class="form-label">Turno</label>
                <select class="form-select" id="turno" name="turno" required>
                    <option value="1">Mañana</option>
                    <option value="2">Tarde</option>
                    <option value="3">Noche</option>
                    <option value="4">Turno A</option>
                    <option value="5">Turno B</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Capacitación</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="capacitacion" name="capacitacion" value="1">
                    <label class="form-check-label" for="capacitacion">Activo/Inactivo</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" required>
            </div>
            <div class="mb-3">
                <label for="codigo_postal" class="form-label">Código Postal</label>
                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
            </div>

            <div class="mb-3">
                <label for="id_prestacion" class="form-label">Prestación</label>
                <select class="form-select" id="id_prestacion" name="id_prestacion" required>
                    <option value="1">Seguro Médico</option>
                    <option value="2">Bono Anual</option>
                    <option value="3">Subsidio de Transporte</option>
                    <option value="4">Vacaciones Pagadas</option>
                    <option value="5">Subsidio Comida</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Empleado</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

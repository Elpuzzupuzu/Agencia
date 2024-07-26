<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de mecanicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4 mb-4">Registro de mecanicos</h1>
        <a href="anadir.php" class="btn btn-primary mb-3">Regresar al menú</a>
        <?php
        session_start();
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='alert alert-success' role='alert'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
        }
        ?>
        <form class="col-4 p-3 mx-auto" action="registrar_mecanico.php" method="POST">
            <h3 class="text-center text-secondary">Registrar mecanico</h3>
            <div class="mb-3">
                <label for="id_empleado" class="form-label">ID empleado</label>
                <input type="number" class="form-control" id="id_empleado" name="id_empleado" required>
            </div>
            <div class="mb-3">
                <label for="sueldo" class="form-label">Sueldo</label>
                <input type="number" step="0.01" class="form-control" id="sueldo" name="sueldo" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar mecanico</button>
        </form>
    </div>
</body>
</html>

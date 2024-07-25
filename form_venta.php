<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrar Venta</h1>
        <form class="col-4 p-3" action="insertar_venta.php" method="POST">
            <div class="mb-3">
                <label for="id_vendedor" class="form-label">ID del Vendedor</label>
                <input type="number" class="form-control" id="id_vendedor" name="id_vendedor" required>
            </div>

            <div class="mb-3">
                <label for="id_auto" class="form-label">ID del Auto</label>
                <input type="number" class="form-control" id="id_auto" name="id_auto" required>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venta</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

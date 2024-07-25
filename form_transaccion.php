<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Transferencia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Transferencias</h1>

       

        <!-- Formulario para registrar empleado -->
        <form class="col-4 p-3" action="insertar_transaccion.php" method="POST">
            <h3 class="text-center text-secondary">TRANSSACCIONES</h3>
            <div class="mb-3">
                <label for="numero_de_transaccion" class="form-label">Numero de transaccion</label>
                <input type="text" class="form-control" id="numero_de_transaccion" name="numero_de_transaccion" required>
            </div>
           
            <div class="mb-3">
                <label for="id_metodo_de_pago" class="form-label">Meotodo de pago</label>
                <select class="form-select" id="id_metodo_de_pago" name="id_metodo_de_pago" required>
                    <option value="1">tarjeta</option>
                    <option value="2">contado</option>
                    <option value="3">Transferencia</option>
                    <option value="4">Cuenta Bancaria</option>
                  
                </select>
            </div>

            <div class="mb-3">
                <label for="id_cliente" class="form-label">Id del cliente</label>
                <input type="number" class="form-control" id="id_cliente" name="id_cliente" required>
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto a pagar</label>
                <input type="number" class="form-control" id="monto" name="monto" required>
            </div>


           
        
            <button type="submit" class="btn btn-primary">Registrar Empleado</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Transacción</title>
</head>
<body>
    <h1>Insertar Transacción</h1>
    <form action="insertar_transaccion.php" method="post">
        <label for="numero_transaccion">Número de Transacción:</label>
        <input type="text" id="numero_transaccion" name="numero_transaccion" required><br><br>
        
        <label for="id_metodo_pago">ID Método de Pago:</label>
        <input type="number" id="id_metodo_pago" name="id_metodo_pago" required><br><br>
        
        <label for="id_cliente">ID Cliente:</label>
        <input type="number" id="id_cliente" name="id_cliente" required><br><br>
        
        <label for="monto">Monto:</label>
        <input type="number" id="monto" name="monto" step="0.01" required><br><br>
        
        <input type="submit" value="Insertar Transacción">
    </form>
</body>
</html>

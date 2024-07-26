<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desencriptar Transacciones</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center text-primary mb-4">Desencriptar Transacciones</h1>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Número de Transacción</th>
                        <th>ID Método de Pago</th>
                        <th>ID Cliente</th>
                        <th>Monto</th>
                        <th>Fecha de Transacción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Incluir el archivo de conexión
                    include 'conec.php';

                    // Crear la consulta para ejecutar el procedimiento almacenado
                    $sql = "CALL sp_desencriptar_transacciones()";

                    // Ejecutar la consulta y verificar si se ha ejecutado correctamente
                    if ($result = $conection->query($sql)) {
                        // Obtener los resultados y mostrarlos
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row["id"] . '</td>';
                            echo '<td>' . $row["numero_transaccion_desencriptado"] . '</td>';
                            echo '<td>' . $row["id_metodo_pago"] . '</td>';
                            echo '<td>' . $row["id_cliente"] . '</td>';
                            echo '<td>' . $row["monto"] . '</td>';
                            echo '<td>' . $row["fecha_transaccion"] . '</td>';
                            echo '</tr>';
                        }
                        // Liberar el conjunto de resultados
                        $result->free();
                    } else {
                        // Mostrar el error en caso de que la consulta falle
                        echo '<tr><td colspan="6" class="text-center text-danger">Error al ejecutar el procedimiento almacenado: ' . $conection->error . '</td></tr>';
                    }

                    // Cerrar la conexión
                    $conection->close();
                    ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <a href="gestion_vendedor.php" class="btn btn-primary">Volver al Inicio</a>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


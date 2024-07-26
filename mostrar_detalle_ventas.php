<?php
require 'conec.php';

// Llama al procedimiento almacenado
$sql = "CALL GetDetalleVenta()";
$result = $conection->query($sql);

// Verifica si la consulta tuvo éxito
if ($result === false) {
    echo "Error en la consulta: " . $conection->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Ventas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .btn {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            table, th, td {
                display: block;
                width: 100%;
            }
            th, td {
                padding: 10px;
                text-align: right;
            }
            th {
                background-color: transparent;
                color: #333;
                text-align: right;
                border-bottom: 1px solid #ddd;
            }
            tr {
                margin-bottom: 10px;
                border-bottom: 2px solid #ddd;
            }
        }
    </style>
</head>
<body>
    <div class="button-container">
    </div>
    <h1>Detalle de Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Fecha Venta</th>
                <th>Nombre Vendedor</th>
                <th>Apellido Vendedor</th>
                <th>Nombre Cliente</th>
                <th>Apellido Cliente</th>
                <th>Número Transacción</th>
                <th>Monto Transacción</th>
                <th>Fecha Transacción</th>
                <th>Número de Serie</th>
                <th>ID Marca</th>
                <th>Modelo Año</th>
                <th>Número de Cilindros</th>
                <th>Precio</th>
                <th>Número de Puertas</th>
                <th>Color</th>
                <th>Disponibilidad</th>
                <th>Costo de Venta</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_venta"] . "</td>";
                    echo "<td>" . $row["fecha_venta"] . "</td>";
                    echo "<td>" . $row["nombre_vendedor"] . "</td>";
                    echo "<td>" . $row["apellido_vendedor"] . "</td>";
                    echo "<td>" . $row["nombre_cliente"] . "</td>";
                    echo "<td>" . $row["apellido_cliente"] . "</td>";
                    echo "<td>" . $row["numero_transaccion"] . "</td>";
                    echo "<td>" . $row["monto_transaccion"] . "</td>";
                    echo "<td>" . $row["fecha_transaccion"] . "</td>";
                    echo "<td>" . $row["numero_de_serie"] . "</td>";
                    echo "<td>" . $row["id_marca"] . "</td>";
                    echo "<td>" . $row["modelo_anio"] . "</td>";
                    echo "<td>" . $row["numero_cilindros"] . "</td>";
                    echo "<td>" . $row["precio"] . "</td>";
                    echo "<td>" . $row["numero_puertas"] . "</td>";
                    echo "<td>" . $row["color"] . "</td>";
                    echo "<td>" . ($row["disponibilidad"] ? "Sí" : "No") . "</td>";
                    echo "<td>" . $row["costo_de_venta"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='18'>No hay resultados</td></tr>";
            }
            $conection->close();
            ?>
        </tbody>
    </table>
    <div class="button-container">
        <a href="gestionar_autos.php" class="btn">Volver al Inicio</a>
    </div>
</body>
</html>

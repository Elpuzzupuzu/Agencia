<?php
// Procesamiento del formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'];

    $servername = "localhost";
    $username = "root";
    $password = "1234"; // 
    $dbname = "agencia";

    // Crear conexión
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    switch ($accion) {
        case 'insertar':
            // Proceso de inserción de cliente
            // Código existente para insertar un cliente
            break;

        case 'buscar':
            // Proceso de búsqueda de cliente
            // Código existente para buscar un cliente por ID
            break;

        case 'eliminar':
            // Proceso de eliminación de cliente
            // Código existente para eliminar un cliente por ID
            break;

        case 'desencriptar':
            // Proceso de desencriptación de datos de clientes
            $sql = "CALL GetAllAutos()";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<h2>Clientes Desencriptados</h2>';
                echo '<table border="1">';
                echo '<tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>Teléfono</th><th>Celular</th><th>Correo</th><th>Dirección</th><th>Identificación</th></tr>';
                
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $row["id"] . '</td>';
                    echo '<td>' . $row["numero_de_serie"] . '</td>';
                    echo '<td>' . $row["id_estado"] . '</td>';
                    echo '<td>' . $row["id_marca"] . '</td>';
                    echo '<td>' . $row["id_modelo"] . '</td>';
                    echo '<td>' . $row["numero_cilindros"] . '</td>';
                    echo '<td>' . $row["disponibilidad"] . '</td>';
                    echo '<td>' . $row["precio"] . '</td>';
                    echo '<td>' . $row["numero_puertas"] . '</td>';
                    echo '<td>' . $row["color"] . '</td>';
                    echo '<td>' . $row["id_seguro"] . '</td>';
                    echo '<td>' . $row["id_servicio"] . '</td>';
                    echo '<td>' . $row["id_garantia"] . '</td>';
                    echo '<td>' . $row["costo"] . '</td>';
                    echo '<td>' . $row["descuento"] . '</td>';
                    echo '<td>' . $row["costo_de_venta"] . '</td>';







                    echo '</tr>';
                }

                echo '</table>';
            } else {
                echo "0 resultados";
            }
            break;
    }

    $conn->close();
}
?>
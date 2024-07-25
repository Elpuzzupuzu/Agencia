<?php
// Incluir el archivo de conexión
include 'conexion.php';

// Preparar y ejecutar el procedimiento almacenado
$result = $conection->query("CALL sp_obtener_metodos_pago()");

if ($result) {
    echo "<h1>Métodos de Pago</h1>";
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>ID: " . $row['id'] . " - Método: " . $row['metodo'] . "</li>";
    }
    echo "</ul>";
} else {
    echo "Error: " . $conection->error;
}

// Cerrar conexión
$conection->close();
?>

<?php
session_start(); // Iniciar sesión para obtener el mensaje de éxito

// Verificar si hay un mensaje almacenado en la sesión
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Eliminar el mensaje para que no se muestre más de una vez
} else {
    $mensaje = '';
}

$mensaje_busqueda = ''; // Mensaje específico para la búsqueda
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autos Búsqueda por ID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .negative-margin {
            margin-bottom: -10px; /* Ajusta el valor según tus necesidades */
        }
    </style>
</head>
<body>
    <h1 class="text-center p-3">Autos búsqueda por ID
        <br>
        <a href="gestionar_autos.php" class="btn btn-primary">Regresar al menú</a>
    </h1>

    <div class="container-fluid" style="display: flex;">
        <div class="row">
            <!-- Tabla para mostrar todos los autos -->
            <div class="col-12 p-4 negative-margin">
                <?php if (!empty($mensaje)) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                <table class="table">
                    <thead class="bg-info">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">No. serie</th>
                            <th scope="col">Id estado</th>
                            <th scope="col">id_marca</th>
                            <th scope="col">id_modelo</th>
                            <th scope="col"># cilindros</th>
                            <th scope="col">disponibilidad</th>
                            <th scope="col">precio</th>
                            <th scope="col"># puertas</th>
                            <th scope="col">color</th>
                            <th scope="col">id seguro</th>
                            <th scope="col">id servicio</th>
                            <th scope="col">id garantia</th>
                            <th scope="col">costo</th>
                            <th scope="col">descuento</th>
                            <th scope="col">costo de venta</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conec.php";

                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                            $id = intval($_POST['id']); // Asegúrate de que el ID es un número entero

                            $sql = $conection->prepare("CALL GetAutoById(?)");
                            $sql->bind_param("i", $id);
                            $sql->execute();
                            $result = $sql->get_result();

                            if ($result->num_rows > 0) {
                                $mensaje_busqueda = 'Auto encontrado:';
                                while ($datos = $result->fetch_object()) { ?>
                                    <tr>
                                        <td><?= $datos->id ?></td>
                                        <td><?= $datos->numero_de_serie ?></td>
                                        <td><?= $datos->id_estado ?></td>
                                        <td><?= $datos->id_marca ?></td>
                                        <td><?= $datos->id_modelo ?></td>
                                        <td><?= $datos->numero_cilindros ?></td>
                                        <td><?= $datos->disponibilidad ?></td>
                                        <td><?= $datos->precio ?></td>
                                        <td><?= $datos->numero_puertas ?></td>
                                        <td><?= $datos->color ?></td>
                                        <td><?= $datos->id_seguro ?></td>
                                        <td><?= $datos->id_servicio ?></td>
                                        <td><?= $datos->id_garantia ?></td>
                                        <td><?= $datos->costo ?></td>
                                        <td><?= $datos->descuento ?></td>
                                        <td><?= $datos->costo_de_venta ?></td>
                                        <td>
                                            <a href="update_auto.php?id=<?= $datos->id ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="eliminar_empleado.php?id=<?= $datos->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                $mensaje_busqueda = 'No se encontró ningún auto con el ID especificado.';
                            }
                        } else {
                            $mensaje_busqueda = 'Por favor, proporcione un ID válido.';
                        }
                        ?>
                    </tbody>
                </table>
                <?php if (!empty($mensaje_busqueda)) { ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $mensaje_busqueda; ?>
                    </div>
                <?php } ?>
            </div>

            <!-- Formulario para buscar autos por ID -->
            <form class="col-12 p-3" action="form_buscar_por_id_auto.php" method="POST">
                <h3 class="text-center text-secondary">Búsqueda por ID</h3>
                <div class="mb-3">
                    <label for="id" class="form-label">ID del AUTO</label>
                    <input type="number" class="form-control" name="id" required min="1" style="width: 100px;">
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>
    </div>

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


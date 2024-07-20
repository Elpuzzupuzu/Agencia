<?php
session_start(); // Iniciar sesión para obtener el mensaje de éxito

// Verificar si hay un mensaje almacenado en la sesión
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']); // Eliminar el mensaje para que no se muestre más de una vez
} else {
    $mensaje = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busqueda por id</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .negative-margin {
            margin-bottom: -10px; /* Ajusta el valor según tus necesidades */
        }
    </style>
</head>
<body>
    <h1 class="text-center p-3">Agencia busqueda por ID
        <br>
        <a href="./index.php" class="btn btn-primary">Regresar al menú</a>
    </h1>

    <div class="container-fluid" style="display: flex;">
        <div class="row">
            <!-- Formulario para buscar músicos por ID -->
            <form class="col-4 p-3 negative-margin" action="form_buscar_por_id_empleado.php" method="POST">
                <h3 class="text-center text-secondary">Búsqueda por ID</h3>
                <div class="mb-3">
                    <label for="id" class="form-label">ID del Músico</label>
                    <input type="number" class="form-control" name="id" required min="1" style="width: 150px;">

                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>

            <!-- Tabla para mostrar todos los músicos -->
            <div class="col-8 p-4 negative-margin">
                <?php if (!empty($mensaje)) { ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $mensaje; ?>
                    </div>
                <?php } ?>
                <table class="table">
                    <thead class="bg-info">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">id_contrato</th>
                            <th scope="col">id_cuenta</th>
                            <th scope="col">id turno</th>
                            <th scope="col">capacitacion</th>
                            <th scope="col">direccion</th>
                            <th scope="col">ciudad</th>
                            <th scope="col">codigo postal</th>
                            <th scope="col">infonavit</th>
                            <th scope="col">seguro_social</th>
                            <th scope="col">afore</th>
                            <th scope="col">vacaciones</th>
                            
                            

                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conec.php";

                        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
                            $id = intval($_POST['id']); // Asegúrate de que el ID es un número entero

                            $sql = $conection->prepare("CALL sp_buscar_empleado_por_id(?)");
                            $sql->bind_param("i", $id);
                            $sql->execute();
                            $result = $sql->get_result();

                            if ($result->num_rows > 0) {
                                while ($datos = $result->fetch_object()) { ?>
                                    <tr>
                                        <td><?= $datos->id ?></td>
                                        <td><?= $datos->nombre ?></td>
                                        <td><?= $datos->apellido ?></td>
                                        <td><?= $datos->id_contrato ?></td>
                                        <td><?= $datos->id_numero_de_cuenta ?></td>
                                        <td><?= $datos->id_turno?></td>
                                        <td><?= $datos->capacitacion?></td>
                                        <td><?= $datos->direccion ?></td>
                                        <td><?= $datos->ciudad ?></td>
                                        <td><?= $datos->cpostal ?></td>
                                        <td><?= $datos->infonavit ?></td>
                                        <td><?= $datos->seguro_social ?></td>
                                        <td><?= $datos->afore ?></td>
                                        <td><?= $datos->vacaciones ?></td>




                                        <td>
                                            <a href="editar_empleado.php?id=<?= $datos->id ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="eliminar_empleado.php?id=<?= $datos->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?');">Eliminar</a>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td colspan='11'>No se encontraron músicos con el ID especificado.</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11'>Por favor, proporcione un ID válido.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
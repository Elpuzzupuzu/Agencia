<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia lista de autos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        h1 {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 30px;
            border-radius: 5px;
            position: relative;
        }

        h1 a#regresar {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        h1 a#regresar:hover {
            background-color: #0056b3;
        }

        .container-fluid {
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
        }

        .table {
            background-color: #ffffff;
        }

        .bg-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>Lista de autos
        <br>
        <a id="regresar" href="gestionar_autos.php">Regresar al menú</a>
    </h1>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <table class="table table-striped">
                    <thead class="bg-info">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Numero de serie</th>
                            <th scope="col">Id estado</th>
                            <th scope="col">Id marca</th>
                            <th scope="col">Id modelo</th>
                            <th scope="col">No. Cilindros</th>
                            <th scope="col">disponibilidad</th>
                            <th scope="col">precio</th>
                            <th scope="col">numero puertas</th>
                            <th scope="col">color</th>
                            <th scope="col">id_seguro</th>
                            <th scope="col">id_servicio</th>
                            <th scope="col">id_garantia</th>
                            <th scope="col">costo</th>
                            <th scope="col">descuento</th>
                            <th scope="col">costo de venta</th>


                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "conec.php";
                        
                        // Llamar al procedimiento almacenado para obtener todos los músicos
                        $sql = $conection->query("CALL GetAllAutos()");
                        
                        while ($datos = $sql->fetch_object()) { ?>
                            <tr onmouseover="this.classList.add('table-primary')" onmouseout="this.classList.remove('table-primary')">
                                <td><?= $datos->id ?></td>
                                <td><?= $datos->numero_de_serie ?></td>
                                <td><?= $datos->id_estado ?></td>
                                <td><?= $datos->id_marca ?></td>
                                <td><?= $datos->id_modelo?></td>
                                <td><?= $datos->numero_cilindros?></td>
                                <td><?= $datos->disponibilidad?></td>
                                <td><?= $datos->precio?></td>
                                <td><?= $datos->numero_puertas?></td>
                                <td><?= $datos->color?></td>
                                <td><?= $datos->id_seguro?></td>
                                <td><?= $datos->id_servicio?></td>
                                <td><?= $datos->id_garantia?></td>
                                <td><?= $datos->costo?></td>
                                <td><?= $datos->descuento?></td>
                                <td><?= $datos->costo_de_venta?></td>
                                
                                <td></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <a href="gestionar_autos.php" class="btn">Volver al Inicio</a>


    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>

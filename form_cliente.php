<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Músicos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4 mb-4">Registro de Clientes</h1>
        <a href="./index.php" class="btn btn-primary mb-3">Regresar al menú</a>
        <?php
        session_start();
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='alert alert-success' role='alert'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
        }
        ?>
        <form class="col-4 p-3" action="registrar_cliente.php" method="POST">
            <h3 class="text-center text-secondary">Registrar Cliente</h3>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            
            <div class="mb-3">
                <label for="celular" class="form-label">celular</label> 
                <input type="text" class="form-control" id="celular" name="celular" required>
                    
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">correo</label>
                <input type="text" class="form-control" id="correo" name="correo" required>
            </div>

            <div class="mb-3">
                <label for="direccion" class="form-label">direccion</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>

            <div class="mb-3">
                <label for="identificacion" class="form-label">identificacion</label>
                <input type="text" class="form-control" id="identificacion" name="identificacion" required>
            </div>
            
            
            <button type="submit" class="btn btn-primary">Registrar Cliente</button>
        </form>
    </div>
</body>
</html>
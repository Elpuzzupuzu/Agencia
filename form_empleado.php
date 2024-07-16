<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Empleados</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-4 mb-4">Registro de Músicos</h1>
        <a href="./index.php" class="btn btn-primary mb-3">Regresar al menú</a>
        <?php
        session_start();
        if (isset($_SESSION['mensaje'])) {
            echo "<div class='alert alert-success' role='alert'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']); // Eliminar el mensaje después de mostrarlo
        }
        ?>
        <form class="col-4 p-3" action="registrar_musico.php" method="POST">
            <h3 class="text-center text-secondary">Registrar contrato</h3>
            <div class="mb-3">
                <label for="nombre" class="form-label">numero de contrato</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            
            <div class="mb-3">
                <label for="fechacontrato" class="form-label">Fecha de Contrato</label>
                <input type="date" class="form-control" id="fechacontrato" name="fechacontrato" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Registrar contrato</button>
        </form>


        <form class="col-4 p-3" action="registrar_musico.php" method="POST">
            <h3 class="text-center text-secondary">Registrar contrato</h3>
            <div class="mb-3">
                <label for="cuenta" class="form-label">numero de cuenta</label>
                <input type="text" class="form-control" id="cuenta" name="cuenta" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Registrar cuenta</button>
        </form>

        <form class="col-4 p-3" action="registrar_turno.php" method="POST">
            <h3 class="text-center text-secondary">Registrar turno</h3>
            <div class="mb-3">
                <label for="turno" class="form-label">numero de cuenta</label>
                <select class="form-select" id="turno" name="turno" required>
                    <option value="1">mañana</option>
                    <option value="2">tarde</option>
                    <option value="3">tarde</option>
                    <option value="4">turno a</option>
                    <option value="5">turno b</option>
                  
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Registrar turno</button>
        </form>



        <form class="col-4 p-3" action="registrar_musico.php" method="POST">
            <h3 class="text-center text-secondary">Registrar Músico</h3>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="mb-3">
                <label for="fechanacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="masculino">Masculino</option>
                    <option value="femenino">Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nacionalidad" class="form-label">Nacionalidad</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
            </div>
            <div class="mb-3">
                <label for="instrumento" class="form-label">Instrumento</label>
                <select class="form-select" id="instrumento" name="instrumento" required>
                    <option value="1">Violin</option>
                    <option value="2">Viola</option>
                    <option value="3">Violonchelo</option>
                    <option value="4">Contrabajo</option>
                    <option value="5">Arpa</option>
                    <option value="6">Flauta</option>
                    <option value="7">Oboe</option>
                    <option value="8">Clarinete</option>
                    <option value="9">Fagot</option>
                    <option value="10">Trompeta</option>
                    <option value="11">Trombón</option>
                    <option value="12">Tuba</option>
                    <option value="13">Corno</option>
                    <option value="14">Tambor</option>
                    <option value="15">Piano</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="fechaingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" id="fechaingreso" name="fechaingreso" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="estado">Estado</label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="estado" name="estado" value="activo">
                    <label class="form-check-label" for="estado">Activo/Inactivo</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="temporada" class="form-label">Temporada</label>
                <select class="form-select" id="temporada" name="temporada" required>
                    <option value="1">Concierto de primavera</option>
                    <option value="2">Festival de Verano</option>
                    <option value="3">Recital de Otoño</option>
                    <option value="4">Gala de Invierno</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Músico</button>
        </form>
    </div>
</body>
</html>
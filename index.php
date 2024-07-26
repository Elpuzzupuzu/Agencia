<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agencia de Coches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .section-title {
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .card-text {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Agencia de Coches</h1>
        
        <!-- Sección de Administrador -->
        <div class="section-title">Administrador</div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de Usuarios</h5>
                        <p class="card-text">Administrar los usuarios del sistema.</p>
                        <a href="gestionar_usuarios.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reportes</h5>
                        <p class="card-text">Generar y ver reportes.</p>
                        <a href="reportes.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de Asesor -->
        <div class="section-title">Asesor</div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Clientes</h5>
                        <p class="card-text">Ver y gestionar clientes.</p>
                        <a href="clientes.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Citas</h5>
                        <p class="card-text">Gestionar citas con clientes.</p>
                        <a href="citas.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de Ventas -->
        <div class="section-title">Ventas</div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Transacciones</h5>
                        <p class="card-text">Registrar y ver transacciones.</p>
                        <a href="insertar_transaccion.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ventas</h5>
                        <p class="card-text">Ver y gestionar ventas.</p>
                        <a href="ventas.php" class="btn btn-primary">Ir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

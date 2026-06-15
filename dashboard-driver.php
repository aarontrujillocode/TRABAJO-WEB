<?php

session_start();

require_once 'includes/conexion.php';

if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['rol'] != 'motorizado'){
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Motorizado | Drive Moto</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="css/dashboard-driver.css">

</head>

<body>

<div class="sidebar">

    <div>

        <div class="logo">
            DRIVE MOTO
        </div>

        <ul class="menu">

            <li class="active">
                <a href="#">
                    <i class="bi bi-speedometer2"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-bell-fill"></i>
                    Solicitudes
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-map-fill"></i>
                    Viajes Activos
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-wallet-fill"></i>
                    Ganancias
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-clock-history"></i>
                    Historial
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-person-fill"></i>
                    Perfil
                </a>
            </li>

        </ul>

    </div>

    <div class="driver-profile">

        <img src="https://i.pravatar.cc/100?img=15">

        <div>
            <h6><?php echo $_SESSION['nombre']; ?></h6>
            <small>
<?php echo ucfirst($_SESSION['rol']); ?>
</small>
        </div>

    </div>

</div>

<div class="main-content">

    <div class="topbar">

        <div>
            <h3>Panel del Motorizado 🛵</h3>
            <span>Gestiona tus viajes y ganancias</span>
        </div>

<div class="top-actions">

    <span class="status-online">
        Disponible
    </span>

    <a href="logout.php" class="btn-logout">
        <i class="bi bi-box-arrow-right"></i>
        Salir
    </a>

</div>

    </div>

    <!-- ESTADISTICAS -->

    <div class="row g-4">

        <div class="col-lg-3">

            <div class="stat-card">

                <div>
                    <span>Ganancia Hoy</span>
                    <h2>S/ 180</h2>
                </div>

                <i class="bi bi-cash-stack"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="stat-card">

                <div>
                    <span>Viajes Hoy</span>
                    <h2>12</h2>
                </div>

                <i class="bi bi-scooter"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="stat-card">

                <div>
                    <span>Calificación</span>
                    <h2>4.9</h2>
                </div>

                <i class="bi bi-star-fill"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="stat-card">

                <div>
                    <span>Pedidos</span>
                    <h2>5</h2>
                </div>

                <i class="bi bi-box-seam"></i>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <!-- MAPA -->

        <div class="col-lg-8">

            <div class="map-card">

                <h5>Mapa en Tiempo Real</h5>

                <div id="map">
                    GOOGLE MAPS
                </div>

            </div>

        </div>

        <!-- SOLICITUDES -->

        <div class="col-lg-4">

            <div class="requests-card">

                <h5>Solicitudes Cercanas</h5>

                <div class="request-item">

                    <strong>Miraflores</strong>

                    <p>Destino: San Isidro</p>

                    <span>S/ 12.00</span>

                    <button class="btn-accept">
                        Aceptar
                    </button>

                </div>

                <div class="request-item">

                    <strong>Surco</strong>

                    <p>Destino: Barranco</p>

                    <span>S/ 15.00</span>

                    <button class="btn-accept">
                        Aceptar
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- HISTORIAL -->

    <div class="history-card mt-4">

        <h5>Últimos Viajes</h5>

        <table class="table table-dark table-hover">

            <thead>

                <tr>
                    <th>Código</th>
                    <th>Cliente</th>
                    <th>Destino</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>#DM102</td>
                    <td>Juan Pérez</td>
                    <td>San Isidro</td>
                    <td>S/18</td>
                    <td>
                        <span class="badge bg-success">
                            Finalizado
                        </span>
                    </td>
                </tr>

                <tr>
                    <td>#DM101</td>
                    <td>María López</td>
                    <td>Miraflores</td>
                    <td>S/14</td>
                    <td>
                        <span class="badge bg-warning">
                            En Curso
                        </span>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
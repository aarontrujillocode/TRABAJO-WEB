<?php

session_start();

require_once 'includes/conexion.php';
if(isset($_POST['solicitar'])){

    $origen = trim($_POST['origen']);
    $destino = trim($_POST['destino']);
    $precio = trim($_POST['precio']);

    $id_cliente = $_SESSION['id_usuario'];

    $sql = "INSERT INTO solicitudes
    (
        id_cliente,
        origen,
        destino,
        precio
    )
    VALUES
    (
        '$id_cliente',
        '$origen',
        '$destino',
        '$precio'
    )";

    if(mysqli_query($conn,$sql)){

        $mensaje = "✅ Solicitud enviada correctamente";

    }else{

        $mensaje = "❌ Error al enviar solicitud";
    }
}
if(!isset($_SESSION['id_usuario'])){
    header("Location: login.php");
    exit();
}

if($_SESSION['rol'] != 'cliente'){
    header("Location: login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
 
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Usuario | Drive Moto</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link rel="stylesheet" href="css/dashboard-user.css">

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
                    <i class="bi bi-house-door-fill"></i>
                    Inicio
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-scooter"></i>
                    Solicitar Viaje
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="bi bi-geo-alt-fill"></i>
                    Viajes Activos
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
                    <i class="bi bi-credit-card-fill"></i>
                    Pagos
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

    <div class="user-box">

        <img src="https://i.pravatar.cc/150?img=12">

        <div>
            <h6><?php echo $_SESSION['nombre']; ?></h6>
            <small>Cliente</small>
        </div>

    </div>

</div>

<div class="main-content">

    <div class="topbar">

        <div>
            <h3>Bienvenido 👋</h3>
            <span>Solicita un viaje o delivery</span>
        </div>

<div class="icons">

    <i class="bi bi-bell-fill"></i>

    <i class="bi bi-gear-fill"></i>

    <a href="logout.php" class="btn-logout">
        <i class="bi bi-box-arrow-right"></i>
        Salir
    </a>

</div>

    </div>

    <div class="row g-4">

        <div class="col-lg-3">

            <div class="card-stat">

                <div>
                    <span>Viajes</span>
                    <h2>25</h2>
                </div>

                <i class="bi bi-scooter"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card-stat">

                <div>
                    <span>Activos</span>
                    <h2>2</h2>
                </div>

                <i class="bi bi-geo-alt-fill"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card-stat">

                <div>
                    <span>Gastado</span>
                    <h2>S/540</h2>
                </div>

                <i class="bi bi-cash-stack"></i>

            </div>

        </div>

        <div class="col-lg-3">

            <div class="card-stat">

                <div>
                    <span>Calificación</span>
                    <h2>4.9</h2>
                </div>

                <i class="bi bi-star-fill"></i>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="map-card">

                <div class="section-title">
                    Mapa en Tiempo Real
                </div>
<div id="map">

    <iframe
        src="https://www.google.com/maps?q=Lima,Peru&output=embed"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy">
    </iframe>

</div>

            </div>

        </div>

        <div class="col-lg-4">

           <div class="request-card">

    <h4>Solicitar Viaje</h4>

    <?php if(!empty($mensaje)): ?>

        <div class="alert alert-success">
            <?php echo $mensaje; ?>
        </div>

    <?php endif; ?>

    <form method="POST">
<input
type="text"
name="origen"
class="form-control mb-3"
placeholder="Origen"
required>

<input
type="text"
name="destino"
class="form-control mb-3"
placeholder="Destino"
required>

<input
type="number"
step="0.01"
name="precio"
class="form-control mb-3"
placeholder="Precio Propuesto"
required>

<button
type="submit"
name="solicitar"
class="btn-request">

    Buscar Motorizado

</button>
</form>
            </div>

        </div>

    </div>

    <div class="history-card mt-4">

        <div class="section-title">
            Últimos Viajes
        </div>

        <table class="table table-dark table-hover">

            <thead>

                <tr>
                    <th>Código</th>
                    <th>Destino</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>#DM001</td>
                    <td>San Isidro</td>
                    <td>12/06/2026</td>
                    <td><span class="badge bg-success">Finalizado</span></td>
                </tr>

                <tr>
                    <td>#DM002</td>
                    <td>Miraflores</td>
                    <td>11/06/2026</td>
                    <td><span class="badge bg-warning">En Curso</span></td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>
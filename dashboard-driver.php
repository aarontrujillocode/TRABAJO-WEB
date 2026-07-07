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
$id_motorizado = $_SESSION['id_usuario'];
$viaje_activo = null;

// Buscar si el motorizado tiene un viaje asignado que no haya terminado o cancelado
$sql_viaje = "SELECT v.*, u.nombres, u.apellidos, u.telefono 
              FROM viajes v
              JOIN usuarios u ON v.id_cliente = u.id_usuario
              WHERE v.id_motorizado = '$id_motorizado' 
                AND v.estado IN ('aceptado', 'en_curso') 
              LIMIT 1";

$res_viaje = mysqli_query($conn, $sql_viaje);
if(mysqli_num_rows($res_viaje) > 0) {
    $viaje_activo = mysqli_fetch_assoc($res_viaje);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Motorizado | Drive Moto</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script>
// Declaramos las variables globales que el script driver-map.js va a leer de forma automática
const tieneViajeActivo = <?php echo $viaje_activo ? 'true' : 'false'; ?>;
const destinoTextoGlobal = "<?php echo $viaje_activo ? addslashes($viaje_activo['destino']) : ''; ?>";
</script>       
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard-driver.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
<script>
    
// Validamos si desde PHP existe un viaje activo
const tieneViajeActivo = <?php echo $viaje_activo ? 'true' : 'false'; ?>;

if (tieneViajeActivo) {
    const origenTexto = "<?php echo addslashes($viaje_activo['origen']); ?>";
    const destinoTexto = "<?php echo addslashes($viaje_activo['destino']); ?>";

    // Esperamos un segundo a que el mapa base ('map') esté iniciado por driver-map.js
    setTimeout(() => {
        if (typeof map !== 'undefined' && map !== null) {
            trazarRutaExclusivaDriver(origenTexto, destinoTexto);
        }
    }, 1200);
}
function trazarRutaExclusivaDriver(origen, destino) {
    // 1. Obtener la ubicación GPS en tiempo real del marcador del motorizado
    if (!marker || typeof marker.getLatLng !== 'function') {
        console.error("El GPS del motorizado aún no está listo.");
        return;
    }
    
    // Este es el PUNTO A (Donde estás tú físicamente ahora mismo)
    const coordOrigen = marker.getLatLng(); 

    // 2. Para el destino (PUNTO B), seguimos buscando el texto agregando el filtro de Lima
    const destinoFijo = destino + ", Lima, Perú";
    const urlGeocode = (busqueda) => `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(busqueda)}`;

    fetch(urlGeocode(destinoFijo))
        .then(res => res.json())
        .then(dataDestino => {
            if (dataDestino.length === 0) return console.error("No se encontró el destino: " + destinoFijo);
            
            // Este es el PUNTO B (A dónde vas)
            const coordDestino = L.latLng(dataDestino[0].lat, dataDestino[0].lon);

            // Limpiar rutas previas
            if (window.routingControl) {
                map.removeControl(window.routingControl);
            }

            // Trazamos la ruta REAL desde donde estás tú (GPS) hacia el destino del cliente
            window.routingControl = L.Routing.control({
                waypoints: [
                    coordOrigen,  // Tu ubicación GPS actual
                    coordDestino  // El destino final
                ],
                addWaypoints: false,
                draggableWaypoints: false,
                fitSelectedRoutes: true,
                show: false, 
                collapsible: true,
                lineOptions: {
                    styles: [
                        { color: '#000000', opacity: 0.7, weight: 10 }, // Sombra de contraste
                        { color: '#ffc107', opacity: 1, weight: 6 }     // Línea amarilla Drive Moto
                    ]
                }
            }).addTo(map);

            setTimeout(() => {
                map.invalidateSize();
            }, 200);

        })
        .catch(err => console.error("Error al trazar ruta desde GPS:", err));
}
</script>
<style>
.leaflet-overlay-pane path {
    stroke-dasharray: none !important;
    stroke-linejoin: round !important;
    stroke-linecap: round !important;
}
</style>
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
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-bell-fill"></i> Solicitudes
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-map-fill"></i> Viajes Activos
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-wallet-fill"></i> Ganancias
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-clock-history"></i> Historial
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="bi bi-person-fill"></i> Perfil
                </a>
            </li>
        </ul>
    </div>

    <div class="driver-profile">
        <img src="https://i.pravatar.cc/100?img=15" alt="Perfil">
        <div>
            <h6><?php echo isset($_SESSION['nombre']) ? $_SESSION['nombre'] : 'Conductor'; ?></h6>
            <small><?php echo ucfirst($_SESSION['rol']); ?></small>
        </div>
    </div>
</div>

<div class="main-content">
    <div class="topbar">
        <div>
            <h3>Panel del Motorizado 🛵</h3>
            <span class="text-muted">Gestiona tus viajes y ganancias</span>
            <div class="driver-location mt-2">
                <i class="bi bi-geo-alt-fill text-danger"></i>
                <span id="ubicacion">Obteniendo ubicación...</span>
            </div>
        </div>

        <div class="top-actions">
            <div class="driver-status">
                <label class="switch">
                    <input type="checkbox" id="estadoDriver" checked>
                    <span class="slider"></span>
                </label>
                <span id="textoEstado">Disponible</span>
            </div>
            <a href="logout.php" class="btn-logout text-decoration-none">
                <i class="bi bi-box-arrow-right"></i> Salir
            </a>
        </div>
    </div>

    <!-- ESTADISTICAS -->
    <div class="row g-4">
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <span>Ganancia Hoy</span>
                    <h2>S/ 180</h2>
                </div>
                <i class="bi bi-cash-stack text-success"></i>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <span>Viajes Hoy</span>
                    <h2>12</h2>
                </div>
                <i class="bi bi-scooter text-primary"></i>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <span>Calificación</span>
                    <h2>4.9</h2>
                </div>
                <i class="bi bi-star-fill text-warning"></i>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="stat-card">
                <div>
                    <span>Pedidos</span>
                    <h2>5</h2>
                </div>
                <i class="bi bi-box-seam text-info"></i>
            </div>
        </div>
    </div>

    <!-- CUERPO PRINCIPAL (MAPA Y SOLICITUDES) -->
    <div class="row mt-4 g-4">
        <!-- MAPA -->
        <div class="col-xl-9 col-lg-8">
            <div class="map-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">🛰️ Mapa en Tiempo Real</h5>
                    <span class="badge bg-success">📍 Los Olivos, Lima</span>
                </div>
                <div id="map" style="min-height: 450px; border-radius: 15px;"></div>
            </div>
        </div>

<!-- SECCIÓN DE ACCIÓN (SOLICITUDES O VIAJE ACTIVO) -->
<div class="col-xl-3 col-lg-4">
    
    <?php if($viaje_activo): ?>
        <!-- VISTA DE VIAJE ACTIVO -->
        <div class="card bg-dark border-warning text-white h-100 p-3">
            <h5 class="text-warning mb-3">
                <i class="bi bi-geo-alt-fill animate-pulse"></i> Viaje en Curso
            </h5>
            
            <div class="mb-3 p-2 bg-secondary rounded-2">
                <small class="text-light d-block">Cliente:</small>
                <strong><?php echo $viaje_activo['nombres'] . " " . $viaje_activo['apellidos']; ?></strong>
                <br>
                <small class="text-light"><i class="bi bi-telephone"></i> <?php echo $viaje_activo['telefono']; ?></small>
            </div>

            <div class="mb-2">
                <i class="bi bi-record-circle text-success me-1"></i>
                <small class="text-muted">Origen:</small>
                <p class="mb-1 small fw-bold"><?php echo htmlspecialchars($viaje_activo['origen']); ?></p>
            </div>

            <div class="mb-3">
                <i class="bi bi-flag-fill text-danger me-1"></i>
                <small class="text-muted">Destino:</small>
                <p class="mb-1 small fw-bold"><?php echo htmlspecialchars($viaje_activo['destino']); ?></p>
            </div>

            <div class="mb-4 text-center p-2 bg-black rounded-3">
                <span class="text-muted small d-block">Monto a Cobrar:</span>
                <h3 class="text-success mb-0 fw-bold">S/ <?php echo number_format($viaje_activo['precio'], 2); ?></h3>
            </div>

            <!-- BOTONES DE ACCIÓN DEL FLUJO -->
            <div class="mt-auto">
                <?php if($viaje_activo['estado'] == 'aceptado'): ?>
                    <a href="cambiar_estado_viaje.php?id=<?php echo $viaje_activo['id_viaje']; ?>&nuevo_estado=en_curso" class="btn btn-warning w-100 py-2 fw-bold">
                        <i class="bi bi-scooter"></i> Iniciar Viaje
                    </a>
                <?php else: ?>
                    <a href="cambiar_estado_viaje.php?id=<?php echo $viaje_activo['id_viaje']; ?>&nuevo_estado=finalizado" class="btn btn-success w-100 py-2 fw-bold">
                        <i class="bi bi-check-circle-fill"></i> Terminar Viaje
                    </a>
                <?php endif; ?>
            </div>
        </div>

    <?php else: ?>
        <!-- VISTA NORMAL: BUSCANDO SOLICITUDES -->
        <div class="requests-card h-100">
            <h5 class="mb-3">Solicitudes Cercanas</h5>

            <?php if(isset($_SESSION['mensaje'])){ ?>
                <div class="alert alert-info py-2">
                    <?php 
                        echo $_SESSION['mensaje']; 
                        unset($_SESSION['mensaje']);
                    ?>
                </div>
            <?php } ?>

            <div id="contenedorSolicitudes" class="requests-container" style="max-height: 450px; overflow-y: auto;">
                <div class="text-muted text-center py-4">Buscando solicitudes en tu zona...</div>
            </div>
        </div>
    <?php endif; ?>

</div>
    <!-- HISTORIAL DE ULTIMOS VIAJES -->
    <div class="history-card mt-4 p-4">
        <h5 class="mb-3">Últimos Viajes</h5>
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
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
                        <td class="fw-bold text-success">S/ 18.00</td>
                        <td><span class="badge bg-success">Finalizado</span></td>
                    </tr>
                    <tr>
                        <td>#DM101</td>
                        <td>María López</td>
                        <td>Miraflores</td>
                        <td class="fw-bold text-success">S/ 14.00</td>
                        <td><span class="badge bg-warning text-dark">En Curso</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Lógica para el Mapa y Actualizaciones en Tiempo Real -->
<script src="js/driver-map.js"></script>
<script>
// Función asíncrona para consultar solicitudes pendientes en segundo plano
function actualizarSolicitudes() {
    fetch('obtener_solicitudes.php')
    .then(response => response.json())
    .then(data => {
        const contenedor = document.getElementById('contenedorSolicitudes');
        
        if (data.length === 0) {
            contenedor.innerHTML = '<div class="text-muted text-center py-4">Esperando nuevas solicitudes...</div>';
            return;
        }
        
        let html = '';
        data.forEach(solicitud => {
            html += `
                <div class="request-item p-3 border border-secondary rounded mb-3 bg-dark-subtle">
                    <div class="mb-2">
                        <i class="bi bi-geo-alt text-success me-1"></i>
                        <strong>${solicitud.origen}</strong>
                    </div>
                    <div class="mb-3 text-muted small">
                        <i class="bi bi-arrow-right-short me-1"></i>
                        Destino: ${solicitud.destino}
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-success fs-5">
                            S/ ${solicitud.precio}
                        </span>
                        <a href="aceptar_solicitud.php?id=${solicitud.id_solicitud}" class="btn btn-success btn-sm px-3 fw-bold btn-accept">
                            Aceptar
                        </a>
                    </div>
                </div>
            `;
        });
        
        contenedor.innerHTML = html;
    })
    .catch(error => console.error('Error al actualizar solicitudes:', error));
}

// Carga inicial al entrar al panel
actualizarSolicitudes();

// Bucle repetitivo cada 3000 ms (3 segundos) para actualización inmediata
setInterval(actualizarSolicitudes, 3000);
</script>

</body>
</html>
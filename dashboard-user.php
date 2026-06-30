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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link
rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script
src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>
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
<div id="map" style="height:450px;border-radius:15px;"></div>

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

<div class="request-card">

    <h4 class="mb-4">
        <i class="bi bi-scooter"></i>
        Solicitar Viaje
    </h4>

    <form method="POST">

        <!-- ORIGEN -->

        <div class="mb-3">

            <label class="form-label">
                <i class="bi bi-crosshair text-success"></i>
                Punto de origen
            </label>

            <div class="input-group">

                <input
                    type="text"
                    id="origen"
                    name="origen"
                    class="form-control"
                    placeholder="Obteniendo ubicación..."
                    readonly
                    required>

                <button
                    class="btn btn-success"
                    type="button"
                    onclick="obtenerUbicacion()">

                    <i class="bi bi-geo-alt-fill"></i>

                </button>

            </div>

        </div>

        <!-- DESTINO -->

<div class="mb-3">

    <label class="form-label">
        <i class="bi bi-flag-fill text-danger"></i>
        Destino
    </label>

    <input
        type="text"
        id="destino"
        name="destino"
        class="form-control"
        placeholder="Escribe un distrito o dirección..."
        autocomplete="off"
        required>

    <div
        id="listaDestinos"
        class="list-group mt-2">
    </div>

</div>

<!-- DISTANCIA -->

<div class="mb-3">

    <label class="form-label">
        <i class="bi bi-signpost-2-fill text-primary"></i>
        Distancia
    </label>

    <input
        type="text"
        id="distancia"
        class="form-control"
        readonly>

</div>

<!-- TIEMPO -->

<div class="mb-3">

    <label class="form-label">
        <i class="bi bi-clock-fill text-info"></i>
        Tiempo estimado
    </label>

    <input
        type="text"
        id="tiempo"
        class="form-control"
        readonly>

</div>

<!-- PRECIO -->

<div class="mb-4">

    <label class="form-label">
        <i class="bi bi-cash-stack text-warning"></i>
        Precio sugerido
    </label>

    <div class="input-group">

        <span class="input-group-text">
            S/
        </span>

        <input
            type="text"
            id="precio"
            name="precio"
            class="form-control"
            readonly>

    </div>

</div>
<button
    type="submit"
    name="solicitar"
    class="btn btn-warning w-100 py-3 fw-bold">

    <i class="bi bi-search"></i>
    Buscar Motorizado

</button>
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
<script>
const destino = document.getElementById("destino");
const lista = document.getElementById("listaDestinos");

destino.addEventListener("input", function(){

    let texto = this.value.trim();

    if(texto.length < 3){
        lista.innerHTML = "";
        lista.style.display = "none";
        return;
    }

    fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(texto + ", Lima Peru")}&limit=6`)

    .then(res => res.json())

    .then(data => {

        lista.innerHTML = "";
        lista.style.display = "block";

        data.features.forEach(function(lugar){

            let nombre = "";

            if(lugar.properties.name){
                nombre += lugar.properties.name;
            }

            if(lugar.properties.street){
                nombre += " - " + lugar.properties.street;
            }

            if(lugar.properties.city){
                nombre += " (" + lugar.properties.city + ")";
            }

            let item = document.createElement("a");

            item.href="#";

            item.className="list-group-item list-group-item-action";

            item.innerHTML=
            `<i class="bi bi-geo-alt-fill text-danger"></i>
             ${nombre}`;

            item.onclick=function(e){

                e.preventDefault();

                destino.value = nombre;

                window.latDestino = lugar.geometry.coordinates[1];
                window.lngDestino = lugar.geometry.coordinates[0];

                if(markerDestino){
                    map.removeLayer(markerDestino);
                }

                markerDestino = L.marker([
                    window.latDestino,
                    window.lngDestino
                ]).addTo(map);

                map.setView([
                    window.latDestino,
                    window.lngDestino
                ],16);

                lista.innerHTML="";
                lista.style.display="none";

                calcularRuta();

            }

            lista.appendChild(item);

        });

    });

});

let map;
let markerOrigen;
let markerDestino;
let ruta;

function iniciarMapa(){

    map = L.map('map').setView([-12.046374,-77.042793],13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
        attribution:'© OpenStreetMap'
    }).addTo(map);

    markerOrigen = L.marker([-12.046374,-77.042793]).addTo(map);

    obtenerUbicacion();
    map.on('click', function(e){

    let lat = e.latlng.lat;
    let lng = e.latlng.lng;

    if(markerDestino){

        map.removeLayer(markerDestino);

    }

    markerDestino = L.marker([lat,lng]).addTo(map);

    window.latDestino = lat;
    window.lngDestino = lng;

    // Obtener dirección
fetch(`reverse.php?lat=${lat}&lon=${lng}`)
.then(response => response.json())
.then(data => {

    let a = data.address;

    let lugar =
        a.road ||
        a.neighbourhood ||
        a.suburb ||
        a.city_district ||
        a.village ||
        "";

    let distrito =
        a.suburb ||
        a.city_district ||
        a.city ||
        "";

document.getElementById("destino").value =
    lugar + ", " + distrito;

});

});

}

function obtenerUbicacion(){

    if(!navigator.geolocation){

        alert("Tu navegador no soporta GPS.");
        return;

    }

    navigator.geolocation.getCurrentPosition(

        function(pos){

let lat = pos.coords.latitude;
let lng = pos.coords.longitude;

window.latOrigen = lat;
window.lngOrigen = lng;

map.setView([lat,lng],16);

markerOrigen.setLatLng([lat,lng]);
//DESTINO
            fetch(`reverse.php?lat=${lat}&lon=${lng}`)
.then(response => response.json())
.then(data => {

fetch(`reverse.php?lat=${lat}&lon=${lng}`)
.then(response => response.json())
.then(data => {

    console.log(data);

    if(data.address){

        let a = data.address;

        let direccion = "";

        if(a.road){
            direccion += a.road;
        }

        if(a.house_number){
            direccion += " " + a.house_number;
        }

        if(a.suburb){
            direccion += ", " + a.suburb;
        }

        if(a.city){
            direccion += ", " + a.city;
        }

        document.getElementById("origen").value = direccion;

    }else{

        document.getElementById("origen").value =
        data.display_name || "Ubicación encontrada";

    }

})
.catch(error=>{

    console.log(error);

});

})
.catch(error=>{

    console.log(error);

});

        },

        function(){

            alert("No se pudo obtener la ubicación.");

        }

    );

}
function calcularRuta(){

    if(!window.latOrigen || !window.latDestino){
        return;
    }

    fetch(`https://router.project-osrm.org/route/v1/driving/${window.lngOrigen},${window.latOrigen};${window.lngDestino},${window.latDestino}?overview=full&geometries=geojson`)

    .then(res=>res.json())

    .then(data=>{

        let km = data.routes[0].distance / 1000;
        let minutos = data.routes[0].duration / 60;

        let precio = 5 + (km * 2.5);

        document.getElementById("distancia").value =
            km.toFixed(2)+" km";

        document.getElementById("tiempo").value =
            Math.ceil(minutos)+" min";

        document.getElementById("precio").value =
            precio.toFixed(2);

        // Eliminar ruta anterior
        if(ruta){
            map.removeLayer(ruta);
        }

        // Dibujar la nueva ruta
        ruta = L.geoJSON(
            data.routes[0].geometry,
            {
                style:{
                    color:"#0d6efd",
                    weight:6
                }
            }
        ).addTo(map);

        // Ajustar el zoom para mostrar toda la ruta
        map.fitBounds(ruta.getBounds());

    });

}
window.onload = iniciarMapa;

</script>

</body>
</html>
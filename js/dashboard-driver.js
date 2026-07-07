let map;
let marker;

function iniciarMapa(){

    map = L.map('map').setView([-12.046374,-77.042793],13);

    L.tileLayer(

        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',

        {

            attribution:'© OpenStreetMap'

        }

    ).addTo(map);

    marker = L.marker([-12.046374,-77.042793]).addTo(map);

    obtenerUbicacion();

}
function obtenerUbicacion(){

    if(!navigator.geolocation){

        alert("El navegador no soporta GPS");

        return;

    }

    navigator.geolocation.getCurrentPosition(

        function(pos){

            let lat = pos.coords.latitude;

            let lng = pos.coords.longitude;

            map.setView([lat,lng],16);

            marker.setLatLng([lat,lng]);

            obtenerDireccion(lat,lng);

        },

        function(){

            alert("No se pudo obtener la ubicación");

        }

    );

}
function obtenerDireccion(lat, lng){

    fetch(`reverse.php?lat=${lat}&lon=${lng}`)

    .then(res=>res.json())

    .then(data=>{

        console.log(data);

    });

}
window.onload = iniciarMapa;
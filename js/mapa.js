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
}
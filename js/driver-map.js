let map;
let marker;

function iniciarMapa() {
    // Inicializar el mapa centrado en Lima por defecto
    map = L.map("map").setView([-12.046374, -77.042793], 13);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap"
    }).addTo(map);

    marker = L.marker([-12.046374, -77.042793]).addTo(map);

    // Ejecutar ubicación del GPS del motorizado
    obtenerUbicacion();
}

function obtenerUbicacion() {
    if (!navigator.geolocation) {
        alert("Tu navegador no soporta GPS");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(pos) {
            let lat = pos.coords.latitude;
            let lng = pos.coords.longitude;

            // 1. Actualiza el marcador con tu posición real
            marker.setLatLng([lat, lng]);

            // 2. 🔥 CAMBIA EL TEXTO GRIS "Obteniendo ubicación..." POR TU DIRECCIÓN REAL
            obtenerDireccionTextoReal(lat, lng);

            // 3. SI NO TIENE UN VIAJE ACTIVO: Centra la cámara en su GPS
            if (typeof tieneViajeActivo !== 'undefined' && !tieneViajeActivo) {
                map.setView([lat, lng], 16);
            }

            // 4. Si tiene un viaje activo, dibuja la ruta usando tus coordenadas 'lat' y 'lng'
            if (typeof tieneViajeActivo !== 'undefined' && tieneViajeActivo && typeof destinoTextoGlobal !== 'undefined' && destinoTextoGlobal !== '') {
                trazarRutaDesdeGPS(lat, lng, destinoTextoGlobal);
            }
        },
        function() {
            console.log("No se pudo obtener la ubicación exacta por GPS.");
            const txtUbicacion = document.getElementById("ubicacion");
            if (txtUbicacion) txtUbicacion.innerText = "GPS Desactivado";
        }
    );
}

// NUEVA FUNCIÓN: Traduce tus coordenadas actuales a texto de calle/distrito
function obtenerDireccionTextoReal(lat, lng) {
    const urlReverse = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;
    
    fetch(urlReverse)
        .then(res => res.json())
        .then(data => {
            const txtUbicacion = document.getElementById("ubicacion");
            if (!txtUbicacion) return;

            if (data && data.display_name) {
                const partes = data.display_name.split(', ');
                // Tomamos las primeras 3 partes (ejemplo: Av. Universitaria, Los Olivos, Lima)
                const direccionCorta = partes.slice(0, 3).join(', ');
                
                // Pintamos el texto directamente debajo del título del panel
                txtUbicacion.innerText = direccionCorta;
            } else {
                txtUbicacion.innerText = "Dirección no encontrada";
            }
        })
        .catch(err => {
            console.error("Error al obtener dirección en texto:", err);
        });
}

// FUNCIÓN DE LA RUTA: Adaptada para recibir tu lat y lng reales del GPS
function trazarRutaDesdeGPS(lat, lng, destino) {
    const coordOrigen = L.latLng(lat, lng); 
    const destinoFijo = destino + ", Lima, Perú";
    const urlGeocode = (busqueda) => `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(busqueda)}`;

    fetch(urlGeocode(destinoFijo))
        .then(res => res.json())
        .then(dataDestino => {
            if (dataDestino.length === 0) return console.error("No se encontró el destino: " + destinoFijo);
            
            const coordDestino = L.latLng(dataDestino[0].lat, dataDestino[0].lon);

            if (window.routingControl) {
                map.removeControl(window.routingControl);
            }

            window.routingControl = L.Routing.control({
                waypoints: [coordOrigen, coordDestino],
                lineOptions: {
                    styles: [
                        { color: '#000000', opacity: 0.7, weight: 10 }, 
                        { color: '#FF0000', opacity: 1, weight: 6 }     
                    ]
                },
                addWaypoints: false,
                draggableWaypoints: false,
                fitSelectedRoutes: true, 
                show: false, 
                collapsible: true
            }).addTo(map);

            setTimeout(() => {
                map.invalidateSize();
            }, 250);
        })
        .catch(err => console.error("Error al trazar la ruta:", err));
}

window.onload = iniciarMapa;
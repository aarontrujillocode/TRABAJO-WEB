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
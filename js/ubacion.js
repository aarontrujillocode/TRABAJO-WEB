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
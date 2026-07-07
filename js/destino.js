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
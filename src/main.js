function initialize() {
    var markers = [];
    var copyrightNode;

    var map = new google.maps.Map(
        document.getElementById('map-canvas'),
        {
            zoom: 14,
            center: new google.maps.LatLng(40.4171, -3.7031)
        }
    );

    var input = /** @type {HTMLInputElement} */(
        document.getElementById('pac-input'));
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    var searchBox = new google.maps.places.SearchBox(
        /** @type {HTMLInputElement} */(input));

    google.maps.event.addListener(searchBox, 'places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }
        for (var i = 0, marker; marker = markers[i]; i++) {
            marker.setMap(null);
        }

        markers = [];
        var bounds = new google.maps.LatLngBounds();
        for (var i = 0, place; place = places[i]; i++) {
            var image = {
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            var marker = new google.maps.Marker({
                map: map,
                icon: image,
                title: place.name,
                position: place.geometry.location
            });

            markers.push(marker);

            bounds.extend(place.geometry.location);
        }

        map.fitBounds(bounds);
    });

    google.maps.event.addListener(map, 'bounds_changed', function() {
        var bounds = map.getBounds();
        searchBox.setBounds(bounds);
    });

    copyrightNode = document.createElement('div');
    copyrightNode.id = 'copyright-control';
    copyrightNode.index = 0;
    copyrightNode.innerHTML = 'C&oacute;digo fuente disponible en: <a href="https://github.com/skgsergio/Mapa-BiciMAD">https://github.com/skgsergio/Mapa-BiciMAD</a>';
    copyrightNode.style.fontSize = '10px';
    copyrightNode.style.color = '#000';
    copyrightNode.style.fontFamily = 'Roboto, Arial ,sans-serif';
    copyrightNode.style.padding = '0 5px 0 5px';
    copyrightNode.style.whiteSpace = 'nowrap';
    copyrightNode.style.backgroundColor = '#F5F5F5';
    copyrightNode.style.opacity = '0.7';
    copyrightNode.style.zIndex = 1000001;

    map.controls[google.maps.ControlPosition.BOTTOM_RIGHT].push(copyrightNode);

    $.getJSON("estaciones.php?sid=" + $("#sid").val(),
              function(data) {
                  jQuery.each(data["estaciones"], function(i, est) {
                      var marker = new google.maps.Marker({
                          map: map,
                          position: new google.maps.LatLng(est["latitud"], est["longitud"]),
                          title: est["nombre"],
                          icon: (est["activo"] == 1) ? "http://maps.google.com/mapfiles/marker_green.png" : "http://maps.google.com/mapfiles/marker.png"
                      });

                      var infoWindow = new google.maps.InfoWindow({
                          content: "<div><div><b>(" + est["numero_estacion"] + ") " + est["direccion"] + "</b></div><br /><div>Plazas libres: " + est["libres"] + "<br />Bicis disponibles: " + (est["numero_bases"] - est["libres"]) + "</div></div>"
                      });

                      google.maps.event.addListener(marker, 'click', function() {
                          infoWindow.open(map, marker);
                      });
                  });
              });
}

google.maps.event.addDomListener(window, 'load', initialize);

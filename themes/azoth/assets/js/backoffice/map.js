jQuery(function($){

    let map = L.map('map')

    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 0,
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'}).addTo(map);

    let marker = {};
    let latlng = $('#map').next().val();
    if(latlng) {
        marker = L.marker(latlng.split(','), {draggable: true}).addTo(map);

        // let markerBounds = L.latLngBounds([marker.getLatLng()]);
        // map.fitBounds(markerBounds);
        map.setView(latlng.split(','), 7);

        marker.on("dragend",function(e){

            let newPos = e.target.getLatLng();
            lat = newPos.lat.toFixed(5);
            lng = newPos.lng.toFixed(5);
            $('#map').next().val(lat + ',' + lng);
    
        });

        marker.on("click", function(e) {
            map.removeLayer(marker);
            $('#map').next().val('');
        });
    } else {
        map.setView([48.5112, 2.2055], 4);
    }

    map.on('click',function(e){
        lat = e.latlng.lat.toFixed(5);
        lng = e.latlng.lng.toFixed(5);

        //Clear existing marker,    
        if (marker) {
              map.removeLayer(marker);
        };

        //Add a marker.
        marker = L.marker(e.latlng, {draggable: true}).addTo(map);
        $('#map').next().val(lat + ', ' + lng);

        marker.on("dragend",function(e){

            let newPos = e.target.getLatLng();
            lat = newPos.lat.toFixed(5);
            lng = newPos.lng.toFixed(5);
            $('#map').next().val(lat + ', ' + lng);
    
        });

        marker.on("click", function(e) {
            map.removeLayer(marker);
            $('#map').next().val('');
        });
    });

    map.addControl(
        new L.Control.Search({
            url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat', 'lon'],
            autoCollapse: false,
            collapsed: false,
            autoType: true,
            minLength: 1,
            zoom: 7,
            marker: false,
            firstTipSubmit: true,
            hideMarkerOnCollapse: true,
            position: 'topleft',
        }).on('search:locationfound', function (e) {
            //Clear existing marker,    
            if (marker) {
                map.removeLayer(marker);
            }

            lat = e.latlng.lat.toFixed(5);
            lng = e.latlng.lng.toFixed(5);

            //Add a marker.
            marker = L.marker(e.latlng, {draggable: true}).addTo(map);
            $('#map').next().val(lat + ', ' + lng);

            marker.on("dragend",function(e){

                let newPos = e.target.getLatLng();
                lat = newPos.lat.toFixed(5);
                lng = newPos.lng.toFixed(5);
                $('#map').next().val(lat + ', ' + lng);
        
            });

            marker.on("click", function(e) {
                map.removeLayer(marker);
                $('#map').next().val('');
            });
        })
    );
});
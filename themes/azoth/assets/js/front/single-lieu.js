jQuery(function ($) {
	let map = L.map('map', {
		zoomControl: false,
	});
	L.control
		.zoom({
			position: 'topright',
		})
		.addTo(map);

	L.tileLayer(
		'https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}',
		{
			minZoom: 0,
			maxZoom: 20,
			attribution:
				'&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
			ext: 'png',
		}
	).addTo(map);

	let redIcon = L.icon({
		iconUrl: '/wp-content/themes/azoth/assets/images/marker.png',

		iconSize: [32, 45], // size of the icon
		iconAnchor: [16, 44], // point of the icon which will correspond to marker's location
		popupAnchor: [0, -39], // point from which the popup should open relative to the iconAnchor
	});

	let marker = {};
	let latlng = $('#map').next().val();
	if (latlng) {
		marker = L.marker(latlng.split(','), { icon: redIcon }).addTo(map);
		map.setView(latlng.split(','), 7);
	} else {
		map.setView([48.5112, 2.2055], 4);
	}
});

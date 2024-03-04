define(function (require) {

    var elgg = require("elgg");
    var $ = require('jquery');
    require('sm_leaflet_js');
    require('sm_leaflet_gpx');
    require('sm_leaflet_kml');

    // initialize status
    jQuery(function() {
        // initialize map
        // var map = L.map('mapid').setView([map_default_lat, map_default_lng], map_default_zoom);
        // var map = L.map('mapid').setView([51.505, -0.09], 13);
        // map.addLayer(editableLayers);
        
        var map = L.map('mapid').fitWorld();
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        // map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.

        var map_url = $("#murl").data("murl");  // get the map URL
        var map_type = $("#mtype").data("mtype");   // get the map file type

        if (map_type == 'gpx') {
            new L.GPX(map_url, {async: true}).on('loaded', function(e) {
                map.fitBounds(e.target.getBounds());
            }).addTo(map);
        }
        else if (map_type == 'kml') {
            fetch(map_url)
            .then(res => res.text())
            .then(kmltext => {
                // Create new kml overlay
                const parser = new DOMParser();
                const kml = parser.parseFromString(kmltext, 'text/xml');
                const track = new L.KML(kml);
                map.addLayer(track);
    
                // Adjust map to show the kml
                const bounds = track.getBounds();
                map.fitBounds(bounds);
            });
            // new L.KML(map_url, {async: true}).on('loaded', function(e) {
            //     map.fitBounds(e.target.getBounds());
            // }).addTo(map);
        }

        var map_objects = $("#mobjects").data("mobjects");   // get the map objects
        L.geoJSON(map_objects, {}).addTo(map);
                    
    });
    
});

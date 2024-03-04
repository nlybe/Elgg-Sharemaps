define(function (require) {

    var elgg = require("elgg");
    var $ = require('jquery');
    require('sm_leaflet_js');
    require('sm_leaflet_gpx');
    require('sm_leaflet_kml');
    require('sm_leaflet_fullscreen');

    // get plugin settings
    var sm_settings = require("sharemaps/settings");
    var google_maps_api = sm_settings['google_maps_api'];

    // require the autocomplete only if google_maps_api is enabled
    if (google_maps_api === true) {
        require('sm_leaflet_autocomplete');
        require('sm_leaflet_google_mutant');
    }

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

        // create the tile layer with correct attribution
        var osmUrl='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        var osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
        var osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
        map.addLayer(osm);

        // add full view control
        map.addControl(new L.Control.Fullscreen());

        if (google_maps_api === true) {
            // replace with https://github.com/smeijer/leaflet-geosearch
            // autocomplete
            new L.Control.GPlaceAutocomplete({
                callback: function(place){
                    var loc = place.geometry.location;
                    map.setView(new L.LatLng(loc.lat(), loc.lng()), 18);
                    // var home_marker = L.marker([loc.lat(), loc.lng()], {draggable: 'true'}).addTo(map);
                }
            }).addTo(map);
            
            // map layers
            var roadMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type:'roadmap'
            }); //.addTo(map);  // addTo(map) set it as default layer

            var satMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type:'satellite'
            });        
            var terrainMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type:'terrain'
            });        
            var hybridMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type:'hybrid'
            });
        
            var trafficMutant = L.gridLayer.googleMutant({
                maxZoom: 24,
                type:'roadmap'
            });
            trafficMutant.addGoogleLayer('TrafficLayer');
        
            L.control.layers({
              OpenStreetMap: osm,
              Roadmap: roadMutant,
              Aerial: satMutant,
              Hybrid: hybridMutant,
              Terrain: terrainMutant,
              Traffic: trafficMutant
            }, {}, {
                collapsed: true
            }).addTo(map);            
        }

        var map_url = $("#murl").data("murl");  // get the map URL
        var map_type = $("#mtype").data("mtype");   // get the map file type

        if (map_type == 'gpx') {
            new L.GPX(map_url, {
                async: true,
                marker_options: {
                  startIconUrl: '/mod/sharemaps/graphics/pin-icon-start.png',
                  endIconUrl: '/mod/sharemaps/graphics/pin-icon-end.png',
                  wptIconUrls: '/mod/sharemaps/graphics/pin-icon-wpt.png',
                  shadowUrl: '/mod/sharemaps/graphics/pin-shadow.png'
                }
            }).on('loaded', function(e) {
                map.fitBounds(e.target.getBounds());
            }).addTo(map);
        }
        else if (map_type == 'kml') {
            fobject = new L.KML(map_url, {
                async: true
            }).on('loaded', function (e) {
                map.fitBounds(e.target.getBounds());
            })
            .addTo(map);
        }

        var map_objects = $("#mobjects").data("mobjects");   // get the map objects
        L.geoJSON(map_objects, {}).addTo(map);
                    
    });
    
});

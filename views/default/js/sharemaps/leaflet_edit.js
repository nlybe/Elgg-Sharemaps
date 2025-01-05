define(['jquery', 'elgg', 'sharemaps/settings', 'elgg/security', 'elgg/system_messages', 'sm_leaflet_js', 'sm_leaflet_gpx', 'sm_leaflet_kml', 'sm_leaflet_draw', 'sm_dropzone', 'sm_leaflet_fullscreen', 'sm_leaflet_autocomplete', 'sm_leaflet_googlemutant'], function ($, elgg, sm_settings, security, system_messages) {

    // require('sm_leaflet_js');
    // require('sm_leaflet_gpx');
    // require('sm_leaflet_kml');
    // require('sm_leaflet_draw');
    // require('sm_dropzone');
    // require('sm_leaflet_fullscreen');

    // get plugin settings
    // var sm_settings = require("sharemaps/settings");
    var google_maps_api = sm_settings['google_maps_api'];
    var leafletjs_toolbox_enabled = sm_settings['leafletjs_toolbox_enabled'];

    // require the autocomplete only if google_maps_api is enabled
    // if (google_maps_api === true) {
    //     require(['sm_leaflet_autocomplete', 'sm_leaflet_googlemutant']);
    // }

    // Initialise the FeatureGroup to store editable layers
    var drawnItems = new L.FeatureGroup();
    // Initialise the variable required for file object
    var file_obj;
    var popupArray = {};

    Dropzone.autoDiscover = false;

    // initialize status
    jQuery(function() {
 
        // initialize map
        // var map = L.map('mapid').setView([map_default_lat, map_default_lng], map_default_zoom);
        // var map = L.map('mapid').setView([51.505, -0.09], 13);        
        var map = L.map('mapid').fitWorld();
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // create the tile layer with correct attribution
        var osmUrl='https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        var osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
        var osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
        map.addLayer(osm);

        // var template = '<form id="popup-form">\
        //     <label for="action">Label:</label>\
        //     <input class="form-control" name="action" id="action" type="text">\
        //     <button id="button-submit"  class="btn btn-default" type="button">Save</button>\
        //     </form>';
        
        // map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.

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

        if (leafletjs_toolbox_enabled) {
            var drawControl = new L.Control.Draw({
                position: 'topleft',            
                draw: {
                    polygon: true,
                    // disable toolbar item by setting it to false
                    polyline: true,
                    circle: false,  // in order to enable, first check https://stackoverflow.com/questions/18014907/leaflet-draw-retrieve-layer-type-on-drawedited-event
                    circlemarker: false, 
                    rectangle: true,
                    marker: {
                    // icon: treeMarker
                    }
                },
                edit: {
                    featureGroup: drawnItems
                }
            });
            map.addControl(drawControl); 
        

            map.on(L.Draw.Event.CREATED, function (e) {
                var layer = e.layer;
                    type = e.layerType;

                var layer_id = drawnItems.getLayerId(layer); 
                // layers_arr_label[layer_id]='';
                layer.bindPopup("<input name='layer_"+layer_id+"' id='layer_"+layer_id+"' type='text'>").openPopup();
                drawnItems.addLayer(layer);
            });     
        
            map.on('L.Draw.Event.DELETED', function (e) {
                var layers = e.layers;
            });
        }

        // // update LatLng value
        // map.on('draw:edited', function (e) {
        //     var layers = drawnItems;

        //     layers.eachLayer(function (layer) {
        //         // do whatever you want to each layer, here update LatLng
        //         if (layer instanceof L.Marker) {
        //             layer.bindPopup('skata');
        //             // var bounds = layer.getBounds();
        //             // layer.bindPopup(bounds.getNorthWest().toString() +  " NW<br>" + bounds.getSouthEast().toString() + " SE");
        //         }
        //     });
        // });
    
        // map.on('L.Draw.Event.EDITED', function (e) {
        //     var layers = e.layers;
        //     // layers.eachLayer(function (layer) {
        //     //     //do whatever you want; most likely save back to db
        //     // });
        // });   
 
        // drawnItems.eachLayer(function(layer) {
        //     layer.bindPopup(layer._leaflet_id);
        //     // layer.bindPopup(drawnItems.getLayerId(layer));
        //     // layer.on('click', function(){
        //     //   alert(drawnItems.getLayerId(layer))
        //     // });
        // });
            
        // load the file maps
        file_obj = loadFileMap(map, 'undefined');
        
        // add existing map object to map throught the editable FeatureGroup drawnItems
        var map_objects = $('#map_objects').val();
        var map_objects_json = isJson(map_objects);
        if (map_objects_json) {
            var geojsonLayer = L.geoJson(map_objects_json);
            geojsonLayer.eachLayer(function(l){   
                var json_data = l.toGeoJSON();
                // console.log(json_data);
                if (json_data.properties && json_data.properties.popupContent) {
                    // layer_id = l._leaflet_id;
                    // console.log('--->'+layer_id);
                    l.bindPopup("<input name='layer_"+l._leaflet_id+"' id='layer_"+l._leaflet_id+"' type='text' value='"+json_data.properties.popupContent+"'>").openPopup();
                    // l.bindPopup(json_data.properties.popupContent);
                }
                else {
                    l.bindPopup("<input name='layer_"+l._leaflet_id+"' id='layer_"+l._leaflet_id+"' type='text'>").openPopup();
                }
                l.on('popupclose', onMarkerClick );

                // popupclose
                drawnItems.addLayer(l);
            });
        }

        function onMarkerClick(e) {
            var popup = e.target.getPopup();
            var chart_div = document.getElementById("layer_"+e._leaflet_id);
            popup.setContent( chart_div );
            popupArray[e._leaflet_id] = chart_div;
        }
        
        // if (map_objects_json) {
        //     var geojsonLayer = L.geoJson(map_objects_json);
        //     geojsonLayer.eachLayer(
        //         function(l){            
        //             var json_data = l.toGeoJSON();        
        //             drawnItems.addLayer(L.geoJSON(json_data, {
        //                 onEachFeature: onEachFeature
        //             }));
        //     });            
        // }
        // finally add the drawnItems to the map
        map.addLayer(drawnItems);

        $('.elgg-form-sharemaps-edit').each(function(){
            $(this).submit(function(e){
                var myLayer = L.geoJSON()
                drawnItems.eachLayer(function(layer) {
                    // // we close popup for saving current content
                    // layer.closePopup();
                    // console.log('start '+layer._leaflet_id);
                    var tooltip = popupArray[layer._leaflet_id];
                    // layer.openPopup();
                    // var popup = layer.getPopup();
                    // var content = popup.getContent();
                    // console.log('xxx-->'+layer._leaflet_id+' - '+content);
                    // tooltip = document.getElementById("layer_"+layer._leaflet_id).value;
                    // console.log('yyy-->'+tooltip+' - '+layer._leaflet_id);
                    // // console.log($('#layer_'+layer._leaflet_id).val());
                    var json_data = layer.toGeoJSON();
                    if (Boolean(tooltip)) {
                        // console.log('yes --> '+layer._leaflet_id + ' - '+tooltip);
                        json_data.properties.popupContent = tooltip;
                    }
                    else {
                        // console.log('no --> '+layer._leaflet_id + ' - '+tooltip);
                        json_data.properties.popupContent = '';
                    }
                    
                    // json_data['properties']['mtype'] = markers_arr[drawnItems.getLayerId(layer)];
                    myLayer.addData(json_data);
                });
        
                var textOut = JSON.stringify(myLayer.toGeoJSON());
                // console.log(textOut);
                $("#map_objects").val(textOut);  
                    
                // $("#map_center_lat").val(map.getCenter().lat); 
                // $("#map_center_lng").val(map.getCenter().lng); 
                // $("#map_zoom").val(map.getZoom());
                // e.preventDefault();
                // return  false;
            });
        });  

        // Dropzone: The recommended way from within the init configuration:
        $(function() {
            var guid = $('#guid').val();
            var action_url = security.addToken(elgg.normalize_url("action/sharemaps/upload?guid="+guid));
            // console.log(action_url);
            $("#file_upload").dropzone({
                maxFiles: 2000,
                url: action_url,
                success: function (file, response) {
                    var json = JSON.parse(response);
                     if (json['error']) {
                        elgg.register_error(json['status_msg']);
                    }
                    else {
                        if (file_obj !== undefined) {
                            file_obj.remove();
                        }
                        file_obj = loadFileMap(map, json['map_type']);
                        system_messages.success(json['status_msg']);
                    }
                },
            });
        })
    });  
});

/**
 * Check if given string is in json format
 * 
 * @param {*} str 
 */
function isJson(str) {
    try {
        var map_objects_json = JSON.parse(str);
    } catch (e) {
        return false;
    }
    return map_objects_json;
}

/**
 * Load the file maps, if exists
 * 
 * @param {*} map  
 */
function loadFileMap(map, map_type)  {
    var map_url = $("#murl").data("murl");  // get the map URL
    var fobject;
    
    // if the map_type is not given, get it from mtype element
    if (map_type == 'undefined') {
        map_type = $("#mtype").data("mtype");   // get the map file type
    }

    if (map_type == 'gpx') {
        fobject = new L.GPX(map_url, {
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

        return fobject;
    }
    else if (map_type == 'kml') {

        fobject = new L.KML(map_url, {
            async: true
        }).on('loaded', function (e) {
            map.fitBounds(e.target.getBounds());
        })
        .addTo(map);
        // L.control.layers({}, {'Track': track}, {collapsed: false}).addTo(map);

        return fobject;
    } 

    return false;
}

// function onEachFeature(feature, layer) {
//     // does this feature have a property named popupContent?
//     if (feature.properties && feature.properties.popupContent) {
//         layer.bindPopup(feature.properties.popupContent);
//     }
// }

// /**
//  * 
//  * @param {*} layer_id  
//  */
// function layerSetLabel(layer_id, layers_arr_label)  {
//     // if (drawnItems.hasLayer(layer_id)) {
//     //   var current = drawnItems.getLayer(layer_id);
//         layers_arr_label[layer_id]=$('#layer_'+layer_id).val();
//         console.log(layers_arr_label[layer_id]);
//         // console.log($('#layer_'+layer_id).val());
//     // }
//     // console.log(layer_id);
// }
// http://embed.plnkr.co/8qVoW5/
// https://stackoverflow.com/questions/39657887/collect-leaflet-draw-created-data-properties-attribute-from-a-popup-to-feature

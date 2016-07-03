define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    require('sharemaps_googleapis_js');
    
    var map_settings = require("sharemaps/settings");
    var coords = map_settings['sm_default_coords'].split(',')

    $( document ).ready(function() {
        var map_url = $('#map_url').text();
        
        var myLatlng = new google.maps.LatLng(coords[0],coords[1]);
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: myLatlng
        });

        var ctaLayer = new google.maps.KmlLayer({
          url: map_url,
          map: map
        });
    });

});


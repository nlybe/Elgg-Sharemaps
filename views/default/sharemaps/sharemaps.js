define(function (require) {
	var elgg = require('elgg');
	var $ = require('jquery');
	require('sharemaps_googleapis_js');

    $( document ).ready(function() {
        var map_url = $('#map_url').text();
        
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: 37.885798, lng: 24.832000}
        });

        var ctaLayer = new google.maps.KmlLayer({
          url: map_url,
          map: map
        });
    });

});

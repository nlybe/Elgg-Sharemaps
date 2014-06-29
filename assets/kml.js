function initialize(kmlmap) {
  var chicago = new google.maps.LatLng(35.354442,24.801029);
  var myOptions = {
    zoom: 11,
    center: chicago,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  var ctaLayer = new google.maps.KmlLayer(kmlmap);
  ctaLayer.setMap(map);
}


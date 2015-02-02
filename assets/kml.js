function initialize(kmlmap) {
  var cpoint = new google.maps.LatLng(37.885798, 24.832000);
  var myOptions = {
    zoom: 2,
    center: cpoint,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

  var ctaLayer = new google.maps.KmlLayer(kmlmap);
  ctaLayer.setMap(map);
}


	function searchLocation() {
		GMaps.geocode({
			address: $("#address").val().trim(),
			callback: function(results, status){
				if(status=="OK"){
					var latlng = results[0].geometry.location;
					map.setCenter(latlng.lat(), latlng.lng());
				}
			}
		});		
	}
	
	function stopRKey(evt) {
	  var evt = (evt) ? evt : ((event) ? event : null);
	  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
	  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
	}

	document.onkeypress = stopRKey;
	
	function validateDrawForm(errormsg) {
		//var x = document.forms["myForm"]["fname"].value;
		var x = $("#map_title").val().trim();
		if (x == null || x == "") {
			alert(errormsg);
			return false;
		}
	}	

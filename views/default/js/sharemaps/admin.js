define(function (require) {
    var elgg = require('elgg');
    var $ = require('jquery');
    
    jQuery(function() {
        // initialize profile types box
        changeGoogleStatus();
        
        jQuery('#google_maps_api').on('change',function () {
            changeGoogleStatus();      
        });
    });
    
    function changeGoogleStatus() {
        if($("#google_maps_api").is(':checked')) {
            $("#google_maps_api_key").prop( "disabled", false );
            $("#google_maps_api_key").css("background-color", "white");
        }
        else {
            $("#google_maps_api_key").prop( "disabled", true );
            $("#google_maps_api_key").css("background-color", "#F8F8F8");
        }  
    }    
});

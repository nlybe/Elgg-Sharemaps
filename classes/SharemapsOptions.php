<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

class SharemapsOptions {

    const PLUGIN_ID = 'sharemaps';    // current plugin ID
    const SM_YES = 'yes';  // general purpose yes
    const SM_NO = 'no';    // general purpose no
    const MAP_LOCATION_BEFORE = 'before';   // general purpose string for before  
    const MAP_LOCATION_AFTER = 'after';    // general purpose string for after
    const MAP_DEFAUL_HEIGHT = 500;    // map default height

    /**
     * Get param value from settings
     * 
     * @return type
     */
    Public Static function getParams($setting_param = ''){
        if (!$setting_param) {
            return false;
        }
        
        return trim(elgg_get_plugin_setting($setting_param, self::PLUGIN_ID)); 
    }  

    /**
     * Check if the given map type is active in settings
     * 
     * @return boolean
     */
    Public Static function isTypeActive($map_type) {
        if (!$map_type) {
            return false;
        }
        
        $get_param = trim(elgg_get_plugin_setting($map_type, self::PLUGIN_ID));
        if ($get_param === self::SM_YES) {
            return true;
        }
            
        return false;
    }    

    /**
     * Register post buttons, depending on settings
     * 
     * @return boolean
     */
    Public Static function getPostButtons() {
        $sm_post_buttons = elgg_get_config('sm_post_buttons');
        foreach ($sm_post_buttons as $name => $type_info) {
            elgg_register_title_button('maps', $type_info['button']);
        }
            
        return true;
    }
    
    /**
     * Get an array containing allowed map file types
     * 
     * @return array
     */
    Public Static function getAllowedMapFiles() {
        return  [
            'application/vnd.google-earth.kml+xml',
            'application/vnd.google-earth.kmz',
            'application/gpx+xml',
            'text/xml',
        ];
    }    

    /**
     * Get the LeafletJS version to use, as has been defined in settings
     * 
     * @return string
     */
    Public Static function getLeafletJSVersion() {
        return self::getParams('leafletjs_version');
    }
    
    /**
     * Get the Leaflet Draw version to use, as has been defined in settings
     * 
     * @return string
     */
    Public Static function getLeafletDrawVersion() {
        return self::getParams('leaflet_draw_version');
    }
    
    /**
     * Get height of the map, as has been defined in settings
     * 
     * @return string
     */
    Public Static function getMapHeight() {
        $map_height = self::getParams('map_height');
        if (!$map_height || !is_numeric($map_height)) {
            $map_height = self::MAP_DEFAUL_HEIGHT;
        }

        return $map_height;
    } 

    /**
     * Check if Google API i enabled
     * 
     * @return boolean
     */
    Public Static function isGoogleAPIEnabled() {
        $get_param = trim(elgg_get_plugin_setting('google_maps_api', self::PLUGIN_ID));
        if ($get_param === self::SM_YES) {
            return true;
        }
            
        return false;
    }  

    /**
     * Get the Google API key
     * 
     * @return string
     */
    Public Static function getGoogleAPIKey() {
        return trim(self::getParams('google_maps_api_key'));
    }
}

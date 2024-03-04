<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

return [

    'sharemaps' => "Maps",
    'sharemaps:menu' => "Maps",
    'sharemaps:settings:no' => "No",
    'sharemaps:settings:yes' => "Yes", 
    'sharemaps:all' => "All site maps",
    'sharemaps:add' => 'Create map',
    'add:object:sharemaps' => 'Create map',
    'collection:object:sharemaps' => 'Maps',
    'collection:object:sharemaps:friends' => 'Friends\' maps',
    'collection:object:sharemaps:group' => 'Group maps',
    'collection:object:sharemaps:owner' => '%s\'s maps',
    'item:object:sharemaps' => 'Maps',
	'add:object:map' => "Add a map",
    'edit:object:map' => "Edit map",
    'river:object:sharemaps:create' => '%s added map %s',
	'river:object:sharemaps:comment' => '%s commented on map %s',
    'groups:tool:sharemaps' => 'Enable group maps',
    'sharemaps:numbertodisplay' => 'Number of maps to display',
	
    // form
    'sharemaps:add:requiredfields' => "Fields with an asterisk (*) are required",
    'sharemaps:add:title:help' => "Set the title of the map",
    'sharemaps:add:description:help' => "Enter a description for the map",
    'sharemaps:add:tags:help' => "Enter some keywords which describe this map",
    'sharemaps:add:file:help' => 'Load a GPX or KML file on the map. The file will be loaded automatically on the map and will replace any existing.<br />You can convert your files between GPX and KML at <a href="https://gpx2kml.com" target="_blank" title="Convert gpx file to kml">http://gpx2kml.com</a>.',
    'sharemaps:add:file:help:noentity' => 'You have to save you map first in order to be able to upload a map file. ',
    'sharemaps:add:smap' => "Map drawing",
    'sharemaps:add:smap:help' => "Create the map elements using the toolbar on the left side. Optionally you can load a GPX or KML file on the map.",
    
    // status messages
    'sharemaps:save:success' => "Your map was successfully saved",
    'sharemaps:upload:success' => "The uploaded file was successfully load on map",

    // errror messages
    'sharemaps:none' => "No maps",
    'sharemaps:save:missing_title' => "Title is missing. Map cannot be saved.",
    'sharemaps:save:failed' => "An error occured. Your map could not be saved.",
    'sharemaps:save:file:invalid' => 'Invalid map file type. It must be gpx or kml.',
    'sharemaps:unknown_map' => 'Cannot find specified map',
    'sharemaps:file:uploadfailed' => "Sorry; we could not save your file.",
    'sharemaps:download:failed' => "Sorry, this map is not available at this time.",
    
    // Widgets
	'widgets:sharemaps:name' => 'Maps',
	'widgets:sharemaps:description' => "Display your latest maps.",

    // settings
    'sharemaps:settings:before' => "Before",
    'sharemaps:settings:after' => "After",   
    // 'sharemaps:settings:google_maps' => 'Google Maps settings',
    // 'sharemaps:settings:default_coords' => 'Default Location Coordinates', 
    // 'sharemaps:settings:default_coords:help' => 'Enter default location coordinates. Enter latitude and longitude comma seperated, e.g. <strong>35.516426,24.017444</strong>',    
    'sharemaps:settings:leafletjs_version' => 'LeafletJS version',
    'sharemaps:settings:leafletjs_version:help' => 'Enter the LeafletJS version, e.g. 1.5.1. The available releases are list at <a href="https://github.com/Leaflet/Leaflet/blob/master/CHANGELOG.md" target="_blank">Leaflet Changelog</a>.',
    'sharemaps:settings:leaflet_draw_version' => 'Leaflet Draw version',
    'sharemaps:settings:leaflet_draw_version:help' => 'Leaflet Draw is a vector drawing plugin for Leaflet. Enter the Leaflet Draw version, e.g. 1.0.4. The available releases are list at <a href="https://cdnjs.com/libraries/leaflet.draw" target="_blank">Leaflet Draw library</a>.',
    'sharemaps:settings:map_height' => 'Height of map',
    'sharemaps:settings:map_height:help' => 'Enter a numeric value for height in pixels (e.g. 500) or % (e.g. 100%)',
    'sharemaps:settings:google_maps_api' => 'Enable Google API?', 
    'sharemaps:settings:google_maps_api:help' => 'Enable this if want to make available Google map layers (e.g. map, satelite, terain etc). Also an autocomplete search box will become available.',
    'sharemaps:settings:google_maps_api_key' => 'Google API key',
    'sharemaps:settings:google_maps_api_key:help' => 'Go to <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">https://developers.google.com/maps/documentation/javascript/tutorial#api_key</a> to get your "Google API key". <br /><strong>Note:</strong> the API key is NOT required. Only if you want stats on your api usage, or if you have a paid API account the key is needed',
    'sharemaps:settings:map_location' => 'Display map before or after description', 
    'sharemaps:settings:map_location:help' => 'Select where to display the map regarding the description of post. Default value is "before".',
    'sharemaps:settings:leafletjs_toolbox_enabled' => 'Enable LeafletJS toolbox? (beta)', 
    'sharemaps:settings:leafletjs_toolbox_enabled:help' => 'Enable this if want to eneble the LeafletJS toolbox when edit a map. When changing this, you should invalidate the cache in order to  take effect. This is a beta feature.',
    
];


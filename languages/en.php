<?php
/**
 * Elgg ShareMaps plugin
 * @package sharemaps
 */

$english = array(

    //Menu items and titles
    'sharemaps' => "Maps",
    'sharemaps:menu' => "Maps",
    'sharemaps:user' => "%s's maps",
    'sharemaps:friends' => "Friends' maps",
    'sharemaps:all' => "All site maps",
    'sharemaps:edit' => "Edit map",
    'sharemaps:more' => "More maps",
    'sharemaps:list' => "list view",
    'sharemaps:group' => "Group maps",
    'sharemaps:gallery' => "gallery view",
    'sharemaps:gallery_list' => "Gallery or list view",
    'sharemaps:num_files' => "Number of maps to display",
    'sharemaps:user:gallery'=>'View %s gallery',
    'sharemaps:upload' => "Upload a map",
    'sharemaps:replace' => 'Replace map content (leave blank to not change file)',
    'sharemaps:list:title' => "%s's %s %s",
    'sharemaps:title:friends' => "Friends'",
    'sharemaps:invalid:entity' => "Invalid map entity",

    'sharemaps:add' => 'Upload a map',

    'sharemaps:file' => "Map",
    'sharemaps:title' => "Title",
    'sharemaps:desc' => "Description",
    'sharemaps:tags' => "Tags",

    'sharemaps:list:list' => 'Switch to the list view',
    'sharemaps:list:gallery' => 'Switch to the gallery view',

    'sharemaps:types' => "Uploaded file types",

    'sharemaps:type:' => 'Maps',
    'sharemaps:type:all' => "All map",
    'sharemaps:type:general' => "General",

    'sharemaps:widget' => "Sharemaps widget",
    'sharemaps:widget:description' => "Showcase your latest maps",

    'groups:enablemaps' => 'Enable group maps',

    'sharemaps:download' => "Download this",

    'sharemaps:delete:confirm' => "Are you sure you want to delete this map?",

    'sharemaps:tagcloud' => "Tag cloud",

    'sharemaps:display:number' => "Number of maps to display",

    'river:create:object:sharemaps' => '%s uploaded the map %s',
    'river:comment:object:sharemaps' => '%s commented on the map %s',
    'river:create:object:drawmap' => '%s created the map %s',
    
    'item:object:sharemaps' => 'Maps',
    'item:object:drawmap' => 'Maps',

    'sharemaps:newupload' => 'A new map has been uploaded',
    'sharemaps:notification' =>
'%s uploaded a new map:

%s
%s

View and comment on the new map:
%s
',

    //Status messages
    'sharemaps:saved' => "Your map was successfully saved.",
    'sharemaps:deleted' => "Your map was successfully deleted.",

    //Error messages
    'sharemaps:none' => "No maps.",
    'sharemaps:uploadfailed' => "Sorry; we could not save your map.",
    'sharemaps:downloadfailed' => "Sorry; this map is not available at this time.",
    'sharemaps:deletefailed' => "Your map could not be deleted at this time.",
    'sharemaps:noaccess' => "You do not have permissions to change this map",
    'sharemaps:cannotload' => "There was an error uploading the map",
    'sharemaps:nofile' => "You must select a map file",
    'sharemaps:nokmlfile' => "Invalid file type. File type must be Google Earth KML or KMZ",
    'sharemaps:noaccesstofilemap' => "No access to file map",
    'sharemaps:add:noaccessforpost' => "No valid access for this action",

    // settings
    'sharemaps:settings:no' => "No",
    'sharemaps:settings:yes' => "Yes",   
    'sharemaps:settings:google_maps' => 'Google Maps settings',
    'sharemaps:settings:google_api_key' => 'Enter your Google API key',
    'sharemaps:settings:google_api_key:help' => 'Go to <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">https://developers.google.com/maps/documentation/javascript/tutorial#api_key</a> to get your "Google API key". <br />(<strong>Note:</strong> the API key is NOT required. Only if you want stats on your api usage, or if you have a paid API account the key is needed)',
    'sharemaps:settings:map_width' => 'Width of map',
    'sharemaps:settings:map_width:help' => 'Numeric value (e.g. 500) or % (e.g. 100%)',
    'sharemaps:settings:map_height' => 'Height of map',
    'sharemaps:settings:map_height:help' => 'Numeric value (e.g. 500)',
    'sharemaps:settings:map_upload' => 'Enable upload of Maps', 
    'sharemaps:settings:map_upload:help' => 'Select yes if allow the upload of map files like .kml or .gpx',
    'sharemaps:settings:map_creation' => 'Enable Creation of Maps', 
    'sharemaps:settings:map_creation:help' => 'Select yes if allow the creation of maps online',    
    'sharemaps:settings:gmaps_links' => 'Enable Google Maps Links', 
    'sharemaps:settings:gmaps_links:help' => 'Select yes if allow to insert Google Maps Links in iframe',    
    
    // embed maps
    'sharemaps:embed' => 'Insert a google map link',
    'sharemaps:addembed' => 'Insert a google map link',
    'sharemaps:gmaplink' => 'Google map link',
    'sharemaps:gmaplinkhowto' => 'Copy URL from your google map <strong>Embed map</strong> option and paste here (NO SHORT URL)',
    'sharemaps:gmaphowtouploadkml' => 'File type must be Google Earth KML or KMZ. You can convert your .gpx file at <a href="http://gpx2kml.com" target="_blank" title="Convert gpx file to kml">http://gpx2kml.com</a>.',
    'sharemaps:gmaplinknovalid' => 'URL you entered is not valid',
    'sharemaps:gmaplinknomapsgooglecom' => 'No valid google map link',
    'sharemaps:nogmaplink' => 'Google map link is empty',
    'sharemaps:dosekapoiotitle' => 'Title is empty. Enter a title.',
    
    // draw maps
    'sharemaps:drawmap' => 'Create map',
    'sharemaps:drawmap/add' => 'Create map',
    'item:object:drawmap' => 'Create maps',
    'item:object:drawmapobject' => 'Draw maps objects',
    'sharemaps:drawmap:save' => 'Save map',
    'sharemaps:drawmap:draw' => 'Select shapes from list below to add to the map',
        
    // gpx files
    'sharemaps:novalidfile' => "Invalid file type. File type must be .gpx or Google Earth KML or KMZ",
    'sharemaps:gmaphowtouploadgpxkml' => 'File type must be GPX or Google Earth KML or KMZ. You can convert your files between GPX and KML at <a href="http://gpx2kml.com" target="_blank" title="Convert gpx file to kml">http://gpx2kml.com</a>.',
);

add_translation("en", $english);

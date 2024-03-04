<?php
/**
 * Elgg Sharemaps plugin
 * @package sharemaps 
 */

return [

    'sharemaps' => "Χάρτες",
    'sharemaps:menu' => "Χάρτες",
    'sharemaps:settings:no' => "Όχι",
    'sharemaps:settings:yes' => "Ναι", 
    'sharemaps:all' => "Όλοι οι χάρτες",
    'sharemaps:add' => 'Προσθήκη χάρτη',
    'add:object:sharemaps' => 'Προσθήκη χάρτη',
    'collection:object:sharemaps' => 'Χάρτες',
    'collection:object:sharemaps:friends' => 'Χάρτες φίλων',
    'collection:object:sharemaps:group' => 'Χάρτες ομάδας',
    'collection:object:sharemaps:owner' => 'Χάρτες χρήστη %s',
    'item:object:sharemaps' => 'Χάρτες',
	'add:object:map' => "Προσθήκη χάρτη",
    'edit:object:map' => "Επεξεργασία χάρτη",
    'river:object:sharemaps:create' => '%s πρόσθεσε το χάρτη %s',
	'river:object:sharemaps:comment' => '%s σχολίασε το χάρτη %s',
    'groups:tool:sharemaps' => 'Ενεργοποίηση χαρτών ομάδας',
    'sharemaps:numbertodisplay' => 'Αριθμός χαρτών για εμφάνιση',
	
    // form
    'sharemaps:add:requiredfields' => "Τα πεδία με αστερίσκο (*) είναι υποχρεωτικά",
    'sharemaps:add:title:help' => "Εισάγετε τίτλο του χάρτη",
    'sharemaps:add:description:help' => "Εισάγετε περιγραφή του χάρτη",
    'sharemaps:add:tags:help' => "Εισάγετε λέξεις κλειδιά για το χάρτη",
    'sharemaps:add:file:help' => 'Φορτώστε ένα αρχείο GPX ή KML στο χάρτη. Το αρχείο θα αντικαταστήσει αυτόματα οποιοδήποτε τυχόν προϋπάρχει.<br />Για μετατροπή αρχείου μεταξύ GPX και KML μπορείτε να χρησιμοποιήσετε την υπηρεσία <a href="https://gpx2kml.com" target="_blank" title="Μετατροπή αρχείου μεταξύ gpx και kml">http://gpx2kml.com</a>.',
    'sharemaps:add:file:help:noentity' => 'Πρέπει πρώτα να αποθηκεύσετε το χάρτη ώστε να μπορέσετε να φορτώσετε αρχείο GPX ή KML.',
    'sharemaps:add:smap' => "Επεξεργασία χάρτη",
    'sharemaps:add:smap:help' => "Δημιουργείστε επιπλέον στοιχεία στο χάρτη χρησιμοποιώντας την εργαλειοθήκη. Προαιρετικά μπορείτε να φορτώσετε ένα αρχείο GPX ή KML στο χάρτη.",
    
    // status messages
    'sharemaps:save:success' => "Ο χάρτης σας αποθηκεύτηκε επιτυχώς",
    'sharemaps:upload:success' => "Το αρχείο φορτώθηκε επιτυχώς στο χάρτη",

    // errror messages
    'sharemaps:none' => "Δεν βρέθηκαν χάρτες",
    'sharemaps:save:missing_title' => "Δεν εισάγατε τίτλο χάρτη, αδύνατη η αποθήκευση",
    'sharemaps:save:failed' => "Δημιουργήθηκε σφάλμα, αδύνατη η αποθήκευση",
    'sharemaps:save:file:invalid' => 'Μη έγκυρος τύπος αρχείου. Πρέπει να είναι gpx ή kml.',
    'sharemaps:unknown_map' => 'Δεν βρέθηκε ο χάρτης',
    'sharemaps:file:uploadfailed' => "Αποτυχία κατά το ανέβασμα του αρχείου",
    'sharemaps:download:failed' => "Ο χάρτης δεν είναι διαθέσιμος",
    
    // Widgets
	'widgets:sharemaps:name' => 'Χάρτες',
	'widgets:sharemaps:description' => "Εμφάνιση πρόσφατων χαρτών",

    // settings
    'sharemaps:settings:before' => "Πριν",
    'sharemaps:settings:after' => "Μετά",   
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


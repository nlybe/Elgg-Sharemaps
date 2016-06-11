<?php
/**
 * Elgg sharemaps plugin language pack
 *
 * @package ElggShareMaps
 */

$greek = array(

    //Menu items and titles
    'sharemaps' => "Διαδρομές",
    'sharemaps:menu' => "Διαδρομές",
    'sharemaps:user' => "Οι διαδρομές του %s",
    'sharemaps:friends' => "Διαδρομές φίλων",
    'sharemaps:all' => "Όλες οι διαδρομές",
    'sharemaps:edit' => "Επεξεργασία διαδρομής",
    'sharemaps:more' => "Περισσότερες διαδρομές",
    'sharemaps:list' => "προβολή σε μορφή λίστας",
    'sharemaps:group' => "Διαδρομές Μελών Ομάδας",
    'sharemaps:gallery' => "προβολή σε μορφή εικονιδίων",
    'sharemaps:gallery_list' => "προβολή σε μορφή λίστας ή εικονιδίων",
    'sharemaps:num_files' => "Αριθμός χαρτών για εμφάνιση",
    'sharemaps:user:gallery'=>'Προβολή συλλογής του %s',
    'sharemaps:upload' => "Ανέβασμα διαδρομής",
    'sharemaps:replace' => 'Αντικατάσταση αρχείου (αφήστε κενό εάν δεν θέλετε να ανεβάσετε νέο αρχείο)',
    'sharemaps:list:title' => "%s's %s %s",
    'sharemaps:title:friends' => "Φίλοι'",

    'sharemaps:add' => 'Ανέβασμα διαδρομής',

    'sharemaps:file' => "Αρχείο",
    'sharemaps:title' => "Τίτλος διαδρομής",
    'sharemaps:desc' => "Περιγαφή",
    'sharemaps:tags' => "Ετικέτες",

    'sharemaps:list:list' => 'Προβολή σε μορφή λίστας',
    'sharemaps:list:gallery' => 'προβολή σε μορφή εικονιδίων',

    'sharemaps:types' => "Uploaded file types",

    'sharemaps:type:' => 'Διαδρομές',
    'sharemaps:type:all' => "Όλες οι Διαδρομές",
    'sharemaps:type:general' => "Διαδρομές",

    'sharemaps:widget' => "Map widget",
    'sharemaps:widget:description' => "Προβολή πρόσφατων χαρτών",

    'groups:enablemaps' => 'Ενεργοποίηση διαδρομών ομάδας',

    'sharemaps:download' => "Κατέβασε τη διαδρομή",

    'sharemaps:delete:confirm' => "Είστε βέβαιοι για τη διαγραφή του αρχείου?",

    'sharemaps:tagcloud' => "Tag cloud",

    'sharemaps:display:number' => "Αριθμός χαρτών για εμφάνιση",

    'river:create:object:sharemaps' => '%s ανέβασε τη διαδρομή %s',
    'river:comment:object:sharemaps' => '%s σχολίασε τη διαδρομή %s',
    
    'item:object:file' => 'Διαδρομές',

    'sharemaps:newupload' => 'Υπάρχει νέα διαδρομή',
    'sharemaps:notification' =>
    '%s ανέβασε νέα διαδρομή:

    %s
    %s

    Προβολή και σχολιασμός της νέας διαδρομής:
    %s
    ',

    //Status messages
    'sharemaps:saved' => "Το αρχείο αποθηκεύτηκε με επιτυχία.",
    'sharemaps:deleted' => "Το αρχείο διαγράφτηκε με επιτυχία.",

    //Error messages
    'sharemaps:none' => "Δεν υπάρχουν χάρτες.",
    'sharemaps:uploadfailed' => "Αδύνατη η αποθήκευση του χάρτη.",
    'sharemaps:downloadfailed' => "Ο χάρτης δεν είναι διαθέσιμος αυτή τη στιγμή.",
    'sharemaps:deletefailed' => "Ο χάρτης δεν μπορεί να διαγραφεί τώρα.",
    'sharemaps:noaccess' => "Δεν έχετε δικαιώματα αλλαγής του χάρτη",
    'sharemaps:cannotload' => "Σφάλμα κατά το ανέβασμα του αρχείου",
    'sharemaps:nofile' => "Πρέπει να επιλέξετε ένα αρχείο",
    'sharemaps:nokmlfile' => "Το αρχείο πρέπει να είναι τύπου Google Earth KML ή KMZ",
    'sharemaps:noaccesstofilemap' => "Αδύνατη πρόσβαση στο αρχείο του χάρτη",

    // settings
    'sharemaps:settings:google_maps' => 'Google Maps settings',
    'sharemaps:settings:google_api_key' => 'Enter your Google API key',
    'sharemaps:settings:google_api_key:clickhere' => 'Go to <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/tutorial#api_key">https://developers.google.com/maps/documentation/javascript/tutorial#api_key</a> to get your "Google API key". <br />(<strong>Note:</strong> the API key is NOT required. Only if you want stats on your api usage, or if you have a paid API account the key is needed)',
    'sharemaps:settings:map_width' => 'Width of map',
    'sharemaps:settings:map_width:how' => 'Numeric value (e.g. 500) or % (e.g. 100%)',
    'sharemaps:settings:map_height' => 'Height of map',
    'sharemaps:settings:map_height:how' => 'Numeric value (e.g. 500)',
    
    // embed maps
    'sharemaps:embed' => 'Εισάγετε σύνδεσμο από το Google Maps',
    'sharemaps:addembed' => 'Εισάγετε σύνδεσμο από το Google Maps',
    'sharemaps:gmaplink' => 'Σύνδεσμος Google Map',
    'sharemaps:gmaplinkhowto' => 'Κάνετε αντιγραφή το σύνδεσμο από το χάρτη σας στο Google Maps (επιλογή <strong>Embed map</strong>) και επικολλήστε τον εδώ (μην επιλέξετε SHORT URL)',
    'sharemaps:gmaphowtouploadkml' => 'Το αρχείο πρέπει να είναι τύπου Google Earth KML ή KMZ. Μπορείτε να μετατρέψετε αρχεία gpx σε kml στο <a href="http://gpx2kml.com" target="_blank" title="Convert gpx file to kml">gpx2kml.com</a>.',
    'sharemaps:gmaplinknovalid' => 'Μη έγκυρο URL',
    'sharemaps:gmaplinknomapsgooglecom' => 'Μη έγκυρος σύνδεσμος από Google Map',
    'sharemaps:nogmaplink' => 'Δεν εισάγατε Σύνδεσμο Google Map',
    'sharemaps:dosekapoiotitle' => 'Δεν εισάγατε τίτλο',    
    
);

add_translation("el", $greek);
